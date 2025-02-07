<?php

class VGestioneProdotti{

    private $smarty;

    public function __construct(){

        $this->smarty = StartSmarty::configuration();
    }
    public function listaProdotti($array_prodotti, $is_arrayprodotti_vuoto){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_prodotti', $array_prodotti);
        $this->smarty->assign('is_arrayprodotti_vuoto', $is_arrayprodotti_vuoto);
        $this->smarty->assign('listaProdotti', 1);
        $this->smarty->assign('addedProductSuccess', 0);
        $this->smarty->assign('modifiedProductSuccess', 0);
        $this->smarty->assign('deletedProductSuccess', 0);
        // Verifica se il messaggio di successo è presente nella sessione
        $product_added = isset($_SESSION['product_added']) && $_SESSION['product_added'];
        $product_modified = isset($_SESSION['product_modified']) && $_SESSION['product_modified'];
        $product_deleted = isset($_SESSION['product_deleted']) && $_SESSION['product_deleted'];

        // Rimuovi il messaggio di successo dalla sessione
        unset($_SESSION['product_added']);
        unset($_SESSION['product_modified']);
        unset($_SESSION['product_deleted']);
        // Controlla se il metodo è stato chiamato dalla form per aggiungere un prodotto
        if ($product_added) {
            $this->smarty->assign('addedProductSuccess', 1);
        }
        if ($product_modified) {
            $this->smarty->assign('modifiedProductSuccess', 1);
        }
        if ($product_deleted) {
            $this->smarty->assign('deletedProductSuccess', 1);
        }

        $this->smarty->display('userinfo.tpl');
    }
    public function addProductForm($array_categorie){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_categorie', $array_categorie);
        $this->smarty->assign('addProductForm', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function modifyProductForm(EProdotto $prodotto, $immagini){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('nomeProdotto', $prodotto->getNome());
        $this->smarty->assign('descrizione', $prodotto->getDescrizione());
        $this->smarty->assign('ingredienti', $prodotto->getIngredienti());
        $this->smarty->assign('quantita_disp', $prodotto->getQuantitaDisp());
        $this->smarty->assign('punti_fedelta', $prodotto->getPunti_fedelta());
        $this->smarty->assign('prezzo', $prodotto->getPrezzo());
        $this->smarty->assign('categoria', $prodotto->getNomeCategoria()->getNomeCategoria());
        $this->smarty->assign('immagini', $immagini);
        $this->smarty->assign('productId', $prodotto->getIdProdotto());
        $this->smarty->assign('modifyProductForm', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function errorImageUpload($array_categorie){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_categorie', $array_categorie);
        $this->smarty->assign('addProductForm', 1);
        $this->smarty->assign('errorImageUpload', 1);
        $this->smarty->display('userinfo.tpl');
    }
}
?>