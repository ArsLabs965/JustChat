<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if(isset($_POST[in])){
    if($_POST[login] != ''){
        $array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
       
$login = str_replace($array, "", trim($_POST[login]));

if($_POST[login] == $login){
    if($login != $_SESSION[user]){
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");

              if(($ac = mysqli_fetch_assoc($logge))){
                $logget = mysqli_query($connection, "SELECT * FROM `chats` WHERE `login` = '$_SESSION[user]' AND `who` = '$login'");

                if(!($acc = mysqli_fetch_assoc($logget))){
                mysqli_query($connection, "INSERT INTO `chats` (`login`, `who`) VALUES ('$_SESSION[user]', '$login')");

                header("Location: http://" . $_SERVER['SERVER_NAME'] . "/user.php?u=" . $login);
                exit();

                }else{
                    $option = 3;
                }
               
              }else{
                $option = 5;
              }
            }else{
                $option = 4;
            }
}else{
    $option = 2;
}
    }else{
        $option = 1;
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
    <div id="new">
        <a id="plus" href="chat.php">⬅</a>
    </div>
    <div id="center">
      <div id="global">
          <div id="cont">
        <h1>Новый чат</h1>
        <?php
            if($option == 1){
                echo '<br><a id="red">Вы не всё заполнили</a><br>';
            }
            if($option == 2){
                echo '<br><a id="red">Не используйте спецсимволы и пробелы</a><br>';
            }
            if($option == 3){
                echo '<br><a id="red">У вас уже есть чат с этим поьзователем</a><br>';
            }
            if($option == 4){
                echo '<br><a id="red">Нельзя выбрать себя</a><br>';
            }
            if($option == 5){
                echo '<br><a id="red">Такого пользователя нет</a><br>';
            }
        ?>
        <form action="" id="loginf" method="POST">
            Логин пользователя<br><input type="text" name="login" id="input"><br><br>
            
 
            <input type="submit" value="Добавить" name="in" id="input">
            

        </form>
        </div>
</div> 
</div>
</body>
</html>