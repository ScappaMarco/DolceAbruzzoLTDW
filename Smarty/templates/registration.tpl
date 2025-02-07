<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/style.css" type="text/css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Dolce_Abruzzo/skin/cake-main/css/style.css" type="text/css">
</head>

<body>

    <div class="form-container">
        <h2 class="text-center">Registrazione</h2>
        {if $errore_r == 1}
            <div class="mt-5 d-flex justify-content-center">
                <div class="alert alert-danger" role="alert">
                    Email già esistente! Registrati con un'altra email!
                </div>
            </div>
        {/if}

        {if $check_pass == 1}
            <div class="mt-5 d-flex justify-content-center">
                <div class="alert alert-danger" role="alert">
                    Le password non coincidono! Riprovare
                </div>
            </div>
        {/if}

        <form id="registrationForm" method="POST" action="/Dolce_Abruzzo/utente/signUp">
            <div class="form-group">
                <label for="userType" class="form-label">Sei un cliente o uno chef?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="cliente" value="cliente" required>
                    <label class="form-check-label" for="cliente">
                        Cliente
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="userType" id="chef" value="chef" required>
                    <label class="form-check-label" for="chef">
                        Chef
                    </label>
                </div>
            </div>
            <div class="form-group">

                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome..." required>
            </div>
            <div class="form-group">

                <input name="cognome" type="text" class="form-control" id="cognome" placeholder="Cognome..." required>
            </div>
            <div class="form-group">

                <input name="username" type="text" class="form-control" id="username" placeholder="Username..."
                    required>
            </div>
            <div class="form-group">

                <input name="cellulare" type="tel" class="form-control" id="cellulare" placeholder="es. 3456789333"
                    pattern="[0-9]+" maxlength="10" required>
            </div>

            <div class="form-group">
                <div class="chef-fields">
                    <input name="specializzazione" type="text" class="form-control" id="specializzazione"
                        placeholder="Specializzazione...">
                </div>
            </div>

            <div class="form-group">

                <input name="email" type="email" class="form-control" id="email" placeholder="es. prova@example.com"
                    required>
            </div>
            <div class="form-group">

                <input name="password" type="password" class="form-control" id="password" placeholder="Password..."
                    required>
            </div>
            <div class="form-group">

                <input name="confirm-password" type="password" class="form-control" id="confirm-password"
                    placeholder="Conferma password..." required>
            </div>
            <button type="submit" class="btn btn-register btn-block">Registrati</button>
            <br>
            <a href="/Dolce_Abruzzo/utente/login" class="linkpass">Hai già un account? Accedi</a>
        </form>
    </div>
    <script>
    document.querySelectorAll('input[name="userType"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
      var chefFields = document.querySelector('.chef-fields');
      if (event.target.value === 'chef') {
        chefFields.style.display = 'block';
      } else {
        chefFields.style.display = 'none';
      }
    });
  });
    </script>
    <script src="/Dolce_Abruzzo/skin/cake-main/js/scripts-for-template.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>