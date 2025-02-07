<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/style.css" type="text/css">

</head>

<body>
    {include file='header_section.tpl'}
    <br>
    <!-- Categories Section Begin -->
    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    {foreach from=$array_categorie item=categoria}
                        {if $categoria.nome_categoria == "Tutte le categorie"}
                            <a href="/Dolce_Abruzzo/gestioneAcquisti/shop/all">
                            {else}
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/shop/{$categoria.nome_categoria}">
                                {/if}
                                <div class="categories__item">
                                    <div class="categories__item__icon">
                                        {if $categoria.nome_categoria == "Tutte le categorie"}
                                            <h5 class="active" style="margin-top:25%;">{$categoria.nome_categoria}</h5>
                                        {else}
                                            <img class="center-element" style="width:64px;height:64px;"
                                                src="/Dolce_Abruzzo/skin/cake-main/img/categories-icon/{$categoria.nome_categoria}.png"
                                                alt="">
                                            <h5>{$categoria.nome_categoria}</h5>
                                        {/if}
                                    </div>
                                </div>
                            </a>
                        {/foreach}
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {if $array_prodotti['currentPage'] > 1}
            <a href="?page={$array_prodotti['currentPage']-1}">&laquo; Precedente</a>
        {/if}

        {for $page=1 to $array_prodotti['totalPages']}
            <a href="?page={$page}" {if $page == $array_prodotti['currentPage']}class="active" {/if}>
                {$page}
            </a>
        {/for}

        {if $array_prodotti['currentPage'] < $array_prodotti['totalPages']}
            <a href="?page={$array_prodotti['currentPage']+1}">Successivo &raquo;</a>
        {/if}
    </div>
    <!-- /Pagination -->

    {if $is_arrayprodotti_vuoto == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Non ci sono prodotti disponibili per questa categoria
            </div>
        </div>
    {/if}

    <div class="container mt-4">
        <h4>Filtri</h4>
        <form id="filterForm" method="GET" action="/Dolce_Abruzzo/gestioneAcquisti/shop/{$categoria_corrente}">
            <div class="row">
                <div class="col-md-4">
                    <label for="minPrice">Prezzo minimo:</label>
                    <input type="number" id="minPrice" name="minPrice" class="form-control" value="{$smarty.get.minPrice|default:''}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label for="maxPrice">Prezzo massimo:</label>
                    <input type="number" id="maxPrice" name="maxPrice" class="form-control" value="{$smarty.get.maxPrice|default:''}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="glutenFree" name="glutenFree" value="1" {if isset($smarty.get.glutenFree) && $smarty.get.glutenFree}checked{/if}>
                        <label class="form-check-label" for="glutenFree">
                            Solo prodotti senza glutine
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Applica Filtri</button>
                    <a href="/Dolce_Abruzzo/gestioneAcquisti/shop/{$categoria_corrente}" class="btn btn-secondary">Resetta Filtri</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Categories Section End -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                {foreach from=$array_prodotti['prodotti'] item=prodotto}
                    <!-- product -->
                    <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto->getIdProdotto()}">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="product__item">
                                <div class="product__item__pic set-bg">
                                    {if $prodotto->getImmagini()->first()}
                                        <img style="width:300px; height:300px;"
                                            src="data:{$prodotto->getImmagini()->first()->getType()};base64,{$prodotto->getImmagini()->first()->getEncodedData()}"
                                            alt="Immagine">
                                    {else}
                                        <p>Immagine non trovata</p>
                                    {/if}
                                    <div class="product__label">
                                        <span>{$prodotto->getNome()}</span>
                                    </div>
                                </div>
                                <div class="product__item__text">
                                    <h5>{$prodotto->getNomeCategoria()->getNomeCategoria()}</h5>
                                    <div class="product__item__price">€{$prodotto->getPrezzo()}</div>
                                    <br>
                                    <div class="cart_add">
                                        <a
                                            href="/Dolce_Abruzzo/gestioneAcquisti/aggiungiAlCarrello/{$prodotto->getIdProdotto()}"><button>Aggiungi
                                                al carrello</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- /product -->
                {/foreach}
            </div>
        </div>
    </section>

    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery-3.3.1.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/bootstrap.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nice-select.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.barfiller.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.magnific-popup.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.slicknav.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/owl.carousel.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nicescroll.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/main.js"></script>
<script src="/Dolce_Abruzzo/skin/cake-main/js/scripts-for-template.js"></script>