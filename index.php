<?php
session_start();

if(isset($_SESSION['id_user']))
{
  header('Location: profile.php');
}

if(empty($_SESSION['id_user']))
{
  header('Location: login.php');
}