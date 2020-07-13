<?
session_start();
  if(empty($_SESSION['id_user']))
  {
    header('Location: index.php');
  }

  require_once(__DIR__ . '/DB.php');
  
  $idUser = (int)$_SESSION['id_user'];

  $idTo = $_GET['id'];

  foreach ($sql = DB::queryAll("SELECT * FROM `message`, `users` WHERE `users`.id_user = `message`.message_from AND ((`message_from` = $idUser AND `message_to` = $idTo) OR (`message_from` = $idTo AND `message_to` = $idUser)) ORDER BY message_date") as $data)
  {
    ?>
      <div class="message">
        <? echo '<img src="/upload/image/'. $data['user_profileimage_path'] . '" class="avatar">'; ?>
        <p class="name"> <? echo $data['user_firstname']; ?> <span class="date"> <? echo $data['message_date']; ?> </span></p>
        <p class="text"> <? echo $data['message_text']; ?></p>
      </div>
    <?
  }
  ?>