<?php

function get_exercises()
{
    include 'dbcon_f.php';
    if (isset($_GET['name'])) {
        $stmt = $con->prepare("SELECT * FROM exercise WHERE name=?;");
        $stmt->bind_param('s', $_GET['name']);
    } else {
        $stmt = $con->prepare("SELECT * FROM exercise;");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_all_training_id_name()
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_user=?;");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_all_training()
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name,
    training.description, training.picture
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_user=?;");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_single_training_active()
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name,
    training.description, training.picture
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_training=?;");
    $stmt->bind_param('i', $_SESSION['tid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_active_exercises()
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT exercise.name, exercise.id FROM exercise 
                        JOIN training_exercise on exercise.id = training_exercise.fk_exercise 
                        WHERE training_exercise.fk_training=?
                        GROUP BY exercise.name;");
    $stmt->bind_param('i', $_SESSION['tid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_train_unit()
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT exercise.id, exercise.name, eset.fk_exercise, eset.id, eset.rep, eset.weight, eset.type, eset.comment 
    FROM exercise 
    JOIN training_exercise on exercise.id = training_exercise.fk_exercise 
    JOIN eset on eset.fk_exercise = exercise.id
    WHERE training_exercise.fk_training=?;");
    $stmt->bind_param('i', $_SESSION['tid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_training_all_sets($tid)
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number, user_training.time
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
	where user_training.time = (SELECT max(user_training.time) FROM user_training WHERE user_training.fk_training =?)  
    ORDER BY eset.id;");
    $stmt->bind_param('i', $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}


function get_single_training_id($name)
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("SELECT training.id FROM training where name=?;");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['id'];
}

function add_user_training($id, $tid)
{
    include 'dbcon_f.php';
    $stmt = $con->prepare("INSERT INTO user_training (fk_user, fk_training) VALUES (?, ?);");
    $stmt->bind_param('ii', $id, $tid);
    $stmt->execute();
    $stmt->close();
}
// SELECT exercise.id, exercise.name, eset.id, eset.rep, eset.weight, eset.type, eset.comment FROM exercise 
// JOIN training_exercise on exercise.id = training_exercise.fk_exercise 
// RIGHT JOIN eset on eset.fk_exercise = exercise.id
// WHERE training_exercise.fk_training=3;
//SELECT * FROM exercise JOIN training_exercise on exercise.id = training_exercise.fk_exercise WHERE training_exercise.fk_training=3



// $stmt = $con->prepare("SELECT name FROM exercise");
// $stmt->execute();
// $result_exercises = $stmt->get_result();
// $stmt->close();

// SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number
//     FROM training 
//     JOIN eset on eset.fk_training = training.id
//     JOIN exercise on eset.fk_exercise = exercise.id
// 	JOIN user_training on user_training.fk_training = training.id
// 	where user_training.time = (SELECT max(user_training.time) WHERE user_training.fk_training = training.id) 
//     ORDER BY eset.id;