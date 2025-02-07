<!DOCTYPE html>
<html lang="zxx">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Cake Template">
        <meta name="keywords" content="Cake, unica, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Utenti</title>

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
    {if $user_blocked == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Utente bloccato con successo!
            </div>
        </div>
    {/if}
    {if $user_unblocked == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-success" role="alert">
                Utente sbloccato con successo!
            </div>
        </div>
    {/if}
    {if $user_not_found == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-danger" role="alert">
                Utente non trovato!
            </div>
        </div>
    {/if}
    <!-- Pagination -->
    <div class="pagination">
        {if $result['currentPage'] > 1}
            <a href="?page={$result['currentPage']-1}">&laquo; Precedente</a>
        {/if}

        {for $page=1 to $result['totalPages']}
            <a href="?page={$page}" {if $page == $result['currentPage']}class="active" {/if}>
                {$page}
            </a>
        {/for}

        {if $result['currentPage'] < $result['totalPages']}
            <a href="?page={$result['currentPage']+1}">Successivo &raquo;</a>
        {/if}
    </div>
    <!-- /Pagination -->
        <h2>Elenco Utenti</h2>
        {if $result.utenti|@count > 0}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Utente</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $result.utenti as $utente}
                        <tr>
                            <td>{$utente->getIdCliente()}</td>
                            <td>{$utente->getUsername()}</td>
                            <td>{$utente->getEmail()}</td>
                            <td>{if $utente->getRoles()->last()->getName() == 'utente_bloccato'}<p class="text-danger">Bloccato</p>{else}<p class="text-success">Attivo</p>{/if}</td>
                            <td>
                                {if $utente->getRoles()->last()->getName() == 'utente_bloccato'}
                                    <a href="/Dolce_Abruzzo/utente/sbloccaUtente/{$utente->getIdCliente()}" class="btn btn-success btn-sm">Sblocca Utente</a>
                                {elseif $utente->getRoles()->last()->getName() == 'admin'}
                                    <span class="text-muted">Account Admin</span>
                                {else}
                                    <a href="/Dolce_Abruzzo/utente/bloccaUtente/{$utente->getIdCliente()}" class="btn btn-warning btn-sm">Blocca Utente</a>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p>Non ci sono utenti al momento.</p>
        {/if}
    </div>

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