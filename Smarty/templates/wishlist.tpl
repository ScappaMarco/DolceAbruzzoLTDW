<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wishlist</title>

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

    <div class="container text-center mt-5">
        <div class="row d-flex justify-content-between mx-2">
            <h2>Lista dei desideri</h2>
            {if $is_wishlist_empty == 0}
                <div class="">
                    <a href="/Dolce_Abruzzo/utente/svuotaListaDesideri " class="btn btn-outline-danger btn-block">Svuota la lista desideri</a>
                </div>
            {/if}
    </div>

    {if $is_wishlist_empty == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                La lista dei desideri è attualmente vuota
            </div>
        </div>
    {/if}


    {if $elemento_rimosso_da_wishlist == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Prodotto rimosso dalla lista dei desideri
            </div>
        </div>
    {/if}
    
    {foreach from=$prodotti_wishlist item=prodotto}
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="product__item__pic set-bg">
                                    {if $prodotto->getImmagini()->first()}
                                        <img style="width:200px; height:200px;"
                                            src="data:{$prodotto->getImmagini()->first()->getType()};base64,{$prodotto->getImmagini()->first()->getEncodedData()}"
                                            alt="Immagine">
                                    {else}
                                        <p>Immagine non trovata</p>
                                    {/if}
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title">{$prodotto->getNome()}</h4>
                                <h6>{$prodotto->getDescrizione()}</h6>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto->getIdProdotto()}" class="btn btn-md btn-info mr-3"> Vedi prodotto</a>
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/aggiungiAlCarrello/{$prodotto->getIdProdotto()}"
                                    class="btn btn-md btn-primary mr-3">Sposta nel carrello</a>
                                <a href="/Dolce_Abruzzo/utente/rimuoviDaListaDesideri/{$prodotto->getIdProdotto()}"><img
                                        style="width:40px; height:40px;"
                                        src="/Dolce_Abruzzo/skin/cake-main/img/icon/delete.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    {/foreach}

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