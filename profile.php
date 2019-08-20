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
    <div class="profile_info">
      <form method="POST" action="php/imageUpload.php" enctype="multipart/form-data">
        <input type="file" class="profile-image-input" name="image" onchange="this.form.submit()">
        <? echo '<img src="data:image/jpeg;base64,'.base64_encode( $dataUser['user_profileimage'] ).'" class="profile-image">'; ?>
      </form>
      <p class="profile-name"> <? echo $dataUser['user_firstname']." ".$dataUser['user_lastname']; ?> </p>
      <p class="profile-birthday"> <? echo $dataUser['user_birthday']. ", ".DB::query("SELECT TIMESTAMPDIFF(YEAR, user_birthday, CURDATE()) AS age FROM users WHERE id_user = $idUser")['age']. " лет"; ?> </p>
      <p class="profile-location"> <? echo $dataUser['user_country'].", ".$dataUser['user_city']; ?> </p>
    </div>
  </div>
</body>
</html>