<?php
    include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">
	<head>
		<title>PHP: Basics</title>
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/table.css">
	</head>
	<body>
        <h2>Alle Trainings</h2>
        <?php
        include 'includes/functions.php';
        $result_exercises = get_active_exercises();     
      //  $result_set = get_train_unit();
        while($row_ex = $result_exercises->fetch_assoc()){
            echo '
            <form id="train_table" method="POST" action="/includes/train.inc.php">
            <table> 
            <tr> 
            <th>'.$row_ex["name"].'</th>
            <th>Wiederholung</th>
            <th>Gewicht</th>
            <th>Art</th>
            <th>Kommentar</th>
            </tr>';
            $count = 0;
            for($i = 1; $i <= 3; $i++){
                    echo '
                    <input type="hidden" name="'.$row_ex["id"].'_fkex_'.$i.'"/input>
                    <tr>
                    <td>Satz '.$i.'</td>
                    <td><input type="number" name="'.$row_ex["name"].'_rep_'.$i.'" value=""/input></td>
                    <td><input type="number" name="'.$row_ex["name"].'_weight_'.$i.'" step="0.001"/input></td>
                    <td><input type="text" name="'.$row_ex["name"].'_type_'.$i.'" value="Standard"/input></td>
                    <td><input type="text" name="'.$row_ex["name"].'_comment_'.$i.'"/input></td>
                    </tr>';
                }
                echo '</table> <br> <br>';
            }
            echo '
            <input type="hidden" name="a_tid_a" value="'.$_SESSION["tid"].'"/input>
            <input type="hidden" name="a_id_a" value="'.$_SESSION["id"].'"/input>
            <button type="submit" name="train_submit">Save</button>
            </from>';

        ?>
    </body>
</html>