<?php
session_start();
if (empty($_SESSION['id_user'])) 
{
    header('Location: login.php');
}

require_once __DIR__ . '/DB.php';
$idUser = $_SESSION['id_user'];

if (isset($_GET['audioAdd']))
{
    $idAudio = $_GET['audioAdd'];
    $sql = DB::query("INSERT INTO `user-audio` (`id_user`, `id_audio`) VALUES ($idUser, $idAudio);");
    header('Location: ./../audio.php');
}

if (isset($_GET['audioRemove']))
{
    $idAudio = $_GET['audioRemove'];
    $sql = DB::query("DELETE FROM `user-audio` WHERE id_user = $idUser AND id_audio = $idAudio LIMIT 1;");
    header('Location: ./../audio.php');
}

header('Location: ./../audio.php');