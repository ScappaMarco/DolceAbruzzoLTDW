<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Area utente</title>

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
    <!-- Contenuto principale -->
    <main>
        <div class="external-area">
            <div class="content-area">
                {if $userDataForm == 1}
                    {include file='userDataForm.tpl'}
                {elseif $userHistoryOrders == 1}
                    {include file='userHistoryOrders.tpl'}
                {elseif $userDiscounts == 1}
                    {include file='userDiscounts.tpl'}
                {elseif $changepass == 1}
                    {include file='change-pass.tpl'}
                {elseif $userDataSection == 1}
                    {include file='userDataSection.tpl'}
                {elseif $listaProdotti == 1}
                    {include file='listaProdotti.tpl'}
                {elseif $addProductForm == 1}
                    {include file='addProductForm.tpl'}
                {elseif $listaRicette == 1}
                    {include file='listaRicette.tpl'}
                {elseif $addRecipeForm == 1}
                    {include file='addRecipeForm.tpl'}
                {elseif $modifyProductForm == 1}
                    {include file='modifyProductForm.tpl'}
                {elseif $modifyRecipeForm == 1}
                    {include file='modifyRecipeForm.tpl'}
                {elseif $indirizzi == 1}
                    {include file='indirizzi.tpl'}
                {elseif $carteCredito == 1}
                    {include file='carteCredito.tpl'}
                {elseif $aggiungiIndirizzi == 1}
                    {include file='aggiungiIndirizzi.tpl'}
                {elseif $aggiungiCarte == 1}
                    {include file='aggiungiCarte.tpl'}
                {elseif $dettaglioOrdine == 1}
                    {include file='dettaglioOrdine.tpl'}
                {elseif $codiciSconto == 1}
                    {include file='codiciSconto.tpl'}
                {elseif $adminOrderManagement == 1}
                    {include file='adminOrderManagement.tpl'}
                {/if}
            </div>
        </div>
    </main>

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