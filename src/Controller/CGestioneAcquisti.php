<?php
class CGestioneAcquisti
{

    public static function shop($categoria){
        $view_acquisto = new VGestioneAcquisti();
    
        // Ottieni l'URL corrente
        $URL = parse_url($_SERVER['REQUEST_URI'])['path'];
        $URL = explode('/', $URL);
        
        $categoria = isset($URL[4]) ? urldecode($URL[4]) : 'all';

        if (!isset($_GET['page'])) {
            // Redirect to the same URL with ?page=1
            $currentUrl = $_SERVER['REQUEST_URI'];
            $separator = (strpos($currentUrl, '?') !== false) ? '&' : '?';
            $url = $currentUrl . $separator . 'page=1';
            header("Location: $url");
            exit();
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        $minPrice = isset($_GET['minPrice']) && $_GET['minPrice'] !== '' ? (float)$_GET['minPrice'] : null;
        $maxPrice = isset($_GET['maxPrice']) && $_GET['maxPrice'] !== '' ? (float)$_GET['maxPrice'] : null;
        $isGlutenFree = isset($_GET['glutenFree']) ? (bool)$_GET['glutenFree'] : false;
        
        if ($categoria == "all") {
            $array_negozio = FPersistentManager::getInstance()->getListProducts($page, 4, $minPrice, $maxPrice, $isGlutenFree);
        } else {
            $array_negozio = FPersistentManager::getInstance()->getListProductsByCat($categoria, $page, 4, $minPrice, $maxPrice, $isGlutenFree);
        }
        
        $array_categoria = FPersistentManager::getInstance()->getAllCategories();
        
        if ($array_negozio['n_prodotti'] == 0) {
            $view_acquisto->shop($array_negozio, $array_categoria, 1, $categoria);
        } else {
            $view_acquisto->shop($array_negozio, $array_categoria, 0, $categoria);
        }
    }
    public static function ricerca(){
        $view_acquisto = new VGestioneAcquisti();
        
        if (isset($_GET['q'])) {
            $query = $_GET['q'];
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            $risultati = FPersistentManager::getInstance()->cercaProdotti($query, $page);
            
            if ($risultati['n_prodotti'] == 0) {
                $view_acquisto->mostraRisultatiRicerca($risultati, $query, true);
            } else {
                $view_acquisto->mostraRisultatiRicerca($risultati, $query, false);
            }
        } else {
            header('Location: /Dolce_Abruzzo/utente/home');
        }
    }
    public static function infoProdotto($idProdotto) {
        if (!isset($_COOKIE['wishlist'])) {
            setcookie('wishlist', json_encode([]), time() + (86400 * 30), "/"); // 30 giorni
        }
        $wishlist = json_decode($_COOKIE['wishlist'], true) ?? [];
        if(in_array($idProdotto, $wishlist)) {
            $_SESSION['is_in_wishlist'] = true;
        }

        if (!isset($_COOKIE['cart'])) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/"); // 30 giorni
        }
        $cart = json_decode($_COOKIE['cart'], true) ?? [];
        if(array_key_exists($idProdotto, $cart)) {
            $_SESSION['is_in_cart'] = true;
        }

        $view_prodotto = new VGestioneAcquisti();
        $prodotto = FPersistentManager::getInstance()->getProductById($idProdotto);
        $immagini = FPersistentManager::getInstance()->getAllImages($prodotto[0]);
        $recensioni = FPersistentManager::getInstance()->getRecensioniByProdotto($idProdotto);
    
        $view_prodotto->infoProdotto($prodotto, $immagini, $cart, $recensioni);
    }

