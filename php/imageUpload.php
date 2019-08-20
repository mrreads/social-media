<?php
require_once "DB.php";

session_start();
$idUser = (int)$_SESSION['id_user'];

if (count($_FILES) == 1 AND $_FILES['image']['type'] == 'image/jpeg')
{
    $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $query = DB::query("UPDATE users SET user_profileimage = '$imageData' WHERE id_user = $idUser");
}
header('Location: ./../profile.php');