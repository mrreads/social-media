<?php
session_start();
if (isset($_SESSION['id_user']))
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
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <form action="php/auth.php" method="POST" class="authForm">
        <h2>Авторизация</h2>
        <input type="email" placeholder="Почта" name="loginEmail" class="authInput authText" required>
        <input type="password" placeholder="Пароль" name="loginPassword" class="authInput authText" required>
        <?php if (isset($_COOKIE["message"]))
        {
            echo '<h3>' . $_COOKIE["message"] . '</h3>';
        } ?>
        <button type="submit" name="loginButton" class="authInput authButton">ВОЙТИ</button>
        <a href="register.php">Зарегистрироваться</a>
        <p>Александр Попов</p>
    </form>
</body>
</html>