    public static function aggiungiAlCarrello($idProdotto)
    {
        if (!(isset($_COOKIE['cart']))) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $quantita = 1;
        } else {
            $quantita = $_POST['quantity'];
        }
        $carrello = json_decode($_COOKIE['cart'], true);
        if (!(empty($carrello)) || array_key_exists($idProdotto, $carrello)) {
            $carrello[$idProdotto] += $quantita;
        } else {
            $carrello[$idProdotto] = $quantita;
        }
        $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto);
        $quantita_massima = $found_prodotto->getQuantitaDisp();
        if($carrello[$idProdotto] > $quantita_massima) {
            $carrello[$idProdotto] = $quantita_massima;
            $_SESSION['q_max_raggiunta'] = true;
        }
        json_encode($carrello);
        setcookie('cart', json_encode($carrello), time() + (86400 * 30), "/");

        $_SESSION['added_to_cart'] = isset($_SESSION['q_max_raggiunta']) && $_SESSION['q_max_raggiunta'] ? false : true;
        header('Location: /Dolce_Abruzzo/utente/home');
    }

    public static function acquistaSubito($idProdotto){
        if (!(isset($_COOKIE['cart']))) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $quantita = $_POST['quantity'];
        $carrello = json_decode($_COOKIE['cart'], true);
        if (!(empty($carrello)) || array_key_exists($idProdotto, $carrello)) {
            $carrello[$idProdotto] += $quantita;
        } else {
            $carrello[$idProdotto] = $quantita;
        }
        $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto);
        $quantita_massima = $found_prodotto->getQuantitaDisp();
        if($carrello[$idProdotto] > $quantita_massima) {
            $carrello[$idProdotto] = $quantita_massima;
        }
        json_encode($carrello);
        setcookie('cart', json_encode($carrello), time() + (86400 * 30), "/");
        header('Location: /Dolce_Abruzzo/gestioneAcquisti/procediOrdineCarrello');
    }

    public static function cart()
    {
        if (!(isset($_COOKIE['cart']))) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $view_cart = new VGestioneAcquisti();
        $array_prodotti = array();
        $carrello = json_decode($_COOKIE['cart'], true);
        foreach ($carrello as $idProdotto => $quantita) {
            $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto);
            $array_prodotti[] = $found_prodotto;
        }
        $view_cart->cart($array_prodotti, $carrello);
    }

    public static function svuotaCarrello() {
        if (isset($_COOKIE['cart'])) {
            setcookie('cart', 0, time() - 3600, "/"); 
            $_SESSION['carrello_svuotato'] = true;
        }
        header('Location: /Dolce_Abruzzo/utente/home');
    }

    public static function rimuoviDaCarrello($idProdotto) {
        if (!(isset($_COOKIE['cart']))) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $carrello = json_decode($_COOKIE['cart'], true);
        unset($carrello[$idProdotto]);
        $nuovo_carrello = json_encode($carrello);
        setcookie('cart', $nuovo_carrello, time() + (86400 * 30), "/");
        $_SESSION['elemento_rimosso_da_carrello'] = true;
        header('Location: /Dolce_Abruzzo/gestioneAcquisti/cart');
    }

    public static function aggiornaQuantitaCarrello($idProdotto){
        if (!isset($_COOKIE['cart'])) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/"); // 30 giorni
        }
        $carrello = json_decode($_COOKIE['cart'], true);
        $newQuantity = $_POST['quantity'];
        // Aggiorna la quantità nel carrello
        $carrello[$idProdotto] = (int)$newQuantity;

        // Verifica che la nuova quantità non superi la quantità disponibile
        $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto);
        $quantita_massima = $found_prodotto->getQuantitaDisp();

        if ($carrello[$idProdotto] > $quantita_massima) {
            $carrello[$idProdotto] = $quantita_massima;
            $_SESSION['q_max_raggiunta'] = true;
        } else {
            $_SESSION['q_max_raggiunta'] = false;
        }

        // Se la nuova quantità è 0, rimuovi il prodotto dal carrello
        if ($carrello[$idProdotto] == 0) {
            unset($carrello[$idProdotto]);
        }

        // Aggiorna il cookie del carrello
        $nuovo_carrello = json_encode($carrello);
        setcookie('cart', $nuovo_carrello, time() + (86400 * 30), "/");
        $_SESSION['qty_updated'] = true;
        header('Location: /Dolce_Abruzzo/gestioneAcquisti/cart');
    }
    public static function procediOrdineCarrello() {
        $view = new VGestioneAcquisti();
        $carrello = json_decode($_COOKIE['cart'], true);

        $subtotale = 0;
        $punti_fedelta = 0;
        $prodotti = [];
        foreach ($carrello as $idProdotto => $quantita) {
            $prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto);
            $subtotale += $prodotto->getPrezzo() * $quantita;
            $punti_fedelta += $prodotto->getPunti_fedelta() * $quantita;
            $prodotti[] = $prodotto;
        }

        $indirizzi = FPersistentManager::getInstance()->getAllIndirizziUtente($_SESSION['utente']->getIdCliente());
        $carte = FPersistentManager::getInstance()->getAllCarteCredito($_SESSION['utente']->getIdCliente());

        $data = [
            'prodotti' => $prodotti,
            'carrello' => $carrello,
            'subtotale' => $subtotale,
            'punti_fedelta' => $punti_fedelta,
            'indirizzi' => $indirizzi,
            'carte' => $carte
        ];

        if (isset($_POST['applica_sconto'])) {
            $codice_sconto = $_POST['codice_sconto'];
            $sconto = FPersistentManager::getInstance()->verificaSconto($codice_sconto);
            if ($sconto) {
                $data['sconto_applicato'] = true;
                $data['percentuale_sconto'] = $sconto->getValore_sconto();
                $data['totale_scontato'] = $subtotale * (1 - $sconto->getValore_sconto() / 100);
                $data['messaggio_sconto'] = "Sconto del {$sconto->getValore_sconto()}% applicato!";
            } else {
                $data['sconto_applicato'] = false;
                $data['messaggio_sconto'] = "Codice sconto non valido o scaduto.";
            }
            $data['codice_sconto'] = $codice_sconto;
        }

        $view->mostraRiepilogoOrdine($data);
    }

    public static function confermaOrdine() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $indirizzo = explode('|', $_POST['indirizzo']);
            $carta = $_POST['carta'];
            $carrello = json_decode($_COOKIE['cart'], true);
            $codiceSconto = isset($_POST['codice_sconto']) ? $_POST['codice_sconto'] : null;
    
            try {
                $ordine = FPersistentManager::getInstance()->creaOrdine($indirizzo[0], $indirizzo[1], $carta, $carrello, $codiceSconto);
                if ($ordine && $ordine->getId_ordine()) {
                    setcookie('cart', json_encode([]), time() - 3600, '/');  // Clear the cart
                    header('Location: /Dolce_Abruzzo/gestioneAcquisti/ordineCompletato/' . $ordine->getId_ordine());
                    exit();
                } else {
                    // Gestisci il caso in cui l'ordine non è stato creato correttamente
                    throw new Exception("Errore durante la creazione dell'ordine");
                }
            } catch (Exception $e) {
                $_SESSION['errore_ordine'] = $e->getMessage();
                header('Location: /Dolce_Abruzzo/gestioneAcquisti/erroreOrdine');
                exit();
            }
        }
    }
    public static function erroreOrdine(){
        $view = new VGestioneAcquisti();
        $view->erroreOrdine();
    }

    public static function ordineCompletato($idOrdine = null)
    {
        $view = new VGestioneAcquisti();
        
        if ($idOrdine) {
            $ordine = FPersistentManager::getInstance()->find(EOrdine::class, $idOrdine);
        } elseif (isset($_SESSION['ordine_completato'])) {
            $ordine = $_SESSION['ordine_completato'];
            unset($_SESSION['ordine_completato']);
        } else {
            // Gestione dell'errore: nessun ordine trovato
            header('Location: /Dolce_Abruzzo/utente/home');
            exit();
        }

        if ($ordine && $ordine->getCliente()->getIdCliente() == $_SESSION['utente']->getIdCliente()) {
            $view->mostraOrdineCompletato($ordine);
        } else {
            // Gestione dell'errore: ordine non trovato o non appartiene all'utente corrente
            header('Location: /Dolce_Abruzzo/utente/home');
            exit();
        }
    }
    public static function dettaglioOrdine($idOrdine)
    {
        $view_utente = new VGestioneAcquisti();
        $ordine = FPersistentManager::getInstance()->find(EOrdine::class, $idOrdine);
        
        if ($ordine && $ordine->getCliente()->getIdCliente() == $_SESSION['utente']->getIdCliente()) {
            $view_utente->dettaglioOrdine($ordine);
        } else {
            // Gestione dell'errore: ordine non trovato o non appartiene all'utente corrente
            header('Location: /Dolce_Abruzzo/utente/userHistoryOrders');
        }
    }
    public static function aggiungiRecensione($idProdotto) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $canWriteReview = FPersistentManager::getInstance()->canWriteReview($idProdotto);
            if($canWriteReview){
                $testo = $_POST['testo'];
                $valutazione = $_POST['valutazione'];
                $cliente = FPersistentManager::getInstance()->find(ECliente::class, $_SESSION['utente']->getIdCliente());
                
                $recensione = new ERecensione($testo, $valutazione);
                $recensione->setCliente($cliente);
                $recensione->setProdotto(FPersistentManager::getInstance()->find(EProdotto::class, $idProdotto));
                
                FPersistentManager::getInstance()->insertRecensione($recensione);
    
                $_SESSION['review_added'] = true;
            }else{
                $_SESSION['cannot_write_review'] = true;
            }
            
            header('Location: /Dolce_Abruzzo/gestioneAcquisti/infoProdotto/' . $idProdotto);
        }
    }
}
