<?php

class VGestioneAcquisti
{

    private $smarty;

    public function __construct()
    {

        $this->smarty = StartSmarty::configuration();
        $this->smarty->assign('cart_quantity', (new VUtente)->countItemCart());
    }
    public function shop($array, $categorie, $is_arrayprodotti_vuoto, $categoria)
    {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_prodotti', $array);
        $this->smarty->assign('array_categorie', $categorie);
        $this->smarty->assign('is_arrayprodotti_vuoto', $is_arrayprodotti_vuoto);
        $this->smarty->assign('categoria_corrente', $categoria);
        $this->smarty->assign('shop', 1);
        $this->smarty->display('shop.tpl');
    }

    public function infoProdotto($prodotto, $immagini, $carrello, $recensioni)
    {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('is_in_wishlist', 0);
        $this->smarty->assign('is_in_cart', 0);
        $this->smarty->assign('review_added', 0);
        $this->smarty->assign('segn_inviata', 0);
        $this->smarty->assign('segn_err', 0);
        $this->smarty->assign('segn_esistente', 0);
        $this->smarty->assign('cannot_write_review', 0);

        $isInWishlist = isset($_SESSION['is_in_wishlist']) && $_SESSION['is_in_wishlist'];
        $isInCart = isset($_SESSION['is_in_cart']) && $_SESSION['is_in_cart'];
        $review_added = isset($_SESSION['review_added']) && $_SESSION['review_added'];
        $segn_inviata = isset($_SESSION['segn_inviata']) && $_SESSION['segn_inviata'];
        $segn_err = isset($_SESSION['segn_err']) && $_SESSION['segn_err'];
        $segn_esistente = isset($_SESSION['segn_esistente']) && $_SESSION['segn_esistente'];
        $cannot_write_review = isset($_SESSION['cannot_write_review']) && $_SESSION['cannot_write_review'];

        unset($_SESSION['is_in_wishlist']);
        unset($_SESSION['is_in_cart']);
        unset($_SESSION['review_added']);
        unset($_SESSION['segn_inviata']);
        unset($_SESSION['segn_err']);
        unset($_SESSION['segn_esistente']);
        unset($_SESSION['cannot_write_review']);

        if($isInWishlist) {
            $this->smarty->assign('is_in_wishlist', 1);
        }
        if($isInCart) {
            $this->smarty->assign('is_in_cart', 1);
        }
        if($review_added) {
            $this->smarty->assign('review_added', 1);
        }
        if($segn_inviata) {
            $this->smarty->assign('segn_inviata', 1);
        }
        if($segn_err) {
            $this->smarty->assign('segn_err', 1);
        }
        if($segn_esistente) {
            $this->smarty->assign('segn_esistente', 1);
        }
        if($cannot_write_review) {
            $this->smarty->assign('cannot_write_review', 1);
        }
        $this->smarty->assign('carrello', $carrello);
        $this->smarty->assign('prodotto', $prodotto);
        $this->smarty->assign('immagini', $immagini);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->assign('hasNextReview', isset($recensioni[1]));
        $this->smarty->display('infoProdotto.tpl');
    }

    public function cart($array_prodotti, $carrello)
    {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('elemento_rimosso_da_carrello', 0);
        $elemento_rimosso_da_carrello = isset($_SESSION['elemento_rimosso_da_carrello']) && $_SESSION['elemento_rimosso_da_carrello'];
        unset($_SESSION['elemento_rimosso_da_carrello']);
        if($elemento_rimosso_da_carrello) {
            $this->smarty->assign('elemento_rimosso_da_carrello', 1);
        }
        $this->smarty->assign('qty_updated', 0);
        $qty_updated = isset($_SESSION['qty_updated']) && $_SESSION['qty_updated'];
        unset($_SESSION['qty_updated']);
        if($qty_updated) {
            $this->smarty->assign('qty_updated', 1);
        }
        if (!isset($_COOKIE['cart']) || empty($carrello)) {
            $this->smarty->assign('is_cart_empty', 1);
            $this->smarty->display('cart.tpl');
        } else {
            $this->smarty->assign('is_cart_empty', 0);
            $this->smarty->assign('carrello', $carrello);
            $this->smarty->assign('prodotti_carrello', $array_prodotti);
            $this->smarty->display('cart.tpl');
        }
    }
    public function mostraRiepilogoOrdine($data){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('data', $data);
        $this->smarty->display('checkout.tpl');
    }
    public function mostraOrdineCompletato($ordine)
    {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('ordine', $ordine);
        $this->smarty->display('ordineCompletato.tpl');
    }
    public function dettaglioOrdine($ordine){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('ordine', $ordine);
        $this->smarty->assign('dettaglioOrdine', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function erroreOrdine(){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('errore_ordine', 0);
        if(isset($_SESSION['errore_ordine'])) {
            $this->smarty->assign('errore_ordine', $_SESSION['errore_ordine']);
        }
        unset($_SESSION['errore_ordine']);
        $this->smarty->display('erroreOrdine.tpl');
    }
    public function mostraRisultatiRicerca($risultati, $query, $isEmpty){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('risultati', $risultati);
        $this->smarty->assign('query', $query);
        $this->smarty->assign('isEmpty', $isEmpty);
        $this->smarty->display('risultati_ricerca.tpl');
    }
}
