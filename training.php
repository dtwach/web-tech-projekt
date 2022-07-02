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
    <h2>Alle Trainings</h2>
    <?php
    $tid = isset($_GET['training'])? $_GET['training'] : NULL;
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


        $result = get_training_all_sets($row['id']);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all();
            $arr = array();
            $arr_tmp = array();
            $tmp = '';
            $i = 0;
            $max_sets = 0; //Bestimmt die Maximalen Sets             
            $data_count_max = count($data); //Maximale länge des Arrays
            $data_count = 0; //Für die Bestimmung, dann die Maximale Array länge gefunden ist
            //Holt jeden Satz der Reihe nach ab. Sortiert nach
            //den Namen. Gibt diesen als Array aus.
            foreach ($data as $item) {
                //Sobald eine tmp einen anderen Namen bekommt 
                //oder die maximale Satzanzahl erreicht ist, wird geprüft,
                //ob es sich um ein Initialwert handelt.
                if ($tmp != $item[0] || ($data_count + 1) == $data_count_max) {
                    //Ist es kein Initalwert wird das Array in das Ausgabearray gespeichert                    
                    if (count($arr_tmp) > 0) {
                        if(($data_count + 1) == $data_count_max){  
                            $arr_tmp[$i++] = $item[2];
                            $arr_tmp[$i++] = $item[3];
                            $arr_tmp[$i++] = $item[6];
                            $arr_tmp[$i++] = $item[7];
                        }
                        array_push($arr, $arr_tmp);
                        $arr_tmp = array();
                        $i = 0;
                    }
                    $arr_tmp[$i++] = $item[0];
                    $tmp = $item[0];
                }
                $arr_tmp[$i++] = $item[2];
                $arr_tmp[$i++] = $item[3];
                $arr_tmp[$i++] = $item[6];
                $arr_tmp[$i++] = $item[7];
                
                $data_count++;
                //Bestimmt den Maximalen Satz
                $max_sets = ($max_sets < $item[4]) ? $item[4] : $max_sets;
            }

            echo '<table>          
                <tr>
                <th>Übung</th>';
            for ($i = 0; $i < $max_sets; $i++) {
                echo '<th colspan="4">Satz ' . ($i + 1) . '</th>';
                if ($i == $max_sets) {
                    echo '</tr>';
                }
            }

            foreach ($arr as $item) {
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
            echo '</table> <br> <br>';
        } else {
            echo '<p>Führen Sie zunächst Ihr Training aus.</p>';
        }
    } else {
        echo '<p>Bitte setzten Sie zunächst Ihr aktives Training fest.
         Diese finden Sie unter Training => Alle Trainings.</p>';
    }




    // while($row_ex = $result_exercises->fetch_assoc()){
    //     echo '<table> 
    //     <tr> 
    //     <th>'.$row_ex["name"].'</th>
    //     <th>Wiederholung</th>
    //     <th>Gewicht</th>
    //     <th>Art</th>
    //     <th>Kommentar</th>
    //     </tr>';
    //     $count = 0;
    //     foreach($result_set as $row_set){
    //         if(($row_ex['id'] == $row_set['fk_exercise'] & $count < 3) |$count < 3){
    //             $count = $count + 1;
    //             echo '
    //             <tr>
    //             <td>Satz '.$count.'</td>
    //             <td>'.$row_set["rep"].'</td>
    //             <td>'.$row_set["weight"].'</td>
    //             <td>'.$row_set["type"].'</td>
    //             <td>'.$row_set["comment"].'</td>
    //             </tr>';
    //         }
    //     }
    //     echo '</table> <br> <br>';
    // }
    ?>
</body>

</html>