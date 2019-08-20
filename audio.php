<?php
  session_start();
  if(empty($_SESSION['id_user']))
  {
    header('Location: login.php');
  }

  require_once(__DIR__ . '/php/DB.php');
  $idUser = (int)$_SESSION['id_user'];
  $dataUser = DB::query("SELECT * FROM users WHERE id_user = $idUser");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Аудио</title>
  <link rel="stylesheet" href="./css/base.css">
  <link rel="stylesheet" href="./css/audio.css">
  <script src="./js/playAudio.js" defer></script>
</head>
<body>
  <div class="content">
    <div class="nav-menu">
      <a href="./profile.php">Профиль</a>
      <hr>
      <a href="./audio.php" id="active">Аудио</a>
      <hr>
      <a href="./logout.php">Выйти</a>
    </div>

    <div class="audio-list">
      <h3> Все аудио</h3>
      <hr>
    <?
    foreach ($sql = DB::queryAll("SELECT * FROM `audio`") as $data)
    {
      ?>
      <div class="track">
        <div class="play"></div>
        <p> <? echo $data['audio_author']." - ".$data['audio_name']; ?></p>
        <audio autobuffer="autobuffer">
          <? echo '<source src="data:audio/mp3;base64,'.base64_encode( $data['audio_file'] ).'">'; ?>
        </audio>
        <form action="./php/add-removeTrack.php" method="GET"> <button class="add" value="<?echo $data['id_audio']?>" name='audioAdd'></button> </form>
      </div>
      <hr>
      <?
    }
    ?>
    </div>

    <div class="your-list">
      <h3> Ваши аудио</h3>
      <hr>
    <?
    foreach ($sql = DB::queryAll("SELECT `audio`.`audio_author`, `audio`.audio_name, `audio`.`audio_file`, `user-audio`.id_audio FROM `user-audio`, `audio` WHERE `user-audio`.id_user = $idUser AND `user-audio`.`id_audio` = `audio`.`id_audio`") as $data)
    {
      ?>
      <div class="track">
        <div class="play"></div>
        <p> <? echo $data['audio_author']." - ".$data['audio_name']; ?></p>
        <audio autobuffer="autobuffer">
          <? echo '<source src="data:audio/mp3;base64,'.base64_encode( $data['audio_file'] ).'">'; ?>
        </audio>
      </div>
      <hr>
      <?
    }
    ?>
    </div>

  </div>
</body>
</html>