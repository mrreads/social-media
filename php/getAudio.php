<?php

require_once "DB.php";

$idAudio = $_GET['id'];

$audioData = DB::query("SELECT audio_file FROM audio WHERE id_audio = '$idAudio'")['audio_file'];
$binaryData = base64_encode($audioData);
echo json_encode($binaryData);