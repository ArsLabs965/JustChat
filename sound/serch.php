<?php
session_start();
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
?>

<div id="welcome">
        <p>Поиск</p>
    </div>
    <div id="back">
        <a onclick="gomain()"><---</a>
    </div>
    <div id="padd">
       
      <input type="text" id="serch_inp" placeholder="Начните вводить"><br><br>
      <table>
      <div id="received">
          
      </div>
      </table>
    </div>
   