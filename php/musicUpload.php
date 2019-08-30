<?php
require_once __DIR__ . '/DB.php';

session_start();
$idUser = (int)$_SESSION['id_user'];

if (count($_FILES) == 1 AND $_FILES['audio']['type'] == 'audio/mpeg')
{
    $audioAuthor = $_POST['author'];
    $audioName = $_POST['name'];
    $audioFile = addslashes(file_get_contents($_FILES['audio']['tmp_name']));
    $query = DB::query("INSERT INTO `audio` (`id_audio`, `audio_author`, `audio_name`, `audio_file`) VALUES (NULL, '$audioAuthor', '$audioName', '$audioFile')");
}
header('Location: ./../audio.php');