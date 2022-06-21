<?php
if (isset($_POST['register_submit'])) {
    require 'dbcon_f.php';
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_again = $_POST['password_again'];
    if (empty($name) || empty($password) || empty($password_again)) {
        if (empty($name)) {
            header('Location: /register.php?ms=empty');
            exit();
        }
        header('Location: /register.php?ms=empty&name=' . $name);
        exit();
    } else if ($password !== $password_again) {
        header('Location: /register.php?ms=even&name=' . $name);
        exit();
    } else {
        $stmt = $con->prepare("SELECT * FROM user WHERE name=?;");
        if (!$stmt) {
            header('Location: /register.php?ms=db&name=' . $name);
            exit();
        }
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        if ($result > 0) {
            header('Location: /register.php?ms=taken&name=' . $name);
            exit();
        } else {
            $stmt->close();
            $stmt = $con->prepare("INSERT INTO user (name, passwordhash, time) VALUES (?, ?, ?);");
            if (!$stmt) {
                header('Location: /register.php?ms=db&name=' . $name);
                exit();
            }
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $timestamp = date('Y-m-d H:i:s');
            $stmt->bind_param('sss', $name, $passwordhash, $timestamp);
            $stmt->execute();
            if (!$stmt) {
                header('Location: /register.php?ms=fail&name=' . $name);
            }
            session_start();
            $_SESSION['user'] = $name;
            $_SESSION['id'] = $row['id'];
            header('Location: /start.php');
        }
    }
    $stmt->close();
    $con->close();
}
