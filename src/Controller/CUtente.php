<?php
use Doctrine\Common\Collections\ArrayCollection;

class CUtente
{
    public static function home()
    {
        $view_home = new VUtente();
        
        if (!isset($_COOKIE['cart'])) {
            setcookie('cart', json_encode([]), time() + (86400 * 30), "/"); // 30 giorni
        }
        if(!isset($_COOKIE['wishlist'])) {
            setcookie('wishlist', json_encode([]), time() + (86400 * 30), "/"); // 30 giorni
        }
        $array_prodotti = FPersistentManager::getInstance()->getLatestProductsHome();
        $recensioni = FPersistentManager::getInstance()->getAllRecensioni();
        $lenght = count($array_prodotti);
        if(isset($_SESSION['accessDenied']) && $_SESSION['accessDenied']){
            $view_home->accessDenied();
        }else{
            if(static::isLogged()) {
                if($lenght == 0) {
                    $view_home->loginSuccess($array_prodotti, $recensioni, 1);
                } else {
                    $view_home->loginSuccess($array_prodotti, $recensioni, 0);
                }
            } else {
                $view_home->logout($array_prodotti, $recensioni);
            }
        }
    }
    public static function login()
    {
        $view = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (static::isLogged()) {
                header('Location: /Dolce_Abruzzo/utente/home');
            } else {
                $view->showLoginForm();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST['email-log'];
            $password = $_POST['password-log'];
            $cliente = FPersistentManager::getInstance()->findUtente($email);
            if ($cliente == null) {
                $view->loginError();
            } else if (password_verify($password, $cliente[0]->getPassword())) {

                $_SESSION['utente'] = $cliente[0];
                //Gestione dei permessi(services)
                $services = [];
                foreach ($_SESSION['utente']->getRoles() as $role) {
                    foreach ($role->getServices() as $service) {
                        $services[$service->getControllore()][$service->getMetodo()] = ['hasAccess' => true];
                    }
                }
                //Nella sessione mi salvo i controllori e i metodi ai quali l'utente può accedere
                $_SESSION['services'] = $services;
                //print_r($_SESSION['services']);

                if($_SESSION['utente'] instanceof ECliente){
                    foreach($_SESSION['utente']->getRoles() as $role){
                        if($role->getName() == "admin"){
                            header('Location: /Dolce_Abruzzo/gestioneProdotti/listaProdotti');
                        }else{
                            if($role->getName() == "utente_bloccato"){
                                $_SESSION['accessDenied'] = true;
                            }
                            header('Location: /Dolce_Abruzzo/utente/home');
                        }
                    }
                }else if($_SESSION['utente'] instanceof EChef){
                    header('Location: /Dolce_Abruzzo/gestioneRicette/listaRicette');
                }
            } else {
                $view->loginError();
            }
        }
    }
    public static function isLogged()
    {
        $identificato = false;
        // Controlla se il cookie di sessione esiste
        if (isset($_COOKIE['PHPSESSID'])) {
            // Avvia la sessione se non è già avviata
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Controlla se l'utente è loggato basandosi su una variabile di sessione specifica
            if (isset($_SESSION['utente'])) {
                $identificato = true;
            }
        }
        return $identificato;
    }
    public static function userDataForm()
    {
        $view_utente = new VUtente();
        $view_utente->userDataForm();
    }
    public static function userDataSection()
    {
        $view_utente = new VUtente();
        $view_utente->userDataSection();
    }
    public static function userHistoryOrders()
    {
        $view_utente = new VUtente();
        $ordini = FPersistentManager::getInstance()->getOrdiniUtente();
        $view_utente->userHistoryOrders($ordini);
    }
    public static function adminOrderManagement()
    {
        if (!self::isAdmin()) {
            header('Location: /Dolce_Abruzzo/utente/home');
            exit;
        }

        $view_utente = new VUtente();
        $ordini = FPersistentManager::getInstance()->getAllPendingOrders();
        $view_utente->adminOrderManagement($ordini);
    }

    public static function updateOrderStatus()
    {
        if (!self::isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Dolce_Abruzzo/utente/home');
            exit;
        }

        $orderId = $_POST['orderId'];
        $newStatus = $_POST['newStatus'];

        FPersistentManager::getInstance()->updateOrderStatus($orderId, $newStatus);

        header('Location: /Dolce_Abruzzo/utente/adminOrderManagement');
        exit;
    }

