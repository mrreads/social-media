<?php
require_once __DIR__ . '/DB.php';

session_start();
$idUser = (int)$_SESSION['id_user'];

if (count($_FILES) == 1 AND $_FILES['audio']['type'] == 'audio/mpeg')
{
    $audioAuthor = $_POST['author'];
    $audioName = $_POST['name'];
    
    $extension = end(explode('.', $_FILES['audio']['name']));
    $pathToWrite = dirname(__DIR__).'/upload/audio/';
    $fileName = md5(microtime() . rand(0, 1000)).'.'.$extension;
    $finalPath = $pathToWrite.$fileName;
    
    move_uploaded_file($_FILES["audio"]["tmp_name"], $pathToWrite. $fileName);

    $query = DB::query("UPDATE users SET user_profileimage_path = '$fileName' WHERE id_user = $idUser");

    $query = DB::query("INSERT INTO `audio` (`id_audio`, `audio_author`, `audio_name`, `audio_path`) VALUES (NULL, '$audioAuthor', '$audioName', '$fileName')");
}
header('Location: ./../audio.php');