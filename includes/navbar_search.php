<?php
include 'login_session.php';
include 'logo.php';
?>

<!doctype html>
<html lang="de">

<head>
    <link rel="stylesheet" href="css/navbar.css">
    <script src="js/search.js"></script>
</head>

<body>
    <div class="nav_container">
        <div class="training_item nav_item">
            <a>Training</a>
            <div class="training_dropdown">
                <a class="nav_item" href="training.php">Übersicht</a>
                <a class="nav_item" href="training_overview.php">Alle Trainings</a>
                <a class="nav_item" href="training_create.php">Training erstellen</a>
            </div>
        </div>
        <div class="uebung_item nav_item">
            <a>&Uumlbungen</a>
            <div class="uebung_dropdown">
                <a class="nav_item" href="exercise.php">Übersicht</a>
                <a class="nav_item" href="exercise_create.php">Übung erstellen</a>
            </div>
        </div>
        <?php echo '<a class="nav_item" style="width:30%;text-align:start;"> Eingeloggt als: ' . $_SESSION['user'] . '</a>'; ?>
        <input id="search" size="9" onkeyup="search()" type="text" name="search" style="border:1px;border-radius:5px;margin-left:auto;
        margin-top:5px;margin-bottom:5px;text-align: center;" placeholder="Suche">
        <a class="nav_item" href="profil.php">Profil</a>
        <a class="nav_item last_item" href="includes/logout.inc.php">Ausloggen</a>
    </div>
</body>

</html>