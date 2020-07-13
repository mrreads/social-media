<?php
require_once "DB.php";

session_start();
$idUser = (int)$_SESSION['id_user'];

if (count($_FILES) == 1 AND $_FILES['image']['type'] == 'image/jpeg')
{
    $extension = end(explode('.', $_FILES['image']['name']));
    $pathToWrite = dirname(__DIR__).'/upload/image/';
    $fileName = md5(microtime() . rand(0, 1000)).'.'.$extension;
    $finalPath = $pathToWrite.$fileName;
    
    move_uploaded_file($_FILES["image"]["tmp_name"], $pathToWrite. $fileName);
    //$imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $query = DB::query("UPDATE users SET user_profileimage_path = '$fileName' WHERE id_user = $idUser");
}

header('Location: ./../profile.php');