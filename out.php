<?php
session_start();

$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');
mysqli_query($connection, "UPDATE `accaunts` SET `trust` = NULL WHERE `login` = '$_SESSION[user]'");
$_SESSION[user] = NULL;
header("Location: http://" . $_SERVER['SERVER_NAME']);
?>