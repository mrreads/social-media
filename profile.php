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
  <title>Профиль</title>
  <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
  <div class="content">
    <div class="nav-menu">
      <a href="./profile.php">Профиль</a>
      <hr>
      <a href="./logout.php">Выйти</a>
    </div>

    <div class="profile_info">
      <form method="POST" action="php/imageUpload.php" enctype="multipart/form-data" class="profile-image-form">
        <input type="file" class="profile-image-input" name="image" onchange="this.form.submit()">
        <? echo '<img src="data:image/jpeg;base64,'.base64_encode( $dataUser['user_profileimage'] ).'" class="profile-image">'; ?>
      </form>
      <p class="profile-name"> <? echo $dataUser['user_firstname']." ".$dataUser['user_lastname']; ?> </p>
      <p class="profile-birthday"> <? echo $dataUser['user_birthday']. ", ".DB::query("SELECT TIMESTAMPDIFF(YEAR, user_birthday, CURDATE()) AS age FROM users WHERE id_user = $idUser")['age']. " лет"; ?> </p>
      <p class="profile-location"> <? echo $dataUser['user_country'].", ".$dataUser['user_city']; ?> </p>
      <hr>
      <p class="profile-info"> <? echo $dataUser['user_country'].", ".$dataUser['user_info']; ?> </p>
    </div>

    <form method="POST" action="./php/changeData.php" class="profile-setting">
      <label for="input-username">Никнейм</label>
      <input type="text" id="input-username" placeholder="Никнейм" value="<? echo $dataUser['user_nickname'];?>" name="nickname">
      
      <label for="input-email">Почта</label>
      <input type="email" id="input-email" placeholder="Почта" value="<? echo $dataUser['user_email'];?>" name="email">
      
      <label for="input-first-name">Имя</label>
      <input type="text" id="input-first-name" placeholder="Имя" value="<? echo $dataUser['user_firstname'];?>" name="firstname">
      
      <label for="input-last-name">Фамилия</label>
      <input type="text" id="input-last-name" placeholder="Фамилия" value="<? echo $dataUser['user_lastname'];?>" name="lastname">
      
      <label for="input-country">Страна</label>
      <input type="text" id="input-username" placeholder="Страна" value="<? echo $dataUser['user_country'];?>" name="country">
      
      <label for="input-city">Город</label>
      <input type="text" id="input-city" placeholder="Город" value="<? echo $dataUser['user_city'];?>" name="city">
      
      <label for="birth">Дата рождения</label>
      <input type="date" id="input-birth" placeholder="Дата рождения" value="<? echo DB::query("SELECT user_birthday FROM users WHERE id_user = $idUser")['user_birthday'];?>" name="birth">
      
      <label for="info">Информация обо мне</label>
      <textarea placeholder="Пару слов о вас..." name="info"><? echo $dataUser['user_info'];?></textarea>

      <button>Сохранить информацию</button>
    </form>
  </div>
</body>
</html>