<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ordine Completato - Dolce Abruzzo</title>

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
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Ordine Completato con Successo</h2>
                <p>Il tuo ordine numero {$ordine->getId_ordine()} è stato registrato correttamente.</p>
                <p>Importo totale: €{$ordine->getImporto_ordine()|string_format:"%.2f"}</p>
                {if $ordine->getCodiceSconto()}
                    <p>Sconto applicato: {$ordine->getCodiceSconto()->getValore_sconto()}%</p>
                {/if}
                <p>Data ordine: {$ordine->getData_ordine()->format('d/m/Y')}</p>
                <p>Stato ordine: {$ordine->getStato_ordine()}</p>
                <p>Grazie per il tuo acquisto!</p>
                <a href="/Dolce_Abruzzo/utente/userHistoryOrders" class="btn btn-primary">Visualizza Storico Ordini</a>
                <a href="/Dolce_Abruzzo/utente/home" class="btn btn-secondary">Torna alla Home</a>
            </div>
        </div>
    </div>
</body>
</html>