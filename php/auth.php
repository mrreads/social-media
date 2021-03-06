<?php
session_start();

require_once "DB.php";

$loginEmail = htmlspecialchars($_POST['loginEmail']);
$loginPassword = htmlspecialchars($_POST['loginPassword']);

if (isset($_POST['loginButton']))
{
    $userCheck = DB::query("SELECT user_password FROM users WHERE user_email = '$loginEmail';");
    if ($userCheck)
    {
        $passwordHash = $userCheck['user_password'];
        if (password_verify($loginPassword, $passwordHash)) 
        {
            $dataUser = DB::query("SELECT * FROM users WHERE user_email = '$loginEmail';");
            $_SESSION['id_user'] = $dataUser['id_user'];
            header('Location: ./../profile.php');
        }
        else 
        {
            setcookie("message", "Пароль неверный.", time() + 2, '/');
            header('Location: ./../login.php');
        }
    }
    else
    {
        setcookie("message", "Вы ввели неверные данные.", time() + 2, '/');
        header('Location: ./../login.php');
    }
}


$registerEmail = htmlspecialchars($_POST['registerEmail']);
$registerPassword = htmlspecialchars($_POST['registerPassword']);

if (isset($_POST['registerNext']))
{
    $userCheck = DB::queryCount("SELECT * FROM users WHERE user_email = '$registerEmail'");
    if ($userCheck == 0)
    {
        setcookie("check", true, time() + 2, '/');
        setcookie("email", $registerEmail, time() + 2, '/');
        setcookie("password", $registerPassword, time() + 2, '/');
        header('Location: ./../register.php');
    }
    else
    {
        setcookie("message", "Вы ввели существующие данные.", time() + 2, '/');
        header('Location: ./../register.php');
    }
}

$registerFirstName = htmlspecialchars($_POST['registerFirstName']);
$registerLastName = htmlspecialchars($_POST['registerLastName']);
$registerNickName = htmlspecialchars($_POST['registerNickName']);
$registerDate = htmlspecialchars($_POST['registerDate']);
$registerCountry = htmlspecialchars($_POST['registerCountry']);
$registerCity = htmlspecialchars($_POST['registerCity']);
$regusterInfo = htmlspecialchars($_POST['registerInfo']);

if (isset($_POST['registerButton']))
{
    $registerPassword = password_hash($registerPassword, PASSWORD_DEFAULT);

    $addAccount = DB::query("INSERT INTO `users`(
                                    `id_user`,
                                    `user_nickname`,
                                    `user_email`,
                                    `user_birthday`,
                                    `user_password`,
                                    `user_firstname`,
                                    `user_lastname`,
                                    `user_country`,
                                    `user_city`,
                                    `user_info`,
                                    `user_profileimage_path`
                                )
                                VALUES(
                                    NULL,
                                    '$registerNickName',
                                    '$registerEmail',
                                    '$registerDate',
                                    '$registerPassword',
                                    '$registerFirstName',
                                    '$registerLastName',
                                    '$registerCountry',
                                    '$registerCity',
                                    '$regusterInfo',
                                    'defaultUser.jpg'
                                );");
    
    setcookie("message", "Вы успешно зарегистрировались.", time() + 2, '/');
    header('Location: ./../index.php');
}