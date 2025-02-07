<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cake Template">
    <meta name="keywords" content="Cake, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Segnalazioni</title>

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
    <br>
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

    <h2>Elenco Segnalazioni</h2>
    {if $nessuna_segnalazione == 1}
        <div class="mt-5 d-flex justify-content-center">
            <div class="alert alert-info" role="alert">
                Nessuna segnalazione per il momento
            </div>
        </div>
    {else}
        <div class="container mt-5">
            <!-- Pagination -->
            <div class="pagination">
                {if $segnalazioni['currentPage'] > 1}
                    <a href="?page={$segnalazioni['currentPage']-1}">&laquo; Precedente</a>
                {/if}

                {for $page=1 to $segnalazioni['totalPages']}
                    <a href="?page={$page}" {if $page == $segnalazioni['currentPage']}class="active" {/if}>
                        {$page}
                    </a>
                {/for}

                {if $segnalazioni['currentPage'] < $segnalazioni['totalPages']}
                    <a href="?page={$segnalazioni['currentPage']+1}">Successivo &raquo;</a>
                {/if}
            </div>
            <!-- /Pagination -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Segnalazione</th>
                        <th>Utente Segnalante</th>
                        <th>Recensione Segnalata</th>
                        <th>Autore Recensione</th>
                        <th>Testo Segnalazione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $segnalazioni['segnalazioni'] as $segnalazione}
                        <tr>
                            <td>{$segnalazione->getId_segnalazione()}</td>
                            <td>{$segnalazione->getUtente()->getUsername()}</td>
                            <td>{$segnalazione->getRecensioneSegnalata()->getTesto()|truncate:50:"..."}</td>
                            <td>{$segnalazione->getRecensioneSegnalata()->getCliente()->getUsername()}</td>
                            <td>{$segnalazione->getTesto()}</td>
                            <td>
                                {if $segnalazione->getRecensioneSegnalata()->getCliente()->getRoles()->last()->getName() == 'utente_bloccato'}
                                    <a href="/Dolce_Abruzzo/utente/sbloccaUtente/{$segnalazione->getRecensioneSegnalata()->getCliente()->getIdCliente()}"
                                        class="btn btn-success btn-sm">Sblocca Utente</a>
                                {else}
                                    <a href="/Dolce_Abruzzo/utente/bloccaUtente/{$segnalazione->getRecensioneSegnalata()->getCliente()->getIdCliente()}"
                                        class="btn btn-warning btn-sm">Blocca Utente</a>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
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
    <script src="/Dolce_Abruzzo/skin/cake-main/js/scripts-for-template.js"></script>
</body>

</html>