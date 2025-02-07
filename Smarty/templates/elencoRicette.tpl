<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ricette</title>

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

    <div class="pagination">
        {if $array_ricette['currentPage'] > 1}
            <a href="?page={$array_ricette['currentPage']-1}">&laquo; Precedente</a>
        {/if}

        {for $page=1 to $array_ricette['totalPages']}
            <a href="?page={$page}" {if $page == $array_ricette['currentPage']}class="active" {/if}>
                {$page}
            </a>
        {/for}

        {if $array_ricette['currentPage'] < $array_ricette['totalPages']}
            <a href="?page={$array_ricette['currentPage']+1}">Successivo &raquo;</a>
        {/if}
    </div>

    {if $is_array_ricette_vuoto == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Non ci sono ricette disponibili al momento
            </div>
        </div>
    {/if}

    <section class="product spad">
        <div class="container">
            <div class="row">
                {foreach from=$array_ricette['ricette'] item=ricetta}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="/Dolce_Abruzzo/utente/vediRicetta/{$ricetta->getId_ricetta()}">
                            <div class="product__item">
                                <div class="product__item__pic set-bg">
                                    {if isset($ricetta->getImmagine()->getImageData()) && isset($ricetta->getImmagine()->getType())}
                                        <img style="width:300px; height:300px;"
                                            src="data:{$ricetta->getImmagine()->getType()};base64,{$ricetta->getImmagine()->getEncodedData()}"
                                            alt="Immagine">
                                    {else}
                                        <p>Immagine non trovata</p>
                                    {/if}
                                    <div class="product__label">
                                        <span>{$ricetta->getTitolo()}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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
</body>