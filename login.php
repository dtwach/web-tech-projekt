<!doctype html>
<html lang="de">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logregdivs.css">
</head>

<body>
    <div class="center borderpadding">
        <h2>Anmeldung</h2>
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="name" placeholder="Benutzername"><br>
            <input type="password" name="password" placeholder="Passwort"> <br>
            <button type="submit" name="login_submit">Best&aumltigen</button> <br>
        </form>
        <a href="register.php">Registrieren</a>
    </div>
</body>

</html>