<?php

class VUtente
{
    private $smarty;

    public function __construct()
    {

        $this->smarty = StartSmarty::configuration();
        $this->smarty->assign('cart_quantity', self::countItemCart());
    }
    public function accessDenied()
    {
        $this->smarty->display('accessDenied.tpl');
    }
    public function showLoginForm()
    {
        $this->smarty->display('login.tpl');
    }
    public function showRegisterForm()
    {

        $this->smarty->display('registration.tpl');
    }
    public function checkLogin()
    {
        $loginVariables = [
            'check_login_cliente' => 0,
            'check_login_admin' => 0,
            'check_login_chef' => 0,
            'utente_non_loggato' => 1
        ];

        if(isset($_SESSION['utente'])){
            $loginVariables['utente_non_loggato'] = 0;
            if ($_SESSION['utente'] instanceof ECliente) {
                foreach ($_SESSION['utente']->getRoles() as $role) {
                    if ($role->getName() == "admin") {
                        $loginVariables['check_login_admin'] = 1;
                    } else if($role->getName() == "cliente"){
                        $loginVariables['check_login_cliente'] = 1;
                    }
                }
            } else if ($_SESSION['utente'] instanceof EChef) {
                $loginVariables['check_login_chef'] = 1;
            }
        }
        return $loginVariables;
    }
    public function countItemCart()
    {
        if (!(isset($_COOKIE['cart']))) {
            return 0;
        }
        $carrello = json_decode($_COOKIE['cart']);
        $cont = 0;
        foreach ($carrello as $id => $quantity) {
            $cont += $quantity;
        }
        return $cont;
    }
    public function loginSuccess($array_prodotti, $recensioni, $array_prodotti_home){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('carrello_svuotato', 0);
        $carrello_svuotato = isset($_SESSION['carrello_svuotato']) && $_SESSION['carrello_svuotato'];
        unset($_SESSION['carrello_svuotato']);
        if ($carrello_svuotato) {
            $this->smarty->assign('carrello_svuotato', 1);
        }
        $this->smarty->assign('lista_desideri_svuotata', 0);
        $lista_desideri_svuotata = isset($_SESSION['lista_desideri_svuotata']) && $_SESSION['lista_desideri_svuotata'];
        unset($_SESSION['lista_desideri_svuotata']);
        if ($lista_desideri_svuotata) {
            $this->smarty->assign('lista_desideri_svuotata', 1);
        }
        $this->smarty->assign('added_to_cart', 0);
        $added_to_cart = isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart'];
        unset($_SESSION['added_to_cart']);
        if ($added_to_cart) {
            $this->smarty->assign('added_to_cart', 1);
        }
        $this->smarty->assign('q_max_raggiunta', 0);
        $q_max_raggiunta = isset($_SESSION['q_max_raggiunta']) && $_SESSION['q_max_raggiunta'];
        unset($_SESSION['q_max_raggiunta']);
        if ($q_max_raggiunta) {
            $this->smarty->assign('q_max_raggiunta', 1);
        }
        $this->smarty->assign('added_to_wishlist', 0);
        $added_to_wishlist = isset($_SESSION['added_to_wishlist']) && $_SESSION['added_to_wishlist'];
        unset($_SESSION['added_to_wishlist']);
        if ($added_to_wishlist) {
            $this->smarty->assign('added_to_wishlist', 1);
        }
        $this->smarty->assign('home', 1);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->assign('array_prodotti_home_vuoto', $array_prodotti_home);
        $this->smarty->assign('array_prodotti', $array_prodotti);
        $this->smarty->assign('errore', 0);
        $this->smarty->display('homepage.tpl');
    }
    public function logout($array_prodotti, $recensioni)
    {
        $this->smarty->assign('home', 1);
        $this->smarty->assign('signupsuccess', 0);
        $this->smarty->assign('recensioni', $recensioni);
        $signupsuccess = isset($_SESSION['signupsuccess']) && $_SESSION['signupsuccess'];
        unset($_SESSION['signupsuccess']);
        if($signupsuccess){
            $this->smarty->assign('signupsuccess', 1);
        }
        $this->smarty->assign('carrello_svuotato', 0);
        $carrello_svuotato = isset($_SESSION['carrello_svuotato']) && $_SESSION['carrello_svuotato'];
        unset($_SESSION['carrello_svuotato']);
        if ($carrello_svuotato) {
            $this->smarty->assign('carrello_svuotato', 1);
        }

        $this->smarty->assign('lista_desideri_svuotata', 0);
        $lista_desideri_svuotata = isset($_SESSION['lista_desideri_svuotata']) && $_SESSION['lista_desideri_svuotata'];
        unset($_SESSION['lista_desideri_svuotata']);
        if ($lista_desideri_svuotata) {
            $this->smarty->assign('lista_desideri_svuotata', 1);
        }
        $this->smarty->assign('added_to_cart', 0);
        $added_to_cart = isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart'];
        unset($_SESSION['added_to_cart']);
        if ($added_to_cart) {
            $this->smarty->assign('added_to_cart', 1);
        }
        $this->smarty->assign('q_max_raggiunta', 0);
        $q_max_raggiunta = isset($_SESSION['q_max_raggiunta']) && $_SESSION['q_max_raggiunta'];
        unset($_SESSION['q_max_raggiunta']);
        if ($q_max_raggiunta) {
            $this->smarty->assign('q_max_raggiunta', 1);
        }
        $this->smarty->assign('array_prodotti', $array_prodotti);
        $this->smarty->assign('check_login_cliente', 0);
        $this->smarty->assign('check_login_chef', 0);
        $this->smarty->assign('check_login_admin', 0);
        $this->smarty->assign('utente_non_loggato', 1);
        $this->smarty->display('homepage.tpl');
    }

