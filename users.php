<?php
  session_start();
  if(empty($_SESSION['id_user']))
  {
    header('Location: login.php');
  }

  require_once(__DIR__ . '/php/DB.php');
  $idUser = (int)$_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Пользователи</title>
  <link rel="stylesheet" href="./css/base.css">
  <link rel="stylesheet" href="./css/users.css">
  <script src="./js/users.js" defer></script>
</head>

<body>
  <div class="content">
    <div class="nav-menu">
      <? echo '<a href="./profile.php?id='.$idUser.'">Профиль</a>';?>
      <hr>
      <a href="./users.php" id="active">Пользователи</a>
      <hr>
      <a href="./audio.php">Аудио</a>
      <hr>
      <a href="./logout.php">Выйти</a>
    </div>

    <div class="user-list">
      <h3>Все пользователи</h3>
      <hr>
      <?
      foreach ($sql = DB::queryAll("SELECT * FROM `users`") as $data)
      {
      ?>
      <a class="user" href="./profile.php?id=<? echo $data['id_user'];?>">
        <? echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['user_profileimage'] ).'">'; ?>
        <p> <? echo $data['user_firstname']." ".$data['user_lastname'] ?> </p>
      </a>
      <hr>
      <?
    }
    ?>
    </div>

  </div>
</body>

</html>