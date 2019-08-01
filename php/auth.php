<?php
session_start();

require_once "DB.php";

$loginEmail = htmlspecialchars($_POST['loginEmail']);
$loginPassword = htmlspecialchars($_POST['loginPassword']);

if (isset($_POST['loginButton']))
{
    $userCheck = DB::queryCount("SELECT * FROM users WHERE user_email = '$loginEmail' AND user_password = '$loginPassword'");
    if ($userCheck == 1)
    {
        $dataUser = DB::query("SELECT id_user FROM users WHERE user_email = '$loginEmail' AND user_password = '$loginPassword'");
        $_SESSION['id_user'] = $dataUser['id_user'];
        header('Location: ../../../profile.php');
    }
    else
    {
        setcookie("message", "Вы ввели неверные данные.", time() + 2, '/');
        header('Location: ../../../login.php');
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
        header('Location: ../../../register.php');
    }
    else
    {
        setcookie("message", "Вы ввели существующие данные.", time() + 2, '/');
        header('Location: ../../../register.php');
    }
}

$registerFirstName = htmlspecialchars($_POST['registerFirstName']);
$registerLasttName = htmlspecialchars($_POST['registerLastName']);
$registerDate = htmlspecialchars($_POST['registerDate']);

echo $registerEmail . "<BR>";
echo $registerPassword . "<BR>";
echo $registerFirstName . "<BR>";
echo $registerLasttName . "<BR>";
echo $registerDate . "<BR>";