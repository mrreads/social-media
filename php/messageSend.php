<?
session_start();
  if(empty($_SESSION['id_user']))
  {
    header('Location: index.php');
  }

  require_once(__DIR__ . '/DB.php');
  
  $idUser = (int)$_SESSION['id_user'];
  $idTo = $_GET['id'];
  $textMessage = $_POST['text'];
  
  $query = DB::query("INSERT INTO `message` (`id_message`, `message_text`, `message_date`, `message_from`, `message_to`) VALUES (NULL, '$textMessage', CURRENT_TIME(), $idUser, $idTo);");