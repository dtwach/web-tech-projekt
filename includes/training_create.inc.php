<?php

function check.incile($file)
{
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../training_create.php?ms=error');
        exit();
    }
    if ($file['size'] > 3000000) {
        header('Location: ../training_create.php?ms=size');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../training_create.php?ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}

function compare_ex_name($name_ex, $id)
{
    require 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE training.name=? AND user_training.fk_user=?;");
    if (!$stmt) {
        header('Location: ../training_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('si', $name_ex, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (is_null($result)) {
        return;
    }
    $name_low = strtolower($name_ex);
    $result_low = strtolower($result['name']);
    if ($name_low === $result_low) {
        header('Location: ../training_create.php?ms=taken');
        exit();
    }
}

if (isset($_POST['training_submit'])) {
    require 'dbcon.inc.php';
    require 'functions.php';
    session_start();
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $name_ex = htmlspecialchars($_POST['name_ex']);
    $description = htmlspecialchars($_POST['description']);
    if (!empty($.incILES['file'])) {
        $file = $.incILES['file'];
    }

    if (empty($name_ex) || empty($description)) {
        header('Location: ../training_create.php?ms=empty');
        exit();
    }

    compare_ex_name($name_ex, $id);

    if (!empty($file['name'])) {
        $blob = check.incile($file);
    } else {
        $blob = file_get_contents('tmp/pic.png');
    }

    $stmt = $con->prepare("INSERT INTO training (name, description, picture) VALUES (?, ?, ?);");
    if (!$stmt) {
        header('Location: ../training_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('sss', $name_ex, $description, $blob);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../training_create.php?ms=fail');
        exit();
    }
    $stmt->close();

    $tid = get_single_training_id($name_ex);
    var_dump($_SESSION['id']);
    add_user_training($_SESSION['id'], $tid);

    header('Location: ../training_create.php?ms=success');
    $con->close();
}
