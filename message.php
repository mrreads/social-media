<?php
  session_start();
  if(empty($_SESSION['id_user']))
  {
    header('Location: login.php');
  }

  require_once(__DIR__ . '/php/DB.php');
  $idUser = (int)$_SESSION['id_user'];

  $idTo = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Аудио</title>
  <link rel="stylesheet" href="./css/base.css">
  <link rel="stylesheet" href="./css/messages.css">
</head>

<body>
  <div class="content">
    <div class="nav-menu">
      <? echo '<a href="./profile.php?id='.$idUser.'">Профиль</a>';?>
      <hr>
      <a href="./users.php">Пользователи</a>
      <hr>
      <a href="./audio.php" id="active">Аудио</a>
      <hr>
      <a href="./logout.php">Выйти</a>
    </div>

    <div class="message-box">
      <h3> Общение </h3>
      <hr>
    <?
    foreach ($sql = DB::queryAll("SELECT * FROM `message`, `users` WHERE `users`.id_user = `message`.message_from AND ((`message_from` = $idUser AND `message_to` = $idTo) OR (`message_from` = $idTo AND `message_to` = $idUser)) ORDER BY message_date") as $data)
    {
      ?>
        <div class="message">
          <? echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['user_profileimage'] ).'" class="avatar">'; ?>
          <p class="name"> <? echo $data['user_firstname']; ?> <span class="date"> <? echo $data['message_date']; ?> </span></p>
          <p class="text"> <? echo $data['message_text']; ?></p>
        </div>
      <?
    }
    ?>
      <hr>
      <form action="./php/messageSend.php" method="post">
        <textarea></textarea>
        <button> Отправить</button>
      </form>
    </div>

  </div>
</body>
</html>