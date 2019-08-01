<?php
  session_start();
  if(isset($_SESSION['id_user']))
  {
    header('Location: profile.php');
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <form action="php/auth.php" method="POST" class="authForm">
    <? if ($_COOKIE['check'] != true) { echo '<h2>Регистрация</h2>'; } ?>
    <? if ($_COOKIE['check'] == true) { echo '<h2>Продолжение регистрации</h2>'; } ?>

<? if ($_COOKIE['check'] != true)
{
  echo '
        <input type="email" placeholder="Почта" name="registerEmail" class="authInput authText" require>
        <input type="password" placeholder="Пароль" name="registerPassword" class="authInput authText" require>
        <button name="registerNext" class="authInput authButton">ДАЛЕЕ</button>
        <h3>'. $_COOKIE["message"] .'</h3>
      ';
      }
?>

<? if ($_COOKIE['check'] == true)
{
  echo '
        <input type="hidden" name="registerEmail" value="'.$_COOKIE['email'].'">
        <input type="hidden" name="registerPassword" value="'.$_COOKIE['password'].'">

        <input type="text" placeholder="Имя" name="registerFirstName" class="authInput authText" require>
        <input type="text" placeholder="Фамилия" name="registerLastName" class="authInput authText" require>
        <input type="text" placeholder="Дата рождения" name="registerDate" class="authInput authText" require>
        <input type="text" placeholder="Страна" name="registerCountry" class="authInput authText"require>
        <input type="date" placeholder="Город" name="registerCity" class="authInput authText" style="width: unset" require>
        <textarea placeholder="Пару слов о себе" name="registerInfo" class="authInput authText authTextArea"> </textarea>
        <button name="registerButton" class="authInput authButton">ЗАРЕГИСТРИРОВАТЬСЯ</button>
        ';
      }
?>
        <p>Александр Попов</p>
    </form>
</body>
</html>