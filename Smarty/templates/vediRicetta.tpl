<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ricetta {$ricetta->getTitolo()}</title>

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
        <div class="row d-flex justify-content-center gap-50">
            <!-- Left Column -->
            <div class="col-md-4">
                <img id="immagine-principale" class="d-block w-100" style="width:400px;height:500px;"
                    src="data:{$immagine->getType()};base64,{$immagine->getEncodedData()}" alt="Immagine Prodotto">
                <div class="thumbnail-image-container">
                    <h4 class="mt-2">Difficoltà: {for $i=1 to $ricetta->getDifficolta()}<span class="icon_star" style="color:#ffd500"></span>{/for}{for $i=4 to $ricetta->getDifficolta() step -1}<span class="icon_star"></span>{/for}</h4>
                    
                    
                </div>
                <h4 class="text-center mt-2">Pubblicata da: {$ricetta->getChefRicetta()->getNome()} {$ricetta->getChefRicetta()->getCognome()}</h4>
            </div>
            <!-- Middle Column -->
            <div class="col-md-7">
                <div class="scrollable-content middle-infoProd">
                    <div class="section-title text-center">
                        <h2>{$ricetta->getTitolo()}</h2>
                        <p>{$ricetta->getDescrizione()}</p>
                        <h3>Ingredienti</h3>
                        <p>{$ricetta->getIngredienti()}</p>
                        <h3>Procedimento</h3>
                        <p>{$ricetta->getProcedimento()}</p>
                    </div>
                </div>
            </div>   
        </div>
    </div>
    <br>
    
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery-3.3.1.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/bootstrap.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nice-select.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.barfiller.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.magnific-popup.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.slicknav.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/owl.carousel.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nicescroll.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/scripts-for-template.js"></script>
</body>

</html>