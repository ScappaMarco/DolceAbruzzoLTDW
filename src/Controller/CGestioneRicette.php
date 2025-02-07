<?php
class CGestioneRicette {
    
    public static function listaRicette() {
        $view_ricette = new VGestioneRicette();
        if (!isset($_GET['page'])) {
            // Redirect to the same URL with ?page=1
            $url = $_SERVER['REQUEST_URI'];
            $url .= '?page=1';
            header("Location: $url");
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if(CUtente::isLogged()) {
            $array_ricette = FPersistentManager::getInstance()->getListRicette($page);
            if($array_ricette['n_ricette'] == 0){
                $view_ricette->listaRicette($array_ricette, 1);
            }else{
                $view_ricette->listaRicette($array_ricette, 0);
            }
        } else {
            header('Location: /Dolce_Abruzzo/utente/login');
        }
    }

    public static function addRicetta() {
        $view_ricette = new VGestioneRicette();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $view_ricette->addRecipeForm();
        } elseif($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }
            $allowed_types = array('image/jpeg', 'image/png');

            if(isset($_FILES['image'])){
                // Controllo se l'immagine inserita eccede la dimensione di 1MB
                if($_FILES['image']['size'] > 1000000) {
                    $view_ricette->errorImageUpload();
                    exit;
                }
                if(!(in_array($_FILES['image']['type'], $allowed_types))) {
                    $view_ricette->errorImageUpload();
                    exit;
                }

                $ricetta = new ERicetta($array_data['titolo'], $array_data['descrizione'], $array_data['procedimento'], $array_data['ingredienti']);
                $found_chef = FPersistentManager::getInstance()->find(EChef::class, $_SESSION['utente']->getIdChef());
                $ricetta->setChefRicetta($found_chef);
                $ricetta->setDifficolta($array_data['difficolta']);
                FPersistentManager::getInstance()->insertRicetta($ricetta);
                $found_ricetta = FPersistentManager::getInstance()->find(ERicetta::class, $ricetta->getId_ricetta());

                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_type = $_FILES['image']['type'];

                $content = file_get_contents($_FILES['image']['tmp_name']);
                $base64content = base64_encode($content);

                $image = new EImmagine($file_name, $file_size, $file_type, $base64content);

                FPersistentManager::getInstance()->insertImmagine($image);

                //trovo l'immagine appena inserita
                $found_image = FPersistentManager::getInstance()->find(EImmagine::class, $image->getIdImage());

                //collega l'immagine alla ricetta
                FPersistentManager::getInstance()->updateImageRicetta($found_ricetta, $found_image);

                $_SESSION['recipe_added'] = true;
                
                header('Location: /Dolce_Abruzzo/gestioneRicette/listaRicette?page=1');
            }
        }
    }

    public static function modificaRicetta($idRicetta) {
        $view_ricetta = new VGestioneRicette();
        $ricetta_da_modificare = FPersistentManager::getInstance()->find(ERicetta::class, $idRicetta);

        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $immagine_ricetta = FPersistentManager::getInstance()->getImageRicetta($ricetta_da_modificare);
            //$immagine_ricetta['imageData'] = stream_get_contents($immagine_ricetta['imageData']);
            $immagine_ricetta->setImageData(stream_get_contents($immagine_ricetta->getImageData()));

            $view_ricetta->modifyRecipeForm($ricetta_da_modificare, $immagine_ricetta);
        } elseif($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }

            $allowed_types = array('image/jpeg', 'image/png');

            if(FPersistentManager::getInstance()->checkForRecipeChanges($postData, $idRicetta)) {
                $_SESSION['recipe_modified'] = true;
            }
            FPersistentManager::getInstance()->updateRicetta($ricetta_da_modificare, $array_data);

            if(isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'])) {
                //FPersistentManager::getInstance()->deleteImageRicetta($idRicetta);
                if($_FILES['images']['size'] > 1000000) {
                    $view_ricetta->errorImageUpload();
                    exit;
                }
                if(!in_array($_FILES['images']['type'], $allowed_types)) {
                    $view_ricetta->errorImageUpload();
                    exit;
                }

                $found_ricetta = FPersistentManager::getInstance()->find(ERicetta::class, $idRicetta);

                $fileName = $_FILES['images']['name'];
                $fileSize = $_FILES['images']['size'];
                $fileType = $_FILES['images']['type'];
                $content = file_get_contents($_FILES['images']['tmp_name']);
                $base64content = base64_encode($content);
                $image = new EImmagine($fileName, $fileSize, $fileType, $base64content);

                FPersistentManager::getInstance()->insertImmagine($image);

                $found_image = FPersistentManager::getInstance()->find(EImmagine::class, $image->getIdImage());

                FPersistentManager::getInstance()->updateImageRicetta($found_ricetta, $found_image);

                //setttao solo se l'immagine viene modificata
                $_SESSION['recipe_modified'] = true;
            }
            
            header('Location: /Dolce_Abruzzo/gestioneRicette/listaRicette?page=1');
        }
    }

    public static function eliminaRicetta($ricettaId) {
        FPersistentManager::getInstance()->deleteRicetta($ricettaId);
        $_SESSION['recipe_deleted'] = true;
        header('Location: /Dolce_Abruzzo/gestioneRicette/listaRicette?page=1');
    }
}