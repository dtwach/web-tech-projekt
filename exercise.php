<?php
    include 'includes/navbar.php';
?>

<!doctype html>
<html lang="de">
	<head>
		<title>PHP: Basics</title>
        <link rel="stylesheet" href="css/navbar.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="start.js"></script>
        <script>
            $( document ).ready(function() {
                console.log( "ready!" );
                $("#foo").click(function(){
                var val = $("form_ajax".serialize());

                    $.ajax({
                        type: "POST",
                        url: "start_f.php",
                        data: val,
                        success: function(data) {
                            alert(data);
                            $("p").text(data);
                        }
                    });                    
                });
                function training_add_submit(id){
                    alert(id);
                }
            });
        </script>
	</head>
	<body>
        <h2>Alle Übungen</h2>

        <?php
        
        include 'includes/functions.php';
        $result = get_exercises();
        $result_training = get_all_training_id_name();

        while($row = $result->fetch_assoc()){
        echo '
        <a href="exercise.php?name='.$row['name'].'"<h3>'.$row['name'].'</h3></a>
        <p style="width:30%;">'.$row['description'].'</p> 
        <img style="width:400px; height:150px;" src="data:image/jpeg;base64,'.base64_encode($row['picture']).'"/> <br>
        <form>        
        <select id="select_'.$row['id'].'" name="option_training">    
        <label for="training"></label>">';  
        foreach($result_training as $row_training){
            if($_SESSION['tid'] != $row_training['id']){
                echo '<option value="'.$row_training['id'].'">'.$row_training['name'].'</option>';
            } else {
                echo '<option selected="selected" value="'.$row_training['id'].'">'.$row_training['name'].'</option>';
            }
        }
        echo '        
        </select> <br>
        <input type="hidden" name="name_ex" value="'.$row['id'].'">
        <button  id="'.$row['id'].'" onClick="training_add_submit(this.id)" name="training_add" type="button">Hinzufügen</button>
        </form>';
        }
        ?>
        <script type="text/javascript">
            function training_add_submit(id_exercise)
            {
                var bind = 'select_'+ id_exercise;
                var temp = document.getElementById(bind);
                var id_training = temp.options[temp.selectedIndex].value;
                $.ajax({
                    type: "POST",
                    url: "includes/exercise_f.php",
                    data: {
                        id_exercise: id_exercise,
                        id_training: id_training,
                    },
                    // success: function(data) {
                    //     alert(data);
                    // }
                });                    
            }
        </script>
    </body>
</html>