<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrello</title>

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
            <h2>Carrello</h2>
            {if $is_cart_empty == 0}
                <div class="">
                    <a href="/Dolce_Abruzzo/gestioneAcquisti/svuotaCarrello "
                        class="btn btn-outline-danger btn-block">Svuota il carrello</a>
                </div>
            {/if}
        </div>
    </div>

    {if $elemento_rimosso_da_carrello == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Prodotto rimosso dal carrello
            </div>
        </div>
    {/if}

    {if $qty_updated == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Quantità aggiornata con successo
            </div>
        </div>
    {/if}

    {if $is_cart_empty == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Il carrello è attualmente vuoto
            </div>
        </div>
    {else}
        {assign var="subtotale" value=0}
        {foreach from=$prodotti_carrello item=prodotto}
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
                                <h6>{$prodotto->getDescrizione()|truncate:300:"...":true}</h6>
                                <div class="d-flex align-items-center justify-content-around mt-5">
                                    <p class="card-text mt-3">Quantità selezionata: {$carrello[$prodotto->getIdProdotto()]}</p>
                                    <form method="POST"
                                        action="/Dolce_Abruzzo/gestioneAcquisti/aggiornaQuantitaCarrello/{$prodotto->getIdProdotto()}">
                                        <select class="ml-5" id="quantity" name="quantity">
                                            {if $prodotto->getQuantitaDisp() >= 10}
                                                {for $i=1 to 10}
                                                    <option value="{$i}" {if $carrello[$prodotto->getIdProdotto()] == $i}selected{/if}>
                                                        Quantità: {$i}</option>
                                                {/for}
                                            {else}
                                                {for $i=1 to $prodotto->getQuantitaDisp()}
                                                    <option value="{$i}" {if $carrello[$prodotto->getIdProdotto()] == $i}selected{/if}>
                                                        Quantità: {$i}</option>
                                                {/for}
                                            {/if}
                                        </select>
                                        <button type="submit" class="btn btn-md btn-info ml-3"> Aggiorna quantità</button>
                                    </form>
                                    <h4 class="ml-3 d-flex align-items-center">Prezzo :
                                        €{$prodotto->getPrezzo()*$carrello[$prodotto->getIdProdotto()]}</h4>
                                    {assign var="subtotale" value=$subtotale + ($prodotto->getPrezzo() * $carrello[$prodotto->getIdProdotto()])}
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto->getIdProdotto()}"
                                    class="btn btn-md btn-info mr-3"> Vedi prodotto</a>
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/rimuoviDaCarrello/{$prodotto->getIdProdotto()}"><img
                                        style="width:40px; height:40px;" src="/Dolce_Abruzzo/skin/cake-main/img/icon/delete.png"
                                        alt=""></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
        <div class="container mt-5 about pt-4 pb-4">
            <div class="row d-flex justify-content-end">
                <div class="col-3">
                    <h5 class="card-title">Riepilogo ordine</h5>
                    <div class="price">SubTotale: <span>€{$subtotale|string_format:"%.2f"}</span></div>
                    <a href="/Dolce_Abruzzo/gestioneAcquisti/procediOrdineCarrello" class="btn btn-outline-primary">Procedi
                        all'ordine</a>
                </div>
            </div>
        </div>
    {/if}

    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery-3.3.1.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/bootstrap.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nice-select.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.barfiller.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.magnific-popup.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.slicknav.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/owl.carousel.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/jquery.nicescroll.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/scripts-for-template.js"></script>

</body>

</html>