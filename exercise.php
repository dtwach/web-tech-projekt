<?php
include 'includes/navbar_search.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>Übungen</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/alternate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/exercise.js"></script>
    <link rel="icon" type="image/x-icon" href="svg/favicon.ico">

</head>

<body>
    <h2 style="text-align: center;">Alle Übungen</h2>
    <div class="main">
        <?php

        include 'includes/functions.php';
        $result = get_exercises();
        if ($result->num_rows > 0) {
            $result_training = get_all_training_id_name();

            while ($row = $result->fetch_assoc()) {
                echo '<div class="alt">
            <div class="searchable"><h3><a href="exercise.php?name=' . $row['name'] . '">' . $row['name'] . '</a></h3>
            <p>' . $row['description'] . '</p> </div>
            <img style="width:400px; height:150px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> <br>
            <form>        
            <select id="select_' . $row['id'] . '" name="option_training">    
            <label for="training"></label>">';
                foreach ($result_training as $row_training) {
                    if ($_SESSION['tid'] != $row_training['id']) {
                        echo '<option value="' . $row_training['id'] . '">' . $row_training['name'] . ' autofocus </option>';
                    } else {
                        echo '<option selected="selected" value="' . $row_training['id'] . '">' . $row_training['name'] . ' autofocus </option>';
                    }
                }
                echo '        
            </select> <br>
            <input type="hidden" name="name_ex" value="' . $row['id'] . '">
            <button  id="' . $row['id'] . '" onClick="training_add_submit(this.id)" name="training_add" type="button">Hinzufügen</button>
            </form></div>';
            }
        } else {
            echo '<p>Bitte legen Sie zunächst eine Übung an.
        Diese finden Sie unter Übungen => <a href="exercise_create.php">Übung</a> erstellen.</p>';
        }
        ?>
    </div>
</body>

</html>