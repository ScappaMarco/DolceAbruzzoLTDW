<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodotto {$prodotto[0]->getNome()}</title>

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
                    src="data:{$immagini[0].type};base64,{$immagini[0].imageData}" alt="Immagine Prodotto">
                <div class="thumbnail-image-container">
                    {foreach from=$immagini item=immagine}
                        <img class="thumbnail-image" style="width:100px; height:100px;"
                            src="data:{$immagine.type};base64,{$immagine.imageData}" alt="Immagine Prodotto">
                    {/foreach}
                    <!-- <img src="path/to/thumb1.png" alt="Thumbnail 1" class="img-fluid thumbnail-image mr-2"> -->
                </div>
            </div>
            <!-- Middle Column -->
            <div class="col-md-4">
                <div class="scrollable-content middle-infoProd">
                    <div class="section-title">
                        <h2>{$prodotto[0]->getNome()}</h2>
                        <p>{$prodotto[0]->getDescrizione()}</p>
                        <h3>Ingredienti</h3>
                        <p>{$prodotto[0]->getIngredienti()}</p>
                    </div>
                </div>
            </div>
            <!-- Right Column -->
            <div class="col-md-2 right-infoProd">
                <div class="price">Prezzo: <span>€{$prodotto[0]->getPrezzo()}</span></div>
                <div class="availability">Ancora disponibile: {$prodotto[0]->getQuantitaDisp()}</div>

                <form id="gestioneAcquisti" action="" method="POST">
                    <select class="margin-bottom-20" id="quantity" name="quantity">
                        <!-- Controllo la quantità disp quando è minore di 10,
                Se è minore di 10, mettere tanti option quanto è le quantità 
                altrimenti fisso la quantità max a 10 -->
                        {if $prodotto[0]->getQuantitaDisp() >= 10}
                            {for $i=1 to 10}
                                <option value="{$i}">Quantità: {$i}</option>
                            {/for}
                        {else}
                            {for $i=1 to $prodotto[0]->getQuantitaDisp()}
                                <option value="{$i}">Quantità: {$i}</option>
                            {/for}
                        {/if}
                    </select>
                    <div class="mt-3">
                        {if $prodotto[0]->getQuantitaDisp() == 0}
                            <p class="card-text"><i>Questo prodotto è attualmente terminato</i></p>
                            <a href="#" class="disabled-link">Out of Stock</a>
                        {elseif $prodotto[0]->getQuantitaDisp() > 0}
                            <button class="btn btn-primary btn-block" type="submit"
                                onclick="cambiaAzione('/Dolce_Abruzzo/gestioneAcquisti/aggiungiAlCarrello/{$prodotto[0]->getIdProdotto()}')">Aggiungi
                                al Carrello</button>
                            {if $is_in_cart == 1}
                                <h6 class="attention-note">già nel carrello: {$carrello[$prodotto[0]->getIdProdotto()]}</h6>
                            {/if}
                            <button class="btn btn-login btn-block" type="submit"
                                onclick="cambiaAzione('/Dolce_Abruzzo/gestioneAcquisti/acquistaSubito/{$prodotto[0]->getIdProdotto()}')">Acquista
                                adesso</button>
                        {/if}
                </form>
            </div>
            <div class="mt-3">
                {if $prodotto[0]->getIsGlutenFree() == true}
                    <p class="card-text"><i>*Buone notizie: questo prodotto è gluten free</i></p>
                {elseif $prodotto[0]->getIsGlutenFree() == false}
                    <p class="card-text"><i>*Attenzione: questo prodotto non è gluten free</i></p>
                {/if}
                <p>Punti fedeltà: {$prodotto[0]->getPunti_fedelta()} </p>
            </div>
            {if $is_in_wishlist == 0}
                <form action="/Dolce_Abruzzo/utente/aggiungiAllaWishlist/{$prodotto[0]->getIdProdotto()}">
                    <button class="btn btn-fav btn-block" type="submit">Salva tra i preferiti</button>
                </form>
            {else if $is_in_wishlist == 1}
                <form action="/Dolce_Abruzzo/utente/aggiungiAllaWishlist/{$prodotto[0]->getIdProdotto()}">
                    <button class="btn btn-fav btn-block not-allowed" type="submit" disabled>Il prodotto si trova già nella lista dei desideri</button>
                </form>
            {/if}
            <div class="mt-3">
                <a href="/Dolce_Abruzzo/utente/termsAndConditions" class="linkpass">Per saperne di più sulle nostre
                    politiche di reso, clicca qui!</a>
            </div>
        </div>
    </div>
    </div>
    <br>
    {if $review_added == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Recensione pubblicata con successo!
            </div>
        </div>
    {/if}
    {if $segn_inviata == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Segnalazione inviata con successo
            </div>
        </div>
    {/if}
    {if $segn_err == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Si è verificato un errore durante l'invio della segnalazione.
            </div>
        </div>
    {/if}
    {if $segn_esistente == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-warning" role="alert">
                Hai già segnalato questa recensione
            </div>
        </div>
    {/if}
    {if $cannot_write_review == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Non puoi recensire il prodotto perché non lo hai acquistato
            </div>
        </div>
    {/if}
    <!-- Testimonial Section Begin -->
    <section class="testimonial spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <span>Recensioni su {$prodotto[0]->getNome()}</span>
                    </div>
                </div>
            </div>
            {if $recensioni}
            <div class="row d-flex justify-content-center">
                {if $hasNextReview == 1}<div class="testimonial__slider owl-carousel">{/if}
                    {foreach from=$recensioni item=recensione}
                        <div class="col-lg-6">
                            <div class="testimonial__item">
                                <div class="testimonial__author">

                                    <div class="testimonial__author__text">
                                        <h5>{$recensione->getCliente()->getUsername()}</h5>
                                        {if $check_login_cliente == 1 && $smarty.session.utente->getIdCliente() == $recensione->getCliente()->getIdCliente()}<span>(Tu)</span>{/if}  
                                    </div>
                                </div>
                                <div class="rating">
                                <p class="card-text"><i>Acquisto verificato</i></p>
                                    {for $i=1 to $recensione->getValutazione()}
                                        <span class="icon_star"></span>
                                    {/for}
                                </div>
                                <br>
                                <p>{$recensione->getTesto()}</p>
                                <br>
                                {if $check_login_cliente == 1 && $smarty.session.utente->getIdCliente() != $recensione->getCliente()->getIdCliente()}
                                    <button class="btn btn-danger mt-3" onclick="segnalaRecensione({$recensione->getId_recensione()})">Segnala</button>
                                {else}
                                <br>
                                {/if}
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
            {else}
                <p>Nessuna recensione disponibile per questo prodotto.</p>
            {/if}
        </div>
    </section>
    <!-- Testimonial Section End -->
    <div class="recensione-form mt-5 p-4 bg-light rounded shadow">
        <h4 class="mb-4">Scrivi una recensione</h4>
        <p class="card-text"><i>*Nota: devi aver effettuato un ordine prima di recensire il prodotto</i></p>
        <form action="/Dolce_Abruzzo/gestioneAcquisti/aggiungiRecensione/{$prodotto[0]->getIdProdotto()}" method="POST" class="needs-validation" novalidate>
            <div class="form-group mb-4">
                <label for="testo" class="form-label">La tua recensione:</label>
                <textarea class="form-control" id="testo" name="testo" rows="4" required></textarea>
                <div class="invalid-feedback">
                    Per favore, inserisci il testo della tua recensione.
                </div>
            </div>
            <div class="form-group mb-4">
                <label class="form-label d-block">Valutazione:</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="valutazione" value="5" required /><label for="star5" title="5 stelle"></label>
                    <input type="radio" id="star4" name="valutazione" value="4" /><label for="star4" title="4 stelle"></label>
                    <input type="radio" id="star3" name="valutazione" value="3" /><label for="star3" title="3 stelle"></label>
                    <input type="radio" id="star2" name="valutazione" value="2" /><label for="star2" title="2 stelle"></label>
                    <input type="radio" id="star1" name="valutazione" value="1" /><label for="star1" title="1 stella"></label>
                </div>
                <div class="invalid-feedback mt-2">
                    Per favore, seleziona una valutazione.
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Invia recensione</button>
        </form>
    </div>
    <br>
    <script>
    function segnalaRecensione(idRecensione) {
    if (confirm("Sei sicuro di voler segnalare questa recensione?")) {
        window.location.href = "/Dolce_Abruzzo/utente/segnalaRecensione/" + idRecensione;
    }
    }
    </script>
    <script>
        var immaginePrincipale = document.getElementById('immagine-principale');
        var thumbnailImages = document.getElementsByClassName('thumbnail-image');

        for (var i = 0; i < thumbnailImages.length; i++) {
            thumbnailImages[i].addEventListener('click', function() {
                immaginePrincipale.src = this.src;
            });
        }
    </script>
    <script>
        function cambiaAzione(action) {
            document.getElementById('gestioneAcquisti').action = action;
        }
    </script>
    
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