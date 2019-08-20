<?php
require_once "DB.php";

session_start();
$idUser = (int)$_SESSION['id_user'];

$newNickName = htmlspecialchars($_POST['nickname']);
$newEmail = htmlspecialchars($_POST['email']);
$newFirstnName = htmlspecialchars($_POST['firstname']);
$newLastName = htmlspecialchars($_POST['lastname']);
$newCountry = htmlspecialchars($_POST['country']);
$newCity = htmlspecialchars($_POST['city']);
$newBirth = htmlspecialchars($_POST['birth']);
$newInfo = htmlspecialchars($_POST['info']);

$oldNickName = DB::query("SELECT user_nickname FROM users WHERE id_user = $idUser")['user_nickname'];
$oldEmail = DB::query("SELECT user_email FROM users WHERE id_user = $idUser")['user_email'];
$oldFirstName = DB::query("SELECT user_firstname FROM users WHERE id_user = $idUser")['user_firstname'];
$oldLastName = DB::query("SELECT user_lastname FROM users WHERE id_user = $idUser")['user_lastname'];
$oldCountry = DB::query("SELECT user_country FROM users WHERE id_user = $idUser")['user_country'];
$oldCity = DB::query("SELECT user_city FROM users WHERE id_user = $idUser")['user_city'];
$oldBirth = DB::query("SELECT user_birthday FROM users WHERE id_user = $idUser")['user_birthday'];
$oldInfo = DB::query("SELECT user_info FROM users WHERE id_user = $idUser")['user_info'];

if ($oldFirstName != $newFirstnName)
{
    $query = DB::query("UPDATE users SET user_firstname = '$newFirstnName' WHERE id_user = $idUser");
}
if ($oldLastName != $newLastName)
{
    $query = DB::query("UPDATE users SET user_lastname = '$newLastName' WHERE id_user = $idUser");
}
if ($oldNickName != $newNickName)
{
    $query = DB::query("UPDATE users SET user_nickname = '$newNickName' WHERE id_user = $idUser");
}
if ($oldEmail != $newEmail)
{
    $query = DB::query("UPDATE users SET user_email = '$newEmail' WHERE id_user = $idUser");
}
if ($oldCountry != $newCountry)
{
    $query = DB::query("UPDATE users SET user_country = '$newCountry' WHERE id_user = $idUser");
}
if ($oldCity != $newCity)
{
    $query = DB::query("UPDATE users SET user_email = '$newCity' WHERE id_user = $idUser");
}
if ($oldBirth != $newBirth)
{
    $query = DB::query("UPDATE users SET user_birthday = '$newBirth' WHERE id_user = $idUser");
}
if ($oldInfo != $newInfo)
{
    $query = DB::query("UPDATE users SET user_info = '$newInfo' WHERE id_user = $idUser");
}
header('Location: ../../../profile.php');