<?php
session_start();
if (empty($_SESSION['id_user']))
{
    header('Location: login.php');
}

require_once(__DIR__ . '/php/DB.php');
$idUser = (int)$_SESSION['id_user'];

$idTo = $_GET['id'];

$nameUser = DB::query("SELECT user_firstname FROM users WHERE id_user = $idTo;")['user_firstname'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Чат с <? echo $nameUser; ?></title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/chat.css">
    <script defer>
        function showMSG()
        {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function()
            {
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
                {
                    document.querySelector('#messages').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'php/messageRender.php?id=<? echo $idTo ?>', true);
            xhr.send();

        }

        setInterval(function() { showMSG(); }, 1000);
        setTimeout(function() {
            document.querySelector('#messages').scrollTop = document.querySelector('#messages').scrollHeight;
        }, 1000);

        function sendMSG(e)
        {
            e.preventDefault();
            let data = 'text=' + document.querySelector('.send textarea').value;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/messageSend.php?id=<? echo $idTo ?>', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(data);
            document.querySelector('.send textarea').value = '';
            setTimeout(function() {
                document.querySelector('#messages').scrollTop = document.querySelector('#messages').scrollHeight;
            }, 1000);
        }
    </script>
</head>

<body onload="showMSG()">
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

        <div class="message-box">
            <h3> Общение с <? echo $nameUser; ?> </h3>
            <hr>
            <div id="messages"></div>
            <hr>
            <form onsubmit="sendMSG(event);" method="post" class="send">
                <textarea></textarea>
                <button type="submit"> Отправить</button>
            </form>
        </div>

    </div>
</body>
</html>