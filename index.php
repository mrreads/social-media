<?php
session_start();

if (isset($_SESSION['id_user'])) 
{
    header('Location: profile.php');
}
else 
{
    header('Location: login.php');
}
