<?php
include 'includes/navbar.php';
?>
<!doctype html>
<html lang="de">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="start.js"></script>
    <title>PHP: Basics</title>
    <link rel="stylesheet" href="css/navbar.css">

</head>

<body>
    <button id="dasd" onclick="casd(this.id)" value="NIIII" type="button">Click Me</button>
    <p id="test"></p>
    <button id="3" onClick="reply_click(this.id)">B3</button>
    <script type="text/javascript">
        function reply_click(clicked_id) {
            alert(clicked_id);
        }
    </script>
</body>

</html>

<?php
$con = mysqli_connect('localhost', 'root', '', 'fitnesstracker');
$stmt = $con->prepare("SELECT * FROM training_exercise WHERE fk_training=? AND fk_exercise=?;");
$id_training = 3;
$id_exercise = 16;
$stmt->bind_param('ii', $id_training, $id_exercise);
$stmt->execute();

$result = $stmt->get_result();


$row = $result->fetch_assoc();
var_dump($row);

if ($row['fk_exercise'] == $id_exercise) {
    echo 'KEK';
}
