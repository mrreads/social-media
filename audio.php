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
    <title>Аудио</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/audio.css">
    <script src="./js/playAudio.js" defer></script>
    <script src="./js/audioPopup.js" defer></script>
</head>

<body>
    <div class="content">
        <div class="nav-menu">
            <?='<a href="./profile.php?id=' . $idUser . '">Профиль</a>'; ?>
            <hr>
            <a href="./users.php">Пользователи</a>
            <hr>
            <a href="./messages.php">Диалоги</a>
            <hr>
            <a href="./audio.php" id="active">Аудио</a>
            <hr>
            <a href="./logout.php">Выйти</a>
        </div>

        <div class="audio-list">
            <h3><span>Все Аудио</span>
                <button class="add"></button>
            </h3>
            <hr>
            <?
            foreach ($sql = DB::queryAll("SELECT * FROM `audio`") as $data) { ?>
                <div class="track">
                    <div class="play" data-id="<?=$data['id_audio']?>" data-active="false"></div>
                    <p class="track-name"> <? echo $data['audio_author'] . " - " . $data['audio_name']; ?></p>

                    <form action="./php/add-removeTrack.php" method="GET">
                        <button class="add" value="<? echo $data['id_audio'] ?>" name='audioAdd'></button>
                    </form>
                </div>
                <hr>
            <? } ?>
            <? $count = DB::queryCount("SELECT * FROM `audio`");
            if ($count === 0)
            { ?>
                <hr> <p style="width: 100%;text-align: center;"> Тут ничего нет </p>
            <? } ?>
        </div>

        <div class="your-list">
            <h3> Ваши аудио</h3>
            <hr>
            <?
            foreach ($sql = DB::queryAll("SELECT `audio`.`audio_author`, `audio`.audio_name, `audio`.`audio_file`, `user-audio`.id_audio FROM `user-audio`, `audio` WHERE `user-audio`.id_user = $idUser AND `user-audio`.`id_audio` = `audio`.`id_audio`") as $data) { ?>
                <div class="track">
                    <div class="play" data-id="<?=$data['id_audio']?>" data-active="false"></div>
                    <p class="track-name"> <? echo $data['audio_author'] . " - " . $data['audio_name']; ?></p>

                    <form action="./php/add-removeTrack.php" method="GET">
                        <button class="remove" value="<? echo $data['id_audio'] ?>" name='audioRemove'></button>
                    </form>
                </div>
                <hr>
            <? } ?>
            <? $count = DB::queryCount("SELECT * FROM `user-audio`, `audio` WHERE `user-audio`.id_user = $idUser AND `user-audio`.`id_audio` = `audio`.`id_audio`");
            if ($count === 0) { ?>
                <hr> <p style="width: 100%;text-align: center;"> Вы ничего не добавили </p> <? } ?>
        </div>

    </div>

    <div class="audioControl">
        <div class="previousTrack"></div>
        <div class="pauseTrack"></div>
        <div class="nextTrack"></div>
        <p class="infoTrack"> Название - Название </p>
        <input type="range" class="trackLenght" value="0" name="trackLenght" disabled>
        <p class="trackCurrent">0 : 00</p>
        <input type="range" min="0" to="100" value="100" class="rangeVolume" name="rangeVolume" disabled>
    </div>
                
</body>

<div class="popup-wrapper">
    <form action="./php/musicUpload.php" method="POST" enctype="multipart/form-data" class="popup">
        <button class="remove"></button>
        <input type="text" placeholder="Имя группы" name="author" required>
        <input type="text" placeholder="Название песни" name="name" required>
        <input type="file" class="profile-image-input" name="audio" required>
        <input type="submit" value="ЗАГРУЗИТЬ" name="button">
    </form>
</div>

</html>