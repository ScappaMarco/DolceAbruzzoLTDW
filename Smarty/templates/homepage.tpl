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

    {if $signupsuccess == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Registrazione completata con successo! Effettua il login!
            </div>
        </div>
    {/if}

    {if $added_to_cart == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Prodotto aggiunto nel carrello!
            </div>
        </div>
    {/if}

    {if $added_to_wishlist == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Prodotto aggiunto nella lista dei desideri!
            </div>
        </div>
    {/if}

    {if $q_max_raggiunta == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-warning" role="alert">
                Non puoi superare la quantità massima disponibile per ciascun prodotto
            </div>
        </div>
    {/if}

    {if $carrello_svuotato == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Il carrello è stato svuotato
            </div>
        </div>
    {/if}

    {if $lista_desideri_svuotata == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                La lista desideri è stata svuotata
            </div>
        </div>
    {/if}

    {if $elemento_rimosso_da_carrello == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Elemento rimosso con successo dal carrello
            </div>
        </div>
    {/if}

    {if $elemento_rimosso_da_wishlist == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Elemento rimosso con successo dalla lista dei desideri
            </div>
        </div>
    {/if}

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__item set-bg" data-setbg="/Dolce_Abruzzo/skin/cake-main/img/hero/hero-1.jpg">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="testo-hero">
                            <h2>Pasticceria artigianale <br>Dolce Abruzzo!</h2>
                            {if $check_login_chef == 0 && $check_login_admin == 0}<a
                                    href="/Dolce_Abruzzo/gestioneAcquisti/shop/all" class="primary-btn">Scopri i
                                    prodotti</a>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="about__text">
                        <div class="section-title">
                            <a href="/Dolce_Abruzzo/utente/about"><span>About Dolce Abruzzo</span></a>
                            <h2>Dove ogni dolce è un abbraccio di sapore!</h2>
                        </div>
                        <p>Dolce Abruzzo è un'e-commerce di pasticceria dedicata a portare la tradizione e la qualità
                            dei dolci abruzzesi direttamente a casa vostra. La nostra missione è farvi scoprire e amare
                            i sapori autentici e genuini della nostra terra, preparati con ingredienti di prima scelta e
                            con la passione che ci distingue.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div>
                        <img src="/Dolce_Abruzzo/skin/cake-main/img/vetrina.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>Prodotti recenti</span>
                </div>
            </div>
            {if $array_prodotti_home_vuoto == 1}
            <div class="alert alert-danger">
                Attualmente non c'è alcun prodotto disponibile. Torna più tardi
                </div>
            {else}
                <div class="row">
                    {foreach from=$array_prodotti item=prodotto}
                        <!-- product -->
                        {if $check_login_admin == 0 && $check_login_chef == 0}
                            <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$prodotto.id_prodotto}">
                            {/if}
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg">
                                        {if isset($prodotto.images.imageData) && isset($prodotto.images.type)}
                                            <img style="width:300px; height:300px;"
                                                src="data:{$prodotto.images.type};base64,{$prodotto.images.imageData}"
                                                alt="Immagine">
                                        {else}
                                            <p>Immagine non trovata</p>
                                        {/if}
                                        <div class="product__label">
                                            <span>{$prodotto.nome}</span>
                                        </div>
                                    </div>
                                    <div class="product__item__text">
                                        <h5>{$prodotto.nome_categoria}</h5>
                                        <div class="product__item__price">€{$prodotto.prezzo}</div>
                                        <br>
                                        <div class="cart_add">
                                            {if $check_login_admin == 0 && $check_login_chef == 0}
                                                <a
                                                    href="/Dolce_Abruzzo/gestioneAcquisti/aggiungiAlCarrello/{$prodotto.id_prodotto}"><button>Aggiungi
                                                        al carrello</button></a>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- /product -->
                    {/foreach}
                </div>
                {if $check_login_admin == 0 && $check_login_chef == 0}
                    <div class="container mt-3">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <a href="/Dolce_Abruzzo/gestioneAcquisti/shop/all" class="btn btn-outline-primary">Scopri di più nel
                                    nostro Negozio</a>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        {/if}
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <span>Cosa dicono di noi</span>
                    </div>
                </div>
            </div>
            {if $recensioni}
                <div class="row d-flex justify-content-center">
                    <div class="testimonial__slider owl-carousel">
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
                                    <p>{$recensione->getTesto()|truncate:150:"...":true}</p>
                                    <br>
                                    <p>Riferita a: </p>
                                    {if $check_login_admin == 0 && $check_login_chef == 0}
                                        <a href="/Dolce_Abruzzo/gestioneAcquisti/infoProdotto/{$recensione->getprodotto()->getIdProdotto()}"
                                            class="linkpass">
                                            {$recensione->getProdotto()->getNome()}
                                        </a>
                                    {else}
                                        <p>{$recensione->getProdotto()->getNome()}
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

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 p-0">
                    <div class="instagram__text">
                        <div class="section-title">
                            <span>Seguici su instagram</span>
                            <h2>Tradizione che si scioglie in bocca!</h2>
                        </div>
                        <h5><i class="fa fa-instagram"></i> @dolceabruzzo</h5>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-1.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic middle__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-2.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-3.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-4.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic middle__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-5.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="/Dolce_Abruzzo/skin/cake-main/img/instagram/instagram-1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Map Begin -->
    <div class="map">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-7">
                    <div class="map__inner">
                        <h6>L'Aquila</h6>
                        <ul>
                            <li>Via Vetoio, 40, 67100 Coppito AQ</li>
                            <li>Sweetcake@support.com</li>
                            <li>+1 800-786-1000</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="map__iframe">
            <iframe <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6725.3534344247755!2d13.340300956509045!3d42.36934343593935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132fcd66844c93c9%3A0x5bfa37cbb8e55d51!2sUniversit%C3%A0%20degli%20Studi%20dell&#39;Aquila%2C%20edificio%20Coppito%201!5e0!3m2!1sit!2sit!4v1720105804706!5m2!1sit!2sit"
                height="300" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
    <!-- Map End -->

    <!-- Footer Section Begin -->
    <footer class="footer set-bg" data-setbg="/Dolce_Abruzzo/skin/cake-main/img/footer-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>WORKING HOURS</h6>
                        <ul>
                            <li>Monday - Friday: 08:00 am – 20:30 pm</li>
                            <li>Saturday: 10:00 am – 16:30 pm</li>
                            <li>Sunday: 10:00 am – 16:30 pm</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="/Dolce_Abruzzo/utente/home"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/Logo_Dolce_Abruzzo.png" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <p class="copyright__text text-white">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="fa fa-heart"
                                aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <div class="copyright__widget">
                            <ul>
                                <li><a href="/Dolce_Abruzzo/utente/termsAndConditions">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

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