    private static function isAdmin()
    {
        return isset($_SESSION['utente']) && $_SESSION['utente'] instanceof ECliente && 
               in_array('admin', array_map(function($role) { return $role->getName(); }, $_SESSION['utente']->getRoles()->toArray()));
    }
    public static function userDiscounts()
    {
        $view_utente = new VUtente();
        $view_utente->userDiscounts();
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /Dolce_Abruzzo/utente/home');
    }

    public static function deleteAccount()
    {
        $utente = $_SESSION['utente'];
        FPersistentManager::getInstance()->deleteUtente($utente);
        session_unset();
        session_destroy();
        header('Location: /Dolce_Abruzzo/utente/home');
    }

    public static function aggiungiAllaWishlist($idProdotto) {
        if (!isset($_COOKIE['wishlist'])) {
            setcookie('wishlist', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $wishlist = json_decode($_COOKIE['wishlist'], true);
        if(!in_array($idProdotto, $wishlist)) {
            $wishlist[] = $idProdotto;
            $_SESSION['added_to_wishlist'] = true;
        } else {
            $_SESSION['added_to_wishlist'] = false;
        }
        /*
        print_r($wishlist);
        exit;*/
        $var = json_encode($wishlist);
        setcookie('wishlist', $var, time() + (86400 * 30), "/");
        header('Location: /Dolce_Abruzzo/utente/home');
    }

    public static function wishlist() {
        if (!isset($_COOKIE['wishlist'])) {
            setcookie('wishlist', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $view_utente = new VUtente();
        $array_prodotti = array();
        $wishlist = json_decode($_COOKIE['wishlist'], true);
        for($i = 0; $i < sizeof($wishlist); $i++) {
            $found_prodotto = FPersistentManager::getInstance()->find(EProdotto::class, $wishlist[$i]);
            $array_prodotti[] = $found_prodotto;
        }
        /*
        print_r($array_prodotti);
        exit;
        */
        $view_utente->wishlist($array_prodotti);
    }

    public static function svuotaListaDesideri() {
        if (isset($_COOKIE['wishlist'])) {
            setcookie('wishlist', 0, time() - 3600, "/"); 
            $_SESSION['lista_desideri_svuotata'] = true;
        }
        header('Location: /Dolce_Abruzzo/utente/home');
    }
    public static function termsAndConditions()
    {
        $view_utente = new VUtente();
        if (static::islogged()) {
            $view_utente->termsAndConditions();
        } else {
            $view_utente->termsAndConditions();
        }
    }

    public static function rimuoviDaListaDesideri($idProdotto) {
        if (!(isset($_COOKIE['wishlist']))) {
            setcookie('wishlist', json_encode([]), time() + (86400 * 30), "/");  // 30 giorni
        }
        $wishlist = json_decode($_COOKIE['wishlist'], true);
        $index = array_search($idProdotto, $wishlist);
        if ($index !== false) {
            unset($wishlist[$index]);
        }
        $wishlist = array_values($wishlist);
        $nuova_wishlist = json_encode($wishlist);
        setcookie('wishlist', $nuova_wishlist, time() + (86400 * 30), "/"); // 30 giorni
        $_SESSION['elemento_rimosso_da_wishlist'] = true;
        header('Location: /Dolce_Abruzzo/utente/wishlist');
    }

    public static function about()
    {
        $view_utente = new VUtente();
        if (static::islogged()) {
            $view_utente->about();
        } else {
            $view_utente->about();
        }
    }

    public static function contatti() {
        $view_utente = new VUtente();
        if (static::islogged()) {
            $view_utente->contatti();
        } else {
            $view_utente->contatti();
        }
    }

    public static function signUp()
    {
        $view_register = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $view_register->signUp();
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }
            /**
             * Creo un oggetto temporaneo necessario per controllare successivamente nell'altra tabella se esiste già l'email
             * assegnando al campo email la stessa email dell'oggetto $new_utente
             */
            if ($array_data['userType'] == 'cliente') {
                $new_utente  = new ECliente($array_data['nome'], $array_data['cognome'], $array_data['username'], password_hash($array_data['password'], PASSWORD_DEFAULT), $array_data['email'], $array_data['cellulare'], 0);
                $temp = new EChef(null, null, null, null, $new_utente->getEmail(), null, null);
            } else {
                $new_utente = new EChef($array_data['nome'], $array_data['cognome'], $array_data['username'], password_hash($array_data['password'], PASSWORD_DEFAULT), $array_data['email'], $array_data['cellulare'], $array_data['specializzazione']);
                $temp = new ECliente(null, null, null, null, $new_utente->getEmail(), null, null);
            }
            /**
             * Assegno a $same_class_new_utente il risultato della query findUtente($new_utente) 
             * Se $same_class_new_utente = null significa che l'email non è stata usata da nessuno nella tabella della sua classe
             */
            $same_class_new_utente = FPersistentManager::getInstance()->findUtente($new_utente);
            /**
             * Assegno a $check_email il risultato della query findUtente($temp) 
             * Se $check_email = null significa che l'email non è stata usata da nessuno nella tabella dell'altra classe
             */
            $check_email = FPersistentManager::getInstance()->findUtente($temp);
            /* Controllo se l'email esiste già */
            if ($check_email != null || ($check_email == null && $same_class_new_utente != null)) {
                // se esiste ricarico la form per la registrazione
                $view_register->signUpError();
            } else if ($check_email == null && $same_class_new_utente == null) {
                if ($array_data['password'] != $array_data['confirm-password']) {
                    $view_register->checkPassSignUp();
                } else {
                    //se è un cliente, setto il ruolo di cliente
                    // (il metodo setRoles() vuole come parametro una collection che a sua volta vuole un parametro di tipo array di oggetti ERole)
                    if($new_utente instanceof ECliente){
                        $role = FPersistentManager::getInstance()->find(ERole::class, 2);
                        $new_utente->setRoles(new ArrayCollection([$role]));
                    }else{
                        $role = FPersistentManager::getInstance()->find(ERole::class, 3);
                        $new_utente->setRoles(new ArrayCollection([$role]));
                    }
                    FPersistentManager::getInstance()->insertNewUtente($new_utente);
                    $_SESSION['signupsuccess'] = true;
                    header('Location: /Dolce_Abruzzo/utente/home');
                }
            }
        }
    }
    public static function changePass()
    {
        $view = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $view->changePass();
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $password_old = $_POST['password'];
            if (password_verify($password_old, $_SESSION['utente']->getPassword())) {
                $new_password = $_POST['new-password'];
                $confirm_password = $_POST['new-confirm-password'];
                if ($new_password != $password_old) {
                    if ($new_password == $confirm_password) {
                        FPersistentManager::getInstance()->updatePass($_SESSION['utente'], $new_password);
                        $_SESSION['changepasswordsucces'] = true;
                        header('Location: /Dolce_Abruzzo/utente/userDataSection');
                    } else {
                        $view->errorPassUpdate();
                    }
                } elseif ($new_password == $password_old) {
                    $view->equelPasswordError();
                }
            } else {
                $view->errorOldPass();
            }
        }
    }

    public static function changeUserData()
    {
        $view = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $view->userDataForm();
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            foreach ($postData as $key => $value) {
                $array_data[$key] = $value;
            }
            FPersistentManager::getInstance()->updateUtente($_SESSION['utente'], $array_data);
            $_SESSION['changeuserdatasucces'] = true;
            header('Location: /Dolce_Abruzzo/utente/userDataSection');
        }
    }
    public static function indirizzi() {
        $view_utente = new VUtente();
        $array_indirizzi = FPersistentManager::getInstance()->getAllIndirizziUtente($_SESSION['utente']->getIdCliente());
        
        $messages = [];
        if (isset($_SESSION['address_deleted'])) {
            $messages['success'] = "L'indirizzo è stato eliminato con successo.";
            unset($_SESSION['address_deleted']);
        }
        if (isset($_SESSION['address_added'])) {
            $messages['success'] = "L'indirizzo è stato aggiunto con successo.";
            unset($_SESSION['address_added']);
        }
        if (isset($_SESSION['address_soft_deleted'])) {
            $messages['info'] = "L'indirizzo è stato nascosto ma non completamente eliminato poiché è associato a ordini esistenti.";
            unset($_SESSION['address_soft_deleted']);
        }
        if (isset($_SESSION['address_error'])) {
            $messages['error'] = $_SESSION['address_error'];
            unset($_SESSION['address_error']);
        }
        
        $view_utente->indirizzi($array_indirizzi, $messages);
    }

