<?php
session_start();
if (empty($_SESSION['id_user']))
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
    <title>Диалоги</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/messages.css">
</head>

    <body>
    <div class="content">
        <div class="nav-menu">
            <?='<a href="./profile.php?id=' . $idUser . '">Профиль</a>'; ?>
            <hr>
            <a href="./users.php">Пользователи</a>
            <hr>
            <a href="./messages.php" id="active">Диалоги</a>
            <hr>
            <a href="./audio.php">Аудио</a>
            <hr>
            <a href="./logout.php">Выйти</a>
        </div>

        <div class="dialog-list">
            <h3>Ваши диалоги</h3>
            <hr>
            <?php
            foreach ($sql = DB::queryAll("SELECT DISTINCT message_from, user_firstname, user_profileimage FROM `message`, `users` WHERE `users`.id_user = `message`.message_from AND message_to = $idUser UNION SELECT DISTINCT message_to, user_firstname, user_profileimage FROM `message`, `users` WHERE `users`.id_user = `message`.message_to AND message_from = $idUser") as $data) { ?>
                <a href="./chat.php?id=<? echo $data['message_from'] ?>">
                    <? echo '<img src="data:image/jpeg;base64,' . base64_encode($data['user_profileimage']) . '">'; ?>
                    <? echo "<p> Диалог с " . $data['user_firstname'] . "</p>" ?>
                </a>
                <hr>
            <? } ?>
            <? $count = DB::queryCount("SELECT DISTINCT message_from, user_firstname, user_profileimage FROM `message`, `users` WHERE `users`.id_user = `message`.message_from AND message_to = $idUser UNION SELECT DISTINCT message_to, user_firstname, user_profileimage FROM `message`, `users` WHERE `users`.id_user = `message`.message_to AND message_from = $idUser");
            if ($count === 0)
            { ?>
                <hr> <p style="width: 100%;text-align: center;"> У вас нет диалогов </p>
            <? } ?>
        </div>
    </div>
    <script defer>
        let listHR;
        listHR = document.querySelectorAll('.dialog-list hr');
        listHR[listHR.length - 1].remove();
    </script>
</body>

</html>