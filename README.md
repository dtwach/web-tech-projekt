Fitness-Tracker!
von Kai und Dennis!
UNIQUE Key bei user->name einfügen in DB.
Tabelle exercise beschreibung->description.

    $file_name = $_FILES['file']['name'];
    $tmp_name  = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_blob = file_get_contents($tmp_name);
    var_dump($file_name);
    var_dump($tmp_name);
    var_dump($file_size);
    var_dump($file_type);
    var_dump($file_blob);



    //Prüfen, wechle Dateiformate php erlaubt.

function check_file($file){
    $filter_arr = array('png', 'jpg', 'pdf', 'jpeg');
    $strip = explode('.',$file['name']);
$file_extension = end($strip);
print_r($file);
    if($file['error'] !== 0){
header('Location: ../exercise_create.php?ms=error');
exit();
}  
 if($file['size'] > 200000){
        header('Location: ../exercise_create.php?ms=size');
        exit();
    }
    if(!in_array($file_extension, $filter_arr)){
        header('Location: ../exercise_create.php?ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}

Wir müssen nochmal über die größe der bilder sprechen
https://stackoverflow.com/questions/93128/mysql-error-1153-got-a-packet-bigger-than-max-allowed-packet-bytes
