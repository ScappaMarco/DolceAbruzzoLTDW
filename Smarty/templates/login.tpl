<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/style.css" type="text/css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="form-container">
    <h2 class="text-center">Login</h2>
    {if $errore == 1}
        <div class="mt-5 d-flex justify-content-center">
        <div class="alert alert-danger" role="alert">
            Nome utente o password non corretti!
        </div>
    </div>
    {/if}
    <form method="POST" action="/Dolce_Abruzzo/utente/login">
        <div class="form-group">
            <input name="email-log" type="email" class="form-control" id="email-log" placeholder="Inserisci email...">
        </div>
        <div class="form-group">
            <input name="password-log" type="password" class="form-control" id="password-log" placeholder="Inserisci la password...">
        </div>
        
        <button type="submit" class="btn btn-login btn-block">Login</button>
        <br>
        <a href="/Dolce_Abruzzo/utente/signUp" class="linkpass">Non sei registrato? Registrati!</a>
    </form>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
