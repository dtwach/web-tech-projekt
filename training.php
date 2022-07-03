<?php
include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">

<head>
    <title>Training Starten</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/table.css">
</head>

<body>
    <h2>Aktiviertes Training</h2>
    <?php
    $tid = isset($_GET['training']) ? $_GET['training'] : NULL;
    if (isset($_SESSION['tid']) || isset($tid)) {
        include 'includes/functions.php';
        $result = isset($tid) ? get_single_training_active($tid) : get_single_training_active($_SESSION['tid']);
        $row = $result->fetch_assoc();
        echo '
                <a href="training.php?training=' . $row['id'] . '"<h3>' . $row['name'] . '</h3></a>
                <p style="width:30%;">' . $row['description'] . '</p> 
                <img style="width:400px; height:150px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> 
                <br>
                <form action="train.php">
                    <button type="submit">Starten</button> <br>
                </form>
                ';

        //Hier werden die Spalten in Zeilen Transformiert
        //Alle Sätze werden in die einzelnen Traingingseinheiten aufgeteilt
        //Dann werden die einzelnen Trainingseinheiten arr_big zugeweiesen. Dieses Stellt immer eine Tabelle dar.
        $res = get_training_count_names($row['id']); // Gibt Anzahl er Übungen pro Training zurück
        $result = get_training_all_all_sets($row['id']); //Alle Sets für ein Training
        if ($result->num_rows > 0) {
            $data = $result->fetch_all();
            $arr_tmp = array(); //Kleines Array für jeden einzelnen Satz
            $arr = array(); //arr_tmp wird in dieses Array eingesetzt, wenn voll
            $arr_big = array(); //arr wird in dieses Array eingesetzt(dient als logische Tabelle für die Ausgabe)
            $tmp = ''; //vergleicht ob sich trainings_id geändert hat
            $i = 0; //Counter für 
            $ctn = 0; //Counter für Anzahl der Übungen pro Training
            $max_sets = 0; //Bestimmt die Maximalen Sets             
            $data_count_max = count($data); //Maximale länge des Arrays
            $data_count = 0; //Für die Bestimmung, dann die Maximale Array länge gefunden ist
            foreach ($data as $item) {
                //Sobald eine tmp einen anderen Namen bekommt 
                //oder die maximale Satzanzahl erreicht ist, wird geprüft,
                //ob es sich um ein Initialwert handelt.
                if ($tmp != $item[0] || ($data_count + 1) == $data_count_max) {
                    //Ist es kein Initalwert wird das Array in das Ausgabearray gespeichert                    
                    if (count($arr_tmp) > 0) {
                        //Für den letzen Satz pro Training
                        if(($data_count + 1) == $data_count_max){  
                            $arr_tmp[$i++] = $item[2];
                            $arr_tmp[$i++] = $item[3];
                            $arr_tmp[$i++] = $item[6];
                            $arr_tmp[$i++] = $item[7];
                        }
                        //Satz 1-n wird dem Array für das einzelne Training zugewiesen
                        array_push($arr, $arr_tmp);
                        $arr_tmp = array();
                        $i = 0;
                        //Wenn die Satzanzahl erreicht ist, wird der maximale Satz für die jeweilige Tabelle bestimmt.
                        //Dies wird für die Ausgabe benötigt. Danach wird eine Trainingseinheit das arr_big gepusht. 
                        $ctn++;
                        if($ctn == $res){
                            $arr_max_sets = array($max_sets);
                            array_unshift($arr, $max_sets);
                            array_push($arr_big, $arr);
                            $max_set = 0;
                            $ctn = 0;
                            $arr = array();
                        }
                    }
                    $arr_tmp[$i++] = $item[0];
                    $tmp = $item[0];
                }
                //Daten werden für die Sätze pro Übung in einem Training gesammelt und gebündelt
                $arr_tmp[$i++] = $item[2];
                $arr_tmp[$i++] = $item[3];
                $arr_tmp[$i++] = $item[6];
                $arr_tmp[$i++] = $item[7];
                
                $data_count++;
                //Bestimmt den Maximalen Satz
                $max_sets = ($max_sets < $item[4]) ? $item[4] : $max_sets;
            }
            $ctn = 0;
            //Ausgabe
            foreach($arr_big as $ar){
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
                    if(is_array($item)){
                        //Legt für jede Reihe die Einträge an
                        for ($i = 0; $i < $max_sets; $i++) {
                            if ($i == 0) {
                                $c = 1;
                                echo '<tr>';
                                echo '<td>' . $item[0] . '</td>';
                            }
                            if (isset($item[$c])){
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
                echo '</table> <br> <br>';
            }
        } else {
            echo '<p>Führen Sie zunächst Ihr Training aus.</p>';
        }
    } else {
        echo '<p>Bitte setzten Sie zunächst Ihr aktives Training fest.
         Diese finden Sie unter Training => Alle Trainings.</p>';
    }
    ?>
</body>

</html>