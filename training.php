<?php
include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>Training Starten</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/alternate.css">
</head>

<body>
    <h2 style="margin-left:110px">Aktiviertes Training</h2>
    <div class="alt" style="float:left;margin-right:100%;">
        <?php
        $tid = isset($_GET['training']) ? $_GET['training'] : NULL;
        if (isset($_SESSION['tid']) || isset($tid)) {
            include 'includes/functions.php';
            $result = isset($tid) ? get_single_training_active($tid) : get_single_training_active($_SESSION['tid']);
            $row = $result->fetch_assoc();
            $tid = $row['fk_training'];
            echo '
                <h3><a href="training.php?training=' . $row['id'] . '">' . $row['name'] . '</a></h3>
                <p>' . $row['description'] . '</p> 
                <img style="width:400px; height:150px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> 
                <br>
                <form action="train.php">
                    <button type="submit">Starten</button> <br>
                </form>
                </div>';
            echo '<div style="margin-left:8px;margin-top:320px;">';
            echo '<p style="margin-bottom:5px;margin-top:10px">Vorheriges Training:</p>';

            $arr_big = sort_training_view_array($row['id']);
            if ($result->num_rows > 0) {

                $ctn = 0;
                //Ausgabe
                foreach ($arr_big as $key => $ar) {
                    if ($key == 1) {
                        echo '<p style="margin-bottom:5px;margin-top:2px">Alte Trainings:</p>';
                    }
                    $max_sets = $ar[0];
                    //Tabellenkopf. max_sets bestimmt die Sätze der Tabelle
                    echo '<table>          
                        <tr>
                        <th>Übung</th>';
                    for ($i = 0; $i < $max_sets; $i++) {
                        echo '<th colspan="4">Satz ' . ($i + 1) . '</th>';
                        if ($i == $max_sets) {
                            echo '</tr>';
                        }
                    }
                    //Tabellenreihen
                    foreach ($ar as $item) {
                        //max_sets ist kein Array. Deswegen wird es übersprungen.
                        if (is_array($item)) {
                            //Legt für jede Reihe die Einträge an
                            for ($i = 0; $i < $max_sets; $i++) {
                                if ($i == 0) {
                                    $c = 1;
                                    echo '<tr>';
                                    echo '<td>' . $item[0] . '</td>';
                                }
                                if (isset($item[$c])) {
                                    echo '
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>';
                                } else {
                                    echo '
                                <td> 0 </td>
                                <td> 0 </td>
                                <td> - </td>
                                <td> </td>';
                                }
                                if ($i == $max_sets) {
                                    echo '</tr>';
                                }
                            }
                        }
                    }
                    echo '</table> <br>';
                }
            } else {
                echo '<p>Führen Sie zunächst Ihr Training aus.</p>';
            }
        } else {
            echo '<p>Bitte setzten Sie zunächst Ihr aktives Training fest.
         Diese finden Sie unter Training => Alle <a href="training_overview.php">Trainings</a>.</p>';
        }
        echo '</div>';
        ?>

</body>

</html>