<?php

function check_file($file){
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.',$file['name']);
    $file_extension = end($strip);
    if($file['error'] !== 0){
        header('Location: /training_create.php?ms=error');
        exit();
    }    
    if($file['size'] > 3000000){
        header('Location: /training_create.php?ms=size');
        exit();
    }
    if(!in_array($file_extension, $filter_arr)){
        header('Location: /training_create.php?ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}

function compare_ex_name($name_ex, $id){
    require 'dbcon_f.php';
    $stmt = $con->prepare("SELECT * FROM training WHERE name=? AND fk_user=?;");
    if(!$stmt){
        header('Location: /training_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('si', $name_ex, $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if(is_null($result)){
        return;
    }
    $name_low = strtolower($name_ex);
    $result_low = strtolower($result['name']);
    if($name_low === $result_low){
        header('Location: /training_create.php?ms=taken');
        exit();
    }
}

if (isset($_POST['training_submit'])){
    require 'dbcon_f.php';
    require 'functions.php';
    session_start();
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $name_ex = $_POST['name_ex'];
    $description = $_POST['description'];
    if(!empty($_FILES['file'])){
        $file = $_FILES['file'];
    }
    
    if (empty($name_ex) || empty($description)){ 
        header('Location: /training_create.php?ms=empty');
        exit();        
    }    
    
    compare_ex_name($name_ex, $id);
    
    if(!empty($file['name'])){
        $blob = check_file($file);
    } else {
        $blob = file_get_contents('tmp/pic.png');
    }
    
    $stmt = $con->prepare("INSERT INTO training (name, description, fk_user, picture) VALUES (?, ?, ?, ?);");
    if(!$stmt){
        header('Location: /training_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('ssss', $name_ex, $description, $id, $blob);
    $stmt->execute();
    if(!$stmt) {
        header('Location: /training_create.php?ms=fail');
        exit();
    }  
    $stmt->close();
    
    $tid = get_single_training_id($name_ex);
    add_user_training($id, $tid);

    header('Location: /training_create.php?ms=success');
    $con->close();

}