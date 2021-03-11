<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Immobilien Von Rehetobel AG">

    <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="../lib/img/logo/logo-ivr-dark.svg" sizes="any">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.main.css">

    <!-- Custom -->
    <link rel="stylesheet" href="./style.css">

    <title>login &bull; admin.wohnung28</title>
</head>
<body class="text-center">
    <form id="login-form" class="form-signin">
        <a href="#"><h1 class="h3 mb-5 font-weight-normal"><img src="../lib/img/brand/brand-ivr-dark.svg" alt="28" width="100%"></h1></a>
        <label for="username-input" class="sr-only">Benutzername</label>
        <input type="text" id="username-input" class="form-control" placeholder="Benutzername" required autofocus>
        <label for="password-input" class="sr-only">Passwort</label>
        <input type="password" id="password-input" class="form-control" placeholder="Passwort" required autocomplete="off">

        <div id="invalid-message" class="invalid-feedback"></div>

        <div class="mt-4">
            <button id="main-submit-btn" class="btn btn-lg btn-primary btn-block" type="submit">Anmelden</button>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; Immobilien Von Rehetobel AG</p>
    </form>

    <!-- xhr -->
    <script type="text/javascript" src="../assets/js/xhr/xhr.min.js"></script>

    <!-- main -->
    <script type="text/javascript" src="./main.js"></script>
</body>
</html>