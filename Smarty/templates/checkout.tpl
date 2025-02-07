<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dolce Abruzzo</title>

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
            <div class="col-md-8">
                {foreach from=$data['prodotti'] item=prodotto}
                    <div class="card mb-3">
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
                                    <h5 class="card-title">{$prodotto->getNome()}</h5>
                                    <p class="card-text">Quantità: {$data['carrello'][$prodotto->getIdProdotto()]}</p>
                                    <p class="card-text">Prezzo: €{$prodotto->getPrezzo() * $data['carrello'][$prodotto->getIdProdotto()]|string_format:"%.2f"}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>

            <div class="col-md-4">
                <h3>Riepilogo Ordine</h3>
                <div class="price">SubTotale: <span>€{$data['subtotale']|string_format:"%.2f"}</span></div>
                    <form id="orderForm" action="" method="POST">
                        {assign var="hasActiveAddresses" value=false}
                        {assign var="hasActiveCards" value=false}

                        <!-- Visualizzazione dei punti fedeltà che si guadagneranno -->
                        <div class="mt-3">
                            <p>Punti fedeltà che guadagnerai: <span>{$data['punti_fedelta']}</span></p>
                        </div>

                        <!-- Campo per il codice sconto -->
                        <div class="form-group mt-3">
                            <label for="codice_sconto">Codice Sconto:</label>
                            <input type="text" class="form-control" id="codice_sconto" name="codice_sconto" value="{$data['codice_sconto']|default:''}">
                        </div>
                        <button type="submit" name="applica_sconto" class="btn btn-secondary"  onclick="cambiaAzione('/Dolce_Abruzzo/gestioneAcquisti/procediOrdineCarrello')">Applica Sconto</button>
                        
                        {if isset($data['messaggio_sconto'])}
                            <p class="{if $data['sconto_applicato']}text-success{else}text-danger{/if}">{$data['messaggio_sconto']}</p>
                        {/if}

                        <h3>Indirizzo di spedizione</h3>
                        {foreach $data['indirizzi'] as $indirizzo}
                            {if !$indirizzo->isDeleted()}
                                {assign var="hasActiveAddresses" value=true}
                                {break}
                            {/if}
                        {/foreach}
                        
                        {if $hasActiveAddresses}
                            <select class="form-control mt-3" id="indirizzo" name="indirizzo" required>
                                {foreach $data['indirizzi'] as $indirizzo}
                                    {if !$indirizzo->isDeleted()}
                                        <option value="{$indirizzo->getIndirizzo()}|{$indirizzo->getCap()}">
                                            {$indirizzo->getIndirizzo()}, {$indirizzo->getCap()}
                                        </option>
                                    {/if}
                                {/foreach}
                            </select>
                        {else}
                            <p class="alert alert-warning">Non hai indirizzi attivi.</p>
                            <a href="/Dolce_Abruzzo/utente/indirizzi" class="btn btn-primary">Aggiungi un indirizzo</a>
                        {/if}
                        <br><br>
                        <h3 class="mt-4">Carta di credito</h3>
                        {foreach $data['carte'] as $carta}
                            {if !$carta->isDeleted()}
                                {assign var="hasActiveCards" value=true}
                                {break}
                            {/if}
                        {/foreach}
                        
                        {if $hasActiveCards}
                            <select class="form-control mt-3" id="carta" name="carta" required>
                                {foreach $data['carte'] as $carta}
                                    {if !$carta->isDeleted()}
                                        <option value="{$carta->getNumero_carta()}">
                                            **** **** **** {$carta->getNumero_carta()|substr:-4} - Scadenza: {$carta->getData_scadenza()}
                                        </option>
                                    {/if}
                                {/foreach}
                            </select>
                        {else}
                            <p class="alert alert-warning">Non hai carte di credito attive.</p>
                            <a href="/Dolce_Abruzzo/utente/carteCredito" class="btn btn-primary">Aggiungi una carta di credito</a>
                        {/if}
                        <br><br><br>
                        <div class="mt-4">
                            {if isset($data['sconto_applicato']) && $data['sconto_applicato']}
                                <div class="price mt-2">Totale con sconto: <span>€{$data['totale_scontato']|string_format:"%.2f"}</span></div>
                            {/if}
                            <button onclick="cambiaAzione('/Dolce_Abruzzo/gestioneAcquisti/confermaOrdine')" type="submit" class="btn btn-success" {if !$hasActiveAddresses || !$hasActiveCards}disabled{/if}>
                                Conferma Ordine
                            </button>
                            {if !$hasActiveAddresses || !$hasActiveCards}
                                <p class="text-danger mt-2">Per procedere con l'ordine, assicurati di avere almeno un indirizzo e una carta di credito attivi.</p>
                            {/if}
                        </div>
                    </form>
            </div>
        </div>
    </div>
    <script>
    function cambiaAzione(action) {
        document.getElementById('orderForm').action = action;
    }
</script>
    <!-- Js Plugins -->
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