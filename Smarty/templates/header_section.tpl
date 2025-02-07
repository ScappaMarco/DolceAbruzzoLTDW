<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="header__top__inner">
            <div class="header__top__left">
                <ul>
                    {if $check_login_cliente == 1}
                        <a><img src="/Dolce_Abruzzo/skin/cake-main/img/user.png" alt=""></a>
                        <li><a id="userMenuBtn" class="accedi">Cliente</a></li>
                        <a href="/Dolce_Abruzzo/utente/logout"><img
                                src="/Dolce_Abruzzo/skin/cake-main/img/icon/BoxArrowLeft.png" alt=""></a>
                        <li><a href="/Dolce_Abruzzo/utente/logout" class="accedi">Logout</a></li>
                        <div id="userMenu" class="dropdown-content">
                            <img id="polygon" src="/Dolce_Abruzzo/skin/cake-main/img/icon/polygon.png" alt="">
                            <a href="/Dolce_Abruzzo/utente/userDataSection"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/personal_data.png" alt="">I miei dati
                                personali</a>
                            <a href="/Dolce_Abruzzo/utente/userHistoryOrders"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/history_orders.png" alt="">Storico
                                ordini</a>
                            <a href="/Dolce_Abruzzo/utente/userDiscounts"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/discount.png" alt="">Area sconti</a>
                        </div>
                    {elseif $check_login_chef == 1}
                        <a><img src="/Dolce_Abruzzo/skin/cake-main/img/user.png" alt=""></a>
                        <li><a id="userMenuBtn" class="accedi">Chef</a></li>
                        <a href="/Dolce_Abruzzo/utente/logout"><img
                                src="/Dolce_Abruzzo/skin/cake-main/img/icon/BoxArrowLeft.png" alt=""></a>
                        <li><a href="/Dolce_Abruzzo/utente/logout" class="accedi">Logout</a></li>
                        <div id="userMenu" class="dropdown-content">
                            <img id="polygon" src="/Dolce_Abruzzo/skin/cake-main/img/icon/polygon.png" alt="">
                            <a href="/Dolce_Abruzzo/utente/userDataSection"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/personal_data.png" alt="">I miei dati
                                personali</a>
                            <a href="/Dolce_Abruzzo/gestioneRicette/listaRicette"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/history_orders.png" alt="">Gestione
                                ricette</a>
                        </div>
                    {elseif $check_login_admin == 1}
                        <a><img src="/Dolce_Abruzzo/skin/cake-main/img/user.png" alt=""></a>
                        <li><a id="userMenuBtn" class="accedi">Admin</a></li>
                        <a href="/Dolce_Abruzzo/utente/logout"><img
                                src="/Dolce_Abruzzo/skin/cake-main/img/icon/BoxArrowLeft.png" alt=""></a>
                        <li><a href="/Dolce_Abruzzo/utente/logout" class="accedi">Logout</a></li>
                        <div id="userMenu" class="dropdown-content">
                            <img id="polygon" src="/Dolce_Abruzzo/skin/cake-main/img/icon/polygon.png" alt="">
                            <a href="/Dolce_Abruzzo/utente/userDataSection"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/personal_data.png" alt="">I miei dati
                                personali</a>
                            <a href="/Dolce_Abruzzo/utente/adminOrderManagement"><img
                                src="/Dolce_Abruzzo/skin/cake-main/img/icon/history_orders.png" alt="">Gestione
                                Ordini</a>
                            <a href="/Dolce_Abruzzo/gestioneProdotti/listaProdotti"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/ListIcon.png" alt="">Gestione Prodotti</a>
                            <a href="/Dolce_Abruzzo/utente/visualizzaSegnalazioni"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/ListIcon.png" alt="">Gestione segnalazioni</a>
                            <a href="/Dolce_Abruzzo/utente/visualizzaUtenti"><img
                                    src="/Dolce_Abruzzo/skin/cake-main/img/icon/ListIcon.png" alt="">Gestione utenti</a>
                        </div>
                    {elseif $utente_non_loggato == 1}
                        <li><a href="/Dolce_Abruzzo/utente/login" class="accedi">Accedi</a></li>
                    {/if}
                    <li>|</li>
                    <li><img src="/Dolce_Abruzzo/skin/cake-main/img/icon/search.png" alt=""></li>

                    <li>
                        <!-- Search Begin -->
                        <div class="search-model">
                            <form action="/Dolce_Abruzzo/gestioneAcquisti/ricerca" method="GET" class="search-model-form">
                                <input type="text" id="search-input" name="q" placeholder="Cerca prodotti...">
                            </form>
                        </div>
                        <!-- Search End -->
                    </li>
                </ul>
            </div>
            <div class="header__logo">
                <a href="/Dolce_Abruzzo/utente/home"><img src="/Dolce_Abruzzo/skin/cake-main/img/Logo_Dolce_Abruzzo.png"
                        alt=""></a>
            </div>
            <div class="header__top__right">
                {if ($check_login_cliente == 1 || $utente_non_loggato == 1) && ($check_login_admin == 0 && $check_login_chef == 0)}
                    <div class="header__top__right__links">
                        <a href="/Dolce_Abruzzo/utente/wishlist"><img src="/Dolce_Abruzzo/skin/cake-main/img/icon/heart.png"
                                alt=""></a>
                    </div>
                    <div class="header__top__right__cart">
                        <a href="/Dolce_Abruzzo/gestioneAcquisti/cart"><img src="/Dolce_Abruzzo/skin/cake-main/img/icon/cart.png"
                                alt=""> <span id="numeroAcquisti">{$cart_quantity}</span></a>
                    </div>
                {/if}
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li {if $home == 1} class="active" {/if}><a href="/Dolce_Abruzzo/utente/home">Home</a></li>
                        <li {if $about == 1} class="active" {/if}><a href="/Dolce_Abruzzo/utente/about">About</a></li>
                        {if $check_login_chef == 0 && $check_login_admin == 0}<li {if $shop == 1} class="active" {/if}><a href="/Dolce_Abruzzo/gestioneAcquisti/shop/all">Negozio</a></li>{/if}
                        <li {if $ricette == 1} class="active" {/if}><a href="/Dolce_Abruzzo/utente/elencoRicette">Ricette</a></li>
                        <li {if $contatti == 1} class="active" {/if}><a href="/Dolce_Abruzzo/utente/contatti">Contatti</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header Section End -->