    public static function aggiungiIndirizzi(){
        $view = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $view->aggiungiIndirizzi();
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            $errors = [];

            // Validazione del campo "via"
            if (!preg_match('/^Via\s+[A-Za-z\s]+\s+\d+$/', $postData['via'])) {
                $errors[] = "L'indirizzo deve essere nel formato 'Via Nome strada n_civico'";
            }

            // Validazione del campo "cap"
            if (!preg_match('/^\d{5}$/', $postData['cap'])) {
                $errors[] = "Il CAP deve essere composto da esattamente 5 cifre";
            }
            $found_indirizzo = FPersistentManager::getInstance()->findIndirizzo($postData['via'], $postData['cap']);
            if($found_indirizzo){
                $errors[] = "L'indirizzo esiste già.";
            }

            if (empty($errors)) {
                // Se non ci sono errori, procedi con l'inserimento
                foreach ($postData as $key => $value) {
                    $array_data[$key] = $value;
                }
                //Si assume per semplicità che gli indirizzi siano univoci, 
                //cioè che non ci sono più famiglie che abitano nella stesso indirizzo,
                // nello stesso numero civico e nello stesso cap
                FPersistentManager::getInstance()->insertIndirizzo($array_data);
                $_SESSION['address_added'] = true;
                header('Location: /Dolce_Abruzzo/utente/indirizzi');
            } else {
                // Se ci sono errori, mostra nuovamente il form con i messaggi di errore
                $view->aggiungiIndirizziConErrori($errors);
            }
        }
    }
    public static function eliminaIndirizzo($indirizzo, $cap) {
        $found_indirizzo = FPersistentManager::getInstance()->findIndirizzo($indirizzo, $cap);
        
        if ($found_indirizzo) {
            if (FPersistentManager::getInstance()->canIndirizzoBeHardDeleted($indirizzo, $cap)) {
                FPersistentManager::getInstance()->deleteIndirizzo($found_indirizzo[0]);
                $_SESSION['address_deleted'] = true;
            } else {
                FPersistentManager::getInstance()->softDeleteIndirizzo($found_indirizzo[0]);
                $_SESSION['address_soft_deleted'] = true;
            }
        } else {
            $_SESSION['address_error'] = "Errore: l'indirizzo non è stato trovato.";
        }
        
        header('Location: /Dolce_Abruzzo/utente/indirizzi');
        exit();
    }
    public static function aggiungiCarte() {
        $view = new VUtente();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $view->aggiungiCarte();
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $_POST;
            $errors = self::validateCreditCardData($postData);
            
            if (empty($errors)) {
                try {
                    FPersistentManager::getInstance()->insertCartaDiCredito($postData);
                    $_SESSION['credit_card_added'] = true;
                    header('Location: /Dolce_Abruzzo/utente/carteCredito');
                    exit;
                } catch (Exception $e) {
                    $errors[] = "Errore durante l'inserimento della carta: " . $e->getMessage();
                }
            }
            
            if (!empty($errors)) {
                $view->aggiungiCarteConErrori($errors);
            }
        }
    }

    private static function validateCreditCardData($data) {
        $errors = [];

        // Validazione nome e cognome
        if (!preg_match("/^[a-zA-Z\s]+$/", $data['nome']) || !preg_match("/^[a-zA-Z\s]+$/", $data['cognome'])) {
            $errors[] = "Il nome e il cognome devono contenere solo lettere e spazi.";
        }

        // Validazione numero carta
        if (!preg_match("/^\d{16}$/", $data['numeroCarta'])) {
            $errors[] = "Il numero della carta deve essere composto da 16 cifre.";
        }

        // Validazione scadenza
        if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $data['scadenza'])) {
            $errors[] = "La data di scadenza deve essere nel formato MM/YY.";
        } else {
            $expiration = \DateTime::createFromFormat('m/y', $data['scadenza']);
            $now = new \DateTime();
            if ($expiration < $now) {
                $errors[] = "La carta di credito è scaduta.";
            }
        }

        // Validazione CCV
        if (!preg_match("/^\d{3}$/", $data['ccv'])) {
            $errors[] = "Il CCV deve essere composto da 3 cifre.";
        }

        // Validazione gestore
        if (!preg_match("/^[a-zA-Z\s]+$/", $data['gestore'])) {
            $errors[] = "Il nome del gestore deve contenere solo lettere e spazi.";
        }

        $found_carta = FPersistentManager::getInstance()->findCartaDiCredito($data['numeroCarta']);
        if($found_carta){
            $errors[] = "La carta esiste già.";
        }

        return $errors;
    }

    public static function carteCredito() {
        $view_utente = new VUtente();
        $carte = FPersistentManager::getInstance()->getAllCarteCredito($_SESSION['utente']->getIdCliente());
        
        $messages = [];
        if (isset($_SESSION['card_deleted'])) {
            $messages['success'] = "La carta di credito è stata eliminata con successo.";
            unset($_SESSION['card_deleted']);
        }
        if (isset($_SESSION['card_soft_deleted'])) {
            $messages['info'] = "La carta di credito è stata nascosta ma non completamente eliminata poiché è associata a ordini esistenti.";
            unset($_SESSION['card_soft_deleted']);
        }
        if (isset($_SESSION['card_error'])) {
            $messages['error'] = $_SESSION['card_error'];
            unset($_SESSION['card_error']);
        }
        if (isset($_SESSION['credit_card_added'])) {
            $messages['success'] = $_SESSION['credit_card_added'];
            unset($_SESSION['credit_card_added']);
        }
        
        $view_utente->carteCredito($carte, $messages);
    }

    public static function eliminaCarta($numeroCarta) {
        $found_carta = FPersistentManager::getInstance()->findCartaDiCredito($numeroCarta);
        
        if ($found_carta) {
            if (FPersistentManager::getInstance()->canCartaDiCreditoBeHardDeleted($numeroCarta)) {
                FPersistentManager::getInstance()->deleteCartaDiCredito($found_carta[0]);
                $_SESSION['card_deleted'] = true;
            } else {
                FPersistentManager::getInstance()->softDeleteCartaDiCredito($found_carta[0]);
                $_SESSION['card_soft_deleted'] = true;
            }
        } else {
            $_SESSION['card_error'] = "Errore: la carta di credito non è stata trovata.";
        }
        
        header('Location: /Dolce_Abruzzo/utente/carteCredito');
        exit();
    }

    public static function elencoRicette() {
        if (!isset($_GET['page'])) {
            // Redirect to the same URL with ?page=1
            $url = $_SERVER['REQUEST_URI'];
            $url .= '?page=1';
            header("Location: $url");
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $view = new VUtente();
        $is_array_ricette_vuoto = 0;
        $array_ricette = FPersistentManager::getInstance()->getAllRicette($page);
        if(sizeof($array_ricette['ricette']) == 0) {
            $is_array_ricette_vuoto = 1;
        }
        $view->elencoRicette($array_ricette, $is_array_ricette_vuoto);
    }
    public static function vediRicetta($idRicetta){
        $view_ricetta = new VGestioneRicette();
        $ricetta = FPersistentManager::getInstance()->find(ERicetta::class, $idRicetta);
        $immagine = FPersistentManager::getInstance()->getImageRicetta($ricetta);
        $view_ricetta->vediRicetta($ricetta, $immagine);
    }

    public static function verificaSconto($sconto) {
        $array_sconti = [5, 10, 15];
        if(in_array($sconto, $array_sconti)) {
            $punti_fedelta = FPersistentManager::getInstance()->getPuntiFedeltaByCliente($_SESSION['utente']);
            if($sconto == 5) {
                if($punti_fedelta >= 100) {
                    self::generaCodiceSconto(5, 100);
                } else {
                    $_SESSION['punti_fedelta_non_sufficienti'] = true;
                }
            } 
            else if($sconto == 10) {
                if($punti_fedelta >= 200) {
                    self::generaCodiceSconto(10, 200);
                } else {
                    $_SESSION['punti_fedelta_non_sufficienti'] = true;
                }
            } else if($sconto == 15) {
                if($punti_fedelta >= 300) {
                    self::generaCodiceSconto(15, 300);
                } else {
                    $_SESSION['punti_fedelta_non_sufficienti'] = true;
                }
            }
        } else {
            $_SESSION['errore_valore_sconto'] = true;
        }
        header('Location: /Dolce_Abruzzo/utente/userDiscounts');
    }

    private static function generaCodiceSconto($valore_sconto, $punti_da_sottrarre) {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $stringa_sconto = "";
        for ($i = 0; $i < $length; $i++) {
            $stringa_sconto .= $characters[rand(0, $charactersLength - 1)];
        }
        $codice_sconto = new ESconto($valore_sconto);
        FPersistentManager::getInstance()->insertSconto($codice_sconto, $stringa_sconto);
        FPersistentManager::getInstance()->sottraiPuntiFedelta($_SESSION['utente'], $punti_da_sottrarre);
        $_SESSION['codice_success'] = $valore_sconto;
    }
    public static function riattivaIndirizzo($indirizzo, $cap) {
        $found_indirizzo = FPersistentManager::getInstance()->findIndirizzo($indirizzo, $cap);
        
        if ($found_indirizzo) {
            FPersistentManager::getInstance()->riattivaIndirizzo($found_indirizzo[0]);
            $_SESSION['address_reactivated'] = true;
        } else {
            $_SESSION['address_error'] = "Errore: l'indirizzo non è stato trovato.";
        }
        
        header('Location: /Dolce_Abruzzo/utente/indirizzi');
        exit();
    }

    public static function riattivaCarta($numeroCarta) {
        $found_carta = FPersistentManager::getInstance()->findCartaDiCredito($numeroCarta);
        
        if ($found_carta) {
            FPersistentManager::getInstance()->riattivaCarta($found_carta[0]);
            $_SESSION['card_reactivated'] = true;
        } else {
            $_SESSION['card_error'] = "Errore: la carta di credito non è stata trovata.";
        }
        
        header('Location: /Dolce_Abruzzo/utente/carteCredito');
        exit();
    }
    public static function codiciSconto() {
        $view = new VUtente();
        $codici_sconto = FPersistentManager::getInstance()->getAllCodiciScontoCliente();
        if(empty($codici_sconto)) {
            $_SESSION['nessun_codice_sconto'] = true;
        }
        $view->codiciSconto($codici_sconto);
    }
    public static function segnalaRecensione($idRecensione) {
        $recensione = FPersistentManager::getInstance()->find(ERecensione::class, $idRecensione);
        $utente = FPersistentManager::getInstance()->find(ECliente::class, $_SESSION['utente']->getIdCliente());
        
        // Controlla se l'utente ha già segnalato questa recensione
        $segnalazioneEsistente = FPersistentManager::getInstance()->findSegnalazioneByUtenteAndRecensione($utente->getIdCliente(), $idRecensione);
        
        if (!$segnalazioneEsistente) {
            $segnalazione = new ESegnalazione("Segnalazione per linguaggio volgare o comportamento offensivo");
            $segnalazione->setUtente($utente);
            $segnalazione->setRecensioneSegnalata($recensione);
            
            try {
                FPersistentManager::getInstance()->insertSegnalazione($segnalazione);
                $_SESSION['segn_inviata'] = true;
            } catch (\Exception $e) {
                $_SESSION['segn_err'] = true;
            }
        } else {
            $_SESSION['segn_esistente'] = true;
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    public static function visualizzaSegnalazioni() {
        $view = new VUtente();
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageSize = 5;
        $segnalazioni = FPersistentManager::getInstance()->getAllSegnalazioni($currentPage, $pageSize);
        if(empty($segnalazioni['totalItems'])) {
            $_SESSION['nessuna_segnalazione'] = true;
        }
        $view->mostraSegnalazioni($segnalazioni);
    }
    
    public static function bloccaUtente($idUtente) {
        $utente = FPersistentManager::getInstance()->find(ECliente::class, $idUtente);
        if ($utente) {
            //Trovo il ruolo di "utente_bloccato"
            $role = FPersistentManager::getInstance()->find(ERole::class, 4);
            //Aggiorno l'entità dell'utente
            $utente->setRoles(new ArrayCollection([$role]));
            FPersistentManager::getInstance()->updateUtente($utente, null);
            $_SESSION['user_blocked'] = true;
        } else {
            $_SESSION['user_not_found'] = true;
        }
        header('Location: /Dolce_Abruzzo/utente/visualizzaUtenti');
    }
    public static function sbloccaUtente($idUtente) {
        $utente = FPersistentManager::getInstance()->find(ECliente::class, $idUtente);
        if ($utente) {
            //Trovo il ruolo di "cliente"
            $role = FPersistentManager::getInstance()->find(ERole::class, 2);
            //Aggiorno l'entità dell'utente
            $utente->setRoles(new ArrayCollection([$role]));
            FPersistentManager::getInstance()->updateUtente($utente, null);
            $_SESSION['user_unblocked'] = true;
        } else {
            $_SESSION['user_not_found'] = true;
        }
        header('Location: /Dolce_Abruzzo/utente/visualizzaUtenti');
    }
    public static function visualizzaUtenti() {
        $view = new VUtente();
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageSize = 5; // Puoi modificare questo valore secondo le tue preferenze

        $result = FPersistentManager::getInstance()->getAllUtenti($currentPage, $pageSize);
        
        $view->mostraUtenti($result);
    }
}
