<?php
include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>Alle Trainings</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/table.css">
</head>

<body>
    <h2>Alle Trainings</h2>

    <?php
    include 'includes/functions.php';
    $result = get_all_training();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
                <h3><a href="training.php?training=' . $row['id'] . '">' . $row['name'] . '</a></h3>
                <p style="width:30%;">' . $row['description'] . '</p> 
                <img style="width:400px; height:150px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> 
                <br>';
                if($_SESSION['tid'] != $row['id']){
                    echo '<form action="includes/training_overview.inc.php" method="post">
                    <input type="hidden" name="training_id" value="' . $row['id'] . '" > <br>
                    <button type="submit" name="training_overview_submit">Aktivieren</button> <br>
                    </form>
                    ';
                }
        }
    } else {
        echo '<p>Bitte legen Sie zunächst ein Training an.
        Dies finden Sie unter Training => Training erstellen.</p>';
    }
    ?>
</body>

</html>