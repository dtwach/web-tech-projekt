<?php
include 'login_session.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>Navbar</title>
    <link rel="stylesheet" href="css/navbar.css">
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
        <?php echo '<a class="nav_item" style="width:400px"> Logged in as: ' . $_SESSION['user'] . '</a>'; ?>
        <a class="nav_item right" href="profil.php">Profil</a>
        <a class="nav_item last_item" href="includes/logout_f.php">Logout</a>
    </div>
</body>

</html>