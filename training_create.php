<?php
include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>PHP: Basics</title>
    <link rel="stylesheet" href="css/navbar.css">
</head>

<body>
    <h2>Training erstellen</h2>
    <form enctype="multipart/form-data" action="includes/training_create.inc.php" method="post">
        <input type="text" name="name_ex" placeholder="Name"><br>
        <input type="text" name="description" placeholder="Beschreibung"> <br>
        <input name="file" type="file" accept=".jpg, .jpeg, .png" /> <br>
        <button type="submit" name="training_submit">Erstellen</button> <br>
    </form>
    <?php
    isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
    if ($message !== '') {
        switch ($message) {
            case 'success';
                echo '<p>Training erfolgreich erstellt</p>';
                break;
            case 'empty':
                echo '<p>Eingabefelder sind unvollständig</p>';
                break;
            case 'error':
                echo '<p>Fehler bei dem Hochladen der Datei</p>';
                break;
            case 'size':
                echo '<p>Die Datei ist zu groß</p>';
                break;
            case 'format':
                echo '<p>Die Datei hat ein Falsches Format</p>';
                break;
            case 'db';
                echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                break;
            case 'taken';
                echo '<p>Der Name ist schon vergeben </p>';
                break;
            case 'fail';
                echo '<p>Bitte versuchen Sie es später erneut</p>';
                break;
        }
    }
    ?>
</body>

</html>