<?php
if (isset($_POST['id_training']) && isset($_POST['id_exercise'])) {
    include 'dbcon.inc.php';
    $id_training = $_POST['id_training'];
    $id_exercise = $_POST['id_exercise'];


    $stmt = $con->prepare("SELECT * FROM training_exercise WHERE fk_training=? AND fk_exercise=?;");
    $stmt->bind_param('ii', $id_training, $id_exercise);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows();
    $stmt->close();
    if ($result > 0) {
        exit();
    }

    $stmt = $con->prepare("INSERT INTO training_exercise (fk_exercise, fk_training) VALUES (?, ?);");
    if (!$stmt) {
        header('Location: ../register.php?ms=db&name=' . $name);
        exit();
    }
    $stmt->bind_param('ii', $id_exercise, $id_training);
    $stmt->execute();
    $stmt->close();
}