    public function wishlist($prodotti_wishlist) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('elemento_rimosso_da_wishlist', 0);
        $elemento_rimosso_da_wishlist = isset($_SESSION['elemento_rimosso_da_wishlist']) && $_SESSION['elemento_rimosso_da_wishlist'];
        unset($_SESSION['elemento_rimosso_da_wishlist']);
        if($elemento_rimosso_da_wishlist) {
            $this->smarty->assign('elemento_rimosso_da_wishlist', 1);
        }
        if(!isset($_COOKIE['wishlist']) || empty($prodotti_wishlist)) {
            $this->smarty->assign('is_wishlist_empty', 1);
            $this->smarty->display('wishlist.tpl');
        } else {
            $this->smarty->assign('is_wishlist_empty', 0);
            $this->smarty->assign('prodotti_wishlist', $prodotti_wishlist);
            $this->smarty->display('wishlist.tpl');
        }
    }

    public function termsAndConditions() {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->display('termsAndConditions.tpl');
    }
    public function about() {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('about', 1);
        $this->smarty->display('about.tpl');
    }

    public function contatti() {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('contatti', 1);
        $this->smarty->display('contatti.tpl');
    }
    public function userDataForm(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('nome', $_SESSION['utente']->getNome());
        $this->smarty->assign('cognome', $_SESSION['utente']->getCognome());
        $this->smarty->assign('username', $_SESSION['utente']->getUsername());
        $this->smarty->assign('cellulare', $_SESSION['utente']->getCellulare());
        $this->smarty->assign('email', $_SESSION['utente']->getEmail());
        $this->smarty->assign('userDataForm', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function userDataSection(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('changeuserdatasucces', 0);
        $this->smarty->assign('changepasswordsucces', 0);
        // Verifica se il messaggio di successo è presente nella sessione
        $changeuserdatasucces = isset($_SESSION['changeuserdatasucces']) && $_SESSION['changeuserdatasucces'];
        $changepasswordsucces = isset($_SESSION['changepasswordsucces']) && $_SESSION['changepasswordsucces'];

        // Rimuovi il messaggio di successo dalla sessione
        unset($_SESSION['changeuserdatasucces']);
        unset($_SESSION['changepasswordsucces']);
        // Controlla se il metodo è stato chiamato dalla form per aggiungere un prodotto
        if ($changeuserdatasucces) {
            $this->smarty->assign('changeuserdatasucces', 1);
        }
        if ($changepasswordsucces) {
            $this->smarty->assign('changepasswordsucces', 1);
        }
        $this->smarty->assign('nome', $_SESSION['utente']->getNome());
        $this->smarty->assign('cognome', $_SESSION['utente']->getCognome());
        $this->smarty->assign('username', $_SESSION['utente']->getUsername());
        $this->smarty->assign('cellulare', $_SESSION['utente']->getCellulare());
        $this->smarty->assign('email', $_SESSION['utente']->getEmail());
        $this->smarty->assign('userDataSection', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function userHistoryOrders($ordini){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('ordini', $ordini);
        $this->smarty->assign('userHistoryOrders', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function userDiscounts(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('punti_fedelta_non_sufficienti', 0);
        $this->smarty->assign('errore_valore_sconto', 0);
        $this->smarty->assign('codice_success', 0);
        $punti_fedelta_non_sufficienti = isset($_SESSION['punti_fedelta_non_sufficienti']) && $_SESSION['punti_fedelta_non_sufficienti'];
        $errore_valore_sconto = isset($_SESSION['errore_valore_sconto']) && $_SESSION['errore_valore_sconto'];
        if(isset($_SESSION['codice_success'])){
            $codice_success = $_SESSION['codice_success'];
            unset($_SESSION['codice_success']);
            if ($codice_success == 5) {
                $this->smarty->assign('codice_success', 5);
            }else if($codice_success == 10){
                $this->smarty->assign('codice_success', 10);
            }else if($codice_success == 15){
                $this->smarty->assign('codice_success', 15);
            }
        }
        unset($_SESSION['punti_fedelta_non_sufficienti']);
        unset($_SESSION['errore_valore_sconto']);
        if ($punti_fedelta_non_sufficienti) {
            $this->smarty->assign('punti_fedelta_non_sufficienti', 1);
        }
        if ($errore_valore_sconto) {
            $this->smarty->assign('errore_valore_sconto', 1);
        }
        $this->smarty->assign('punti_fedelta', $_SESSION['utente']->getPuntiFedelta());
        $this->smarty->assign('userDiscounts', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function signUp()
    {
        $this->smarty->display('registration.tpl');
    }
    public function loginError()
    {
        $this->smarty->assign('errore', 1);
        $this->smarty->display('login.tpl');
    }
    public function signUpError(){
        $this->smarty->assign('errore_r', 1);
        $this->smarty->display('registration.tpl');
    }
    public function checkPassSignUp()
    {
        $this->smarty->assign('check_pass', 1);
        $this->smarty->display('registration.tpl');
    }
    public function changePass(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('changepass', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function errorPassUpdate(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('changepass', 1);
        $this->smarty->assign('errorpassupdate', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function errorOldPass(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('changepass', 1);
        $this->smarty->assign('erroroldpass', 1);
        $this->smarty->display('userinfo.tpl');
    }

    public function equelPasswordError() {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('changepass', 1);
        $this->smarty->assign('equalpassworderr', 1);
        $this->smarty->display('userinfo.tpl');
    }

    public function elencoRicette($array_ricette, $is_array_ricette_vuoto) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_ricette', $array_ricette);
        $this->smarty->assign('is_array_ricette_vuoto', $is_array_ricette_vuoto);
        $this->smarty->assign('ricette', 1);
        $this->smarty->display('elencoRicette.tpl');
    }
    public function indirizzi($array_indirizzi, $messages = []) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_indirizzi', $array_indirizzi);
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('indirizzi', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function carteCredito($carte_credito, $messages = []) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('carte_credito', $carte_credito);
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('carteCredito', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function aggiungiIndirizzi(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('aggiungiIndirizzi', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function aggiungiIndirizziConErrori($errors) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('aggiungiIndirizzi', 1);
        $this->smarty->assign('errors', $errors);
        $this->smarty->display('userinfo.tpl');
    }
    public function errorEliminaIndirizzi() {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('indirizzi', 1);
        $this->smarty->assign('errorEliminaIndirizzi', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function errorEliminaCarta(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('errorEliminaCarta', true);
        $this->smarty->assign('carteCredito', true);
        $this->smarty->display('userinfo.tpl');
    }
    public function aggiungiCarte(){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('aggiungiCarte', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function aggiungiCarteConErrori($errors) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('errors', $errors);
        $this->smarty->assign('aggiungiCarte', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function codiciSconto($codici_sconto) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('nessun_codice_sconto', 0);
        $nessun_codice_sconto = isset($_SESSION['nessun_codice_sconto']) && $_SESSION['nessun_codice_sconto'];
        unset($_SESSION['nessun_codice_sconto']);
        if($nessun_codice_sconto) {
            $this->smarty->assign('nessun_codice_sconto', 1);
        }
        $this->smarty->assign('codici_sconto', $codici_sconto);
        $this->smarty->assign('codiciSconto', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function adminOrderManagement($ordini)
    {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('ordini', $ordini);
        $this->smarty->assign('adminOrderManagement', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function mostraSegnalazioni($segnalazioni){
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('user_not_found', 0);
        $this->smarty->assign('user_blocked', 0);
        $this->smarty->assign('user_unblocked', 0);
        $this->smarty->assign('nessuna_segnalazione', 0);
        $user_blocked = isset($_SESSION['user_blocked']) && $_SESSION['user_blocked'];
        unset($_SESSION['user_blocked']);
        if($user_blocked) {
            $this->smarty->assign('user_blocked', 1);
        }
        $user_unblocked = isset($_SESSION['user_unblocked']) && $_SESSION['user_unblocked'];
        unset($_SESSION['user_unblocked']);
        if($user_unblocked) {
            $this->smarty->assign('user_unblocked', 1);
        }
        $user_not_found = isset($_SESSION['user_not_found']) && $_SESSION['user_not_found'];
        unset($_SESSION['user_not_found']);
        if($user_not_found) {
            $this->smarty->assign('user_not_found', 1);
        }
        $nessuna_segnalazione = isset($_SESSION['nessuna_segnalazione']) && $_SESSION['nessuna_segnalazione'];
        unset($_SESSION['nessuna_segnalazione']);
        if($nessuna_segnalazione) {
            $this->smarty->assign('nessuna_segnalazione', 1);
        }
        $this->smarty->assign('segnalazioni', $segnalazioni);
        $this->smarty->display('adminSegnalazioni.tpl');
    }
    public function mostraUtenti($result) {
        $loginVariables = self::checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $user_blocked = isset($_SESSION['user_blocked']) && $_SESSION['user_blocked'];
        unset($_SESSION['user_blocked']);
        if($user_blocked) {
            $this->smarty->assign('user_blocked', 1);
        }
        $user_unblocked = isset($_SESSION['user_unblocked']) && $_SESSION['user_unblocked'];
        unset($_SESSION['user_unblocked']);
        if($user_unblocked) {
            $this->smarty->assign('user_unblocked', 1);
        }
        $user_not_found = isset($_SESSION['user_not_found']) && $_SESSION['user_not_found'];
        unset($_SESSION['user_not_found']);
        if($user_not_found) {
            $this->smarty->assign('user_not_found', 1);
        }
        $this->smarty->assign('result', $result);
        $this->smarty->display('adminUtenti.tpl');
    }
}