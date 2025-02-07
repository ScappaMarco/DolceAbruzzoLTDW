<?php
class CGestioneProdotti{
    public static function listaProdotti(){
        
        $view = new VGestioneProdotti();
        if (!isset($_GET['page'])) {
            // Redirect to the same URL with ?page=1
            $url = $_SERVER['REQUEST_URI'];
            $url .= '?page=1';
            header("Location: $url");
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $array_prodotti = FPersistentManager::getInstance()->getListProducts($page);
        if($array_prodotti['n_prodotti'] == 0){
            $view->listaProdotti($array_prodotti, 1);
        }else{
            $view->listaProdotti($array_prodotti, 0);
        }
    }
    public static function addProduct(){
        
        $view = new VGestioneProdotti();
        $array_categorie = FPersistentManager::getInstance()->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            
            $view->addProductForm($array_categorie);

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }
            $allowed_types = array('image/jpeg', 'image/png');

            if(isset($_FILES['images'])){
                // Controllo se le immagini inserite eccedono una dimensione di 1MB
                foreach($_FILES['images']['size'] as $key => $value) {
                    if($_FILES['images']['size'][$key] > 1000000){
                        $view->errorImageUpload($array_categorie);
                        exit;
                    }
                }
                // Controllo il tipo di file caricati
                foreach($_FILES['images']['type'] as $key => $value) {
                    if(!(in_array($_FILES['images']['type'][$key], $allowed_types))){
                        $view->errorImageUpload($array_categorie);
                        exit;
                    }
                }

                $prod = new EProdotto($array_data['nome'], $array_data['descrizione'], $array_data['ingredienti'], $array_data['prezzo'], $array_data['punti_fedelta'], $array_data['quantita_disp'],$array_data['is-gluten-free']);
                FPersistentManager::getInstance()->insertProdotto($prod);
                
                // Trova il prodotto appena inserito
                $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $prod->getIdProdotto());
                
                // Inserisci ogni immagine e collegala al prodotto
                foreach($_FILES['images']['tmp_name'] as $key => $value) {
                    $fileName = $_FILES['images']['name'][$key];
                    $fileSize = $_FILES['images']['size'][$key];
                    $fileType = $_FILES['images']['type'][$key];
                    $content = file_get_contents($_FILES['images']['tmp_name'][$key]);
                    $base64content = base64_encode($content);
                    $image = new EImmagine($fileName, $fileSize, $fileType, $base64content);
                        
                    FPersistentManager::getInstance()->insertImmagine($image);
                    
                    // Trova l'immagine appena inserita
                    $found_image = FPersistentManager::getInstance()->find(EImmagine::class, $image->getIdImage());
                    
                    // Collega l'immagine al prodotto
                    FPersistentManager::getInstance()->updateImageProdotto($found_prodotto, $found_image);   
                }
            }

            $found_categoria = FPersistentManager::getInstance()->find(ECategoria::class, $array_data['categoria']);

            FPersistentManager::getInstance()->updateCatProdotto($found_prodotto, $found_categoria);
            $_SESSION['product_added'] = true;
            header('Location: /Dolce_Abruzzo/gestioneProdotti/listaProdotti?page=1');
        }
    }
    public static function modificaProdotto($productId){
        
        $view = new VGestioneProdotti();
        $prodotto_da_modificare = FPersistentManager::getInstance()->find(EProdotto::class, $productId);

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
                
                $array_immagini = FPersistentManager::getInstance()->getAllImages($prodotto_da_modificare);
                $view->modifyProductForm($prodotto_da_modificare, $array_immagini);
            
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }
            $array_categorie = FPersistentManager::getInstance()->getAllCategories();
            $allowed_types = array('image/jpeg', 'image/png');

            if(FPersistentManager::getInstance()->checkForProductChanges($postData, $productId)) {
                $_SESSION['product_modified'] = true;
            }
            FPersistentManager::getInstance()->updateProdotto($prodotto_da_modificare, $array_data);

            if(isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'][0])) {
                //Elimino tutte le immagini nel database relative al prodotto
                FPersistentManager::getInstance()->deleteAllImages($productId);
                // Controllo se le immagini inserite eccedono una dimensione di 1MB
                foreach($_FILES['images']['size'] as $key => $value) {
                    if($_FILES['images']['size'][$key] > 1000000){
                        $view->errorImageUpload($array_categorie);
                        exit;
                    }
                }
                // Controllo il tipo di file caricati
                foreach($_FILES['images']['type'] as $key => $value) {
                    if(!(in_array($_FILES['images']['type'][$key], $allowed_types))){
                        $view->errorImageUpload($array_categorie);
                        exit;
                    }
                }

                // Trova il prodotto appena inserito
                $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $productId);
                
                // Inserisci ogni immagine e collegala al prodotto
                foreach($_FILES['images']['tmp_name'] as $key => $value) {
                    $fileName = $_FILES['images']['name'][$key];
                    $fileSize = $_FILES['images']['size'][$key];
                    $fileType = $_FILES['images']['type'][$key];
                    $content = file_get_contents($_FILES['images']['tmp_name'][$key]);
                    $base64content = base64_encode($content);
                    $image = new EImmagine($fileName, $fileSize, $fileType, $base64content);
                        
                    FPersistentManager::getInstance()->insertImmagine($image);
                    
                    // Trova l'immagine appena inserita
                    $found_image = FPersistentManager::getInstance()->find(EImmagine::class, $image->getIdImage());
                    
                    // Collega l'immagine al prodotto
                    FPersistentManager::getInstance()->updateImageProdotto($found_prodotto, $found_image);   
                    
                }
            }
            $_SESSION['product_modified'] = true;
            header('Location: /Dolce_Abruzzo/gestioneProdotti/listaProdotti?page=1');
        }
    }
    
    public static function eliminaProdotto($productId){
        
        //Elimino prima tutte le immagini legate all'id del prodotto
        //per non avere problemi con le chiavi esterne
        FPersistentManager::getInstance()->deleteAllImages($productId);
        FPersistentManager::getInstance()->deleteProdotto($productId);
        $_SESSION['product_deleted'] = true;
        header('Location: /Dolce_Abruzzo/gestioneProdotti/listaProdotti?page=1');
    }
}
?>