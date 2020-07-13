<?php
session_start();
if (empty($_SESSION['id_user']))
{
    header('Location: login.php');
}

$profileId = $_GET['id'];
require_once(__DIR__ . '/php/DB.php');
$idUser = (int)$_SESSION['id_user'];

if (empty($profileId))
{
    header('Location: profile.php?id=' . $idUser);
}

$dataUser = DB::query("SELECT * FROM users WHERE id_user = $profileId");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Профиль</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/profile.css">
    <?php if ($idUser != $profileId)
    { ?>
        <style> .profile-image-form:hover
            {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)
            } </style>
        <?php } ?>
</head>
<body>
    <div class="content">
        <div class="nav-menu">
            <?='<a href="./profile.php?id=' . $idUser . '" id="active">Профиль</a>'; ?>
            <hr>
            <a href="./users.php">Пользователи</a>
            <hr>
            <a href="./messages.php">Диалоги</a>
            <hr>
            <a href="./audio.php">Аудио</a>
            <hr>
            <a href="./logout.php">Выйти</a>
        </div>

        <div class="column-wrapper">
            <div class="profile_info">
                <form method="POST" action="php/imageUpload.php" enctype="multipart/form-data" class="profile-image-form">
                    <? if ($idUser == $profileId) { ?> <input type="file" class="profile-image-input" name="image"
                                                            onchange="this.form.submit()"> <? } ?>
                    <?='<img src="/upload/image/'. $dataUser['user_profileimage_path'] . '" class="profile-image">'; ?>
                </form>
                <p class="profile-name"> <? echo $dataUser['user_firstname'] . " " . $dataUser['user_lastname']; ?> </p>
                <p class="profile-birthday"> <? echo $dataUser['user_birthday'] . ", " . DB::query("SELECT TIMESTAMPDIFF(YEAR, user_birthday, CURDATE()) AS age FROM users WHERE id_user = $profileId")['age'] . " лет"; ?> </p>
                <p class="profile-location"> <? echo $dataUser['user_country'] . ", " . $dataUser['user_city']; ?> </p>
                <hr>
                <p class="profile-info"> <? echo $dataUser['user_info']; ?> </p>
                <?php if ($idUser != $profileId)
                { ?>
                    <hr>
                    <div class="action-buttons">
                        <a href="./chat.php?id=<? echo $profileId ?>"> Написать сообщение </a>
                    </div>
                <?php } ?>
            </div>

            <?php if ($idUser == $profileId)
            {
                ?>
                <form method="POST" action="./php/changeData.php" class="profile-setting">
                    <label for="input-username">Никнейм</label>
                    <input type="text" id="input-username" placeholder="Никнейм" value="<? echo $dataUser['user_nickname']; ?>"
                        name="nickname">

                    <label for="input-email">Почта</label>
                    <input type="email" id="input-email" placeholder="Почта" value="<? echo $dataUser['user_email']; ?>"
                        name="email">

                    <label for="input-first-name">Имя</label>
                    <input type="text" id="input-first-name" placeholder="Имя" value="<? echo $dataUser['user_firstname']; ?>"
                        name="firstname">

                    <label for="input-last-name">Фамилия</label>
                    <input type="text" id="input-last-name" placeholder="Фамилия" value="<? echo $dataUser['user_lastname']; ?>"
                        name="lastname">

                    <label for="input-country">Страна</label>
                    <input type="text" id="input-username" placeholder="Страна" value="<? echo $dataUser['user_country']; ?>"
                        name="country">

                    <label for="input-city">Город</label>
                    <input type="text" id="input-city" placeholder="Город" value="<? echo $dataUser['user_city']; ?>"
                        name="city">

                    <label for="birth">Дата рождения</label>
                    <input type="date" id="input-birth" placeholder="Дата рождения"
                        value="<? echo DB::query("SELECT user_birthday FROM users WHERE id_user = $idUser")['user_birthday']; ?>"
                        name="birth">

                    <label for="info">Информация обо мне</label>
                    <textarea placeholder="Пару слов о вас..." name="info"><? echo $dataUser['user_info']; ?></textarea>

                    <button>Сохранить информацию</button>
                </form>
            <?php } ?>
        </div>

        <div class="column-wrapper">

            <form class="create-post">
                <textarea name="post-textarea" id="text-content" cols="30" rows="10"></textarea>
                
                <div class="media-controls">
                    <div class="emoji">😀</div>
                </div>
                
                <emoji-picker class="hide"></emoji-picker>
                
                <div class="create-post-controls">
                    <button> Создать пост </button>
                    
                </div>
            </form>

        <?php
            $posts = DB::queryAll("SELECT * FROM post, users WHERE post.id_author = users.id_user AND post.id_user = $profileId;");
            if ($posts)
            {
                foreach ($posts as $post) { ?>
                    <div class="post">
                        <div class="post-author">
                            <?='<img src="/upload/image/'. $post['user_profileimage_path'] . '" class="post-image">'; ?>
                            <a href="#"> <?=$post['user_firstname'].' '.$post['user_lastname']?> </a>
                        </div> 
    
                        <hr>
    
                        <p class="post-content">
                            <?=$post['post_text']?>
                        </p>
                        
                    </div>
                <?php }
            }
            else
            { ?>
                <div class="post">
                    <p style="width: 100%; text-align: center; margin-top: 25px;"> На стене нет записей </p>
                </div>
            <?php } ?>
        </div>
    </div>
 
    <script type="module" src="/js/emoji.js"> </script>
</body>
</html>