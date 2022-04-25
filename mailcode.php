<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if(isset($_POST[send])){
    if($_POST[code] == $_SESSION[code]){
        mysqli_query($connection, "UPDATE `accaunts` SET `mail` = '$_SESSION[mail]' WHERE `login` = '$_SESSION[user]'");
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/chat.php");
        exit();
    }else{
        $_SESSION[mail] = NULL;
        $_SESSION[code] = NULL;
        header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="img/ico.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
    <title>Just Chat</title>
</head>
<body>
    <div id="center">
      <div id="global">
          <div id="cont">
        <h1>Подтверждение</h1>
        На вашу почту было отправлено письмо с кодом, вставьте его ниже<br>
        <?php
             
        ?>
        <form action="" id="loginf" method="POST">
            Код<br><input type="text" name="code" id="input"><br><br>
            <input type="submit" value="Отправить" name="send" id="input">
            

        </form>
        </div>
</div> 
</div>
</body>
</html>