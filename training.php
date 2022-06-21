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
        $result = get_single_training_active();
       $row = $result->fetch_assoc();
            echo '
            <a href="training.php?name='.$row['name'].'"<h3>'.$row['name'].'</h3></a>
            <p style="width:30%;">'.$row['description'].'</p> 
            <img style="width:400px; height:150px;" src="data:image/jpeg;base64,'.base64_encode($row['picture']).'"/> 
            <br>
            <form action="train.php">
                <button type="submit">Starten</button> <br>
            </form>
            ';
    

        $result = get_training_all_sets($row['id']);
        $data =$result->fetch_all();
        $arr = array();
        $arr_tmp = array();
        $tmp = '';
        $i = 0;
        $max_sets = 0;
        $data_count_max = count($data);
        $data_count = 0;
        foreach($data as $item){
            if($tmp != $item[0] | ($data_count + 1) == $data_count_max){
                if(count($arr_tmp) > 0){
                    array_push($arr, $arr_tmp);
                    $arr_tmp = array();
                    $i = 0;
                }
                $arr_tmp[$i++] = $item[0];
                $tmp = $item[0];
            } 
            $arr_tmp[$i++]=$item[2];
            $arr_tmp[$i++]=$item[3];
            $data_count++;
            $max_sets = ($max_sets < $item[4]) ? $item[4] : $max_sets;
        }

        echo '<table>          
        <tr>
        <th>Übung</th>';
        for($i = 0; $i<$max_sets; $i++){
            echo '<th colspan="2">Satz '.($i+1).'</th>';
            if($i == $max_sets){
                echo '</tr>';
            }
        }

        foreach($arr as $item){
   
            for($i = 0; $i<$max_sets; $i++){                
                if($i == 0){
                    echo '<tr>';
                    echo '<td>'.$item[0].'</td>';
                }
                echo '
                <td>'.$item[1].'</td>
                <td>'.$item[2].'</td>';
                if($i == $max_sets){
                    echo '</tr>';
                }
            }
            }     
                  echo '</table> <br> <br>';

              
        

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