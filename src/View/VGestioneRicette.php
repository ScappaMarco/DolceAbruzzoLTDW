<?php

class VGestioneRicette {

    private $smarty;

    public function __construct(){

        $this->smarty = StartSmarty::configuration();
    }

    public function listaRicette($array_ricette, $is_arrayricette_vuoto) {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('array_ricette', $array_ricette);
        $this->smarty->assign('is_arrayricette_vuoto', $is_arrayricette_vuoto);
        $this->smarty->assign('check_login_chef', 1);
        $this->smarty->assign('listaRicette', 1);
        $this->smarty->assign('recipeAddedSucces', 0);

        $recipe_added = isset($_SESSION['recipe_added']) && $_SESSION['recipe_added'];
        $recipe_deleted = isset($_SESSION['recipe_deleted']) && $_SESSION['recipe_deleted'];
        $recipe_modified = isset($_SESSION['recipe_modified']) && $_SESSION['recipe_modified'];

        unset($_SESSION['recipe_added']);
        unset($_SESSION['recipe_deleted']);
        unset($_SESSION['recipe_modified']);

        if($recipe_added) {
            $this->smarty->assign('recipeAddedSucces', 1);
        }
        if($recipe_deleted) {
            $this->smarty->assign('deletedRecipeSuccess', 1);
        }
        if($recipe_modified) {
            $this->smarty->assign('modifiedRecipeSuccess', 1);
        }
        $this->smarty->display('userinfo.tpl');
    }

    public function addRecipeForm() {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('check_login_chef', 1);
        $this->smarty->assign('addRecipeForm', 1);
        $this->smarty->display('userinfo.tpl');
    }

    public function modifyRecipeForm(ERicetta $ricetta, EImmagine $immagine) {
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('titoloRicetta', $ricetta->getTitolo());
        $this->smarty->assign('descrizione', $ricetta->getDescrizione());
        $this->smarty->assign('ingredienti', $ricetta->getIngredienti());
        $this->smarty->assign('procedimento', $ricetta->getProcedimento());
        $this->smarty->assign('idRicetta', $ricetta->getId_ricetta());
        $this->smarty->assign('immagine', $immagine);
        $this->smarty->assign('modifyRecipeForm', 1);
        $this->smarty->display('userInfo.tpl');
    }

    public function errorImageUpload(){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('addRecipeForm', 1);
        $this->smarty->assign('errorImageUpload', 1);
        $this->smarty->display('userinfo.tpl');
    }
    public function vediRicetta($ricetta, $immagine){
        $loginVariables = (new VUtente)->checkLogin();
        foreach ($loginVariables as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->assign('ricetta', $ricetta);
        $this->smarty->assign('immagine', $immagine);
        $this->smarty->display('vediRicetta.tpl');
    }
}
?>