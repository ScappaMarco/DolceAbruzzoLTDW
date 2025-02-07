<!DOCTYPE html>
<html lang="zxx">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Cake Template">
        <meta name="keywords" content="Cake, unica, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Risultati</title>

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
    <div class="container mt-5">
        <h2>Risultati della ricerca per: {$query}</h2>
        
        {if $isEmpty}
            <p>Nessun risultato trovato per la tua ricerca.</p>
        {else}
            <div class="row">
                {foreach from=$risultati.prodotti item=prodotto}
                    {if $check_login_admin == 0 && $check_login_chef == 0}
                        <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto->getIdProdotto()}">
                    {/if}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg">
                                {if $prodotto->getImmagini()->first()}
                                    <img style="width:100%; height:auto;"
                                        src="data:{$prodotto->getImmagini()->first()->getType()};base64,{$prodotto->getImmagini()->first()->getEncodedData()}"
                                        alt="{$prodotto->getNome()}">
                                {else}
                                    <p>Immagine non disponibile</p>
                                {/if}
                            </div>
                            <div class="product__item__text">
                                <h6><a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto->getIdProdotto()}">{$prodotto->getNome()}</a></h6>
                                <div class="product__item__price">€{$prodotto->getPrezzo()}</div>
                                <div class="cart_add">
                                {if $check_login_admin == 0 && $check_login_chef == 0}
                                    <a
                                        href="/Dolce_Abruzzo/gestioneAcquisti/aggiungiAlCarrello/{$prodotto->getIdProdotto()}"><button>Aggiungi
                                            al carrello</button></a>
                                {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                {if $risultati.currentPage > 1}
                    <a href="?q={$query}&page={$risultati.currentPage-1}">&laquo; Precedente</a>
                {/if}

                {for $page=1 to $risultati.totalPages}
                    <a href="?q={$query}&page={$page}" {if $page == $risultati.currentPage}class="active"{/if}>
                        {$page}
                    </a>
                {/for}

                {if $risultati.currentPage < $risultati.totalPages}
                    <a href="?q={$query}&page={$risultati.currentPage+1}">Successivo &raquo;</a>
                {/if}
            </div>
        {/if}
    </div>
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
    </body>
</html>