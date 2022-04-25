<?php
$option = 0;
session_start();
$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');
if($_SESSION[user] != NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/mail.php");
    exit();
}
//echo $_SERVER['REMOTE_ADDR'];
//echo ' ';
//echo $_SERVER['REMOTE_PORT'];
//echo $_COOKIE[user];
$trust = $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'];
$arrayy = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
$loginc = str_replace($arrayy, "", trim($_COOKIE[user]));
$logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$loginc'");

              if(($ac = mysqli_fetch_assoc($logge))){
                    if($ac[trust] == $trust){
                        $_SESSION[user] = $loginc;
                        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/mail.php");
    exit();
                    }
              }


if(isset($_POST[in])){
    if($_POST[login] != '' AND $_POST[password] != ''){
        $array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
        $arrayp = ["'",'"'];
$login = str_replace($array, "", trim($_POST[login]));
$password = str_replace($arrayp, "", trim($_POST[password]));
if($_POST[login] == $login AND $_POST[password] == $password){
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");

              if(($ac = mysqli_fetch_assoc($logge))){
                //$yy = password_hash($password, PASSWORD_BCRYPT);
                if(password_verify($password, $ac[password])){
                    $_SESSION[user] = $login;
                   $_COOKIE[user] = $login;
                    mysqli_query($connection, "UPDATE `accaunts` SET `trust` = '$trust' WHERE `login` = '$login'");
                    if($_GET[after] == 'stars'){
                        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/juststars");
                        exit();
                    }
                    if($_GET[after] == 'triangle'){
                        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/triangle");
                        exit();
                    }
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/mail.php");
                exit();
                }else{
                    $option = 4;
                }
              }else{
                $option = 3;
              }
}else{
    $option = 2;
}
    }else{
        $option = 1;
    }
}
if(isset($_POST[reg])){
    if($_POST[login] != '' AND $_POST[password] != ''){
        $array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
        $arrayp = ["'",'"'];
$login = str_replace($array, "", trim($_POST[login]));
$password = str_replace($arrayp, "", trim($_POST[password]));
if($_POST[login] == $login AND $_POST[password] == $password){
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");

              if(!($ac = mysqli_fetch_assoc($logge))){
                $cript = password_hash($password, PASSWORD_BCRYPT);
                mysqli_query($connection, "INSERT INTO `accaunts` (`login`, `password`) VALUES ('$login', '$cript')");
                $_SESSION[user] = $login;
                $_COOKIE[user] = $login;
                    mysqli_query($connection, "UPDATE `accaunts` SET `trust` = '$trust' WHERE `login` = '$login'");
                    if($_GET[after] == 'stars'){
                        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/juststars");
                        exit();
                    }
                header("Location: http://" . $_SERVER['SERVER_NAME'] . "/mail.php");
                exit();
              }else{
                $option = 5;
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
    <div id="center">
      <div id="global">
          <div id="cont">
        <h1>Just Chat</h1>
        <div id="slog">
        <?php
        $va = rand(0, 7);
        if($va == 0){
        echo 'Просто Анонимно';
        }
        if($va == 1){
            echo 'За нами не следит власть';
            }
        if($va == 2){
            echo 'Тайна переписки - наше право!';
        }
        if($va == 3){
            echo 'С нами вы в безопасности❤';
        }
        if($va == 4){
            echo 'Никто не узнает кто вы';
        }
        if($va == 5){
            echo 'Пока нас мало, нас не найдут🤫';
        }
        if($va == 6){
            echo 'Общайтесь как хотите';
        }
        if($va == 7){
            echo 'Просто Доверьтесь';
        }
        echo '<br>';
            if($option == 1){
                echo '<br><a id="red">Вы не всё заполнили</a><br>';
            }
            if($option == 2){
                echo '<br><a id="red">Не используйте спецсимволы и пробелы</a><br>';
            }
            if($option == 3){
                echo '<br><a id="red">Такого логина не существует</a><br>';
            }
            if($option == 4){
                echo '<br><a id="red">Пароль не верный</a><br>';
            }
            if($option == 5){
                echo '<br><a id="red">Такой логин уже занят</a><br>';
            }
        ?></div>
        <form action="" id="loginf" method="POST">
            Логин<br><input type="text" name="login" id="input" value="<?php echo $login; ?>"><br><br>
            Пароль<br><input type="password" name="password" id="input"><br><br>
            <input type="submit" value="Регистрация" name="reg" id="input">
            <input type="submit" value="Войти" name="in" id="input"><br><br>
            <a href="JustChat.apk">Скачать приложение Android</a>
            

        </form>
        </div>
</div> 
</div>
<script src="anime.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    anime({
  targets: 'h1',
  scale: [0, 1], // from 100 to 250
  translateX: [0, 0], // from 100 to 250
  translateY: [100, 0], // from 100 to 250
  delay: 0,
  
  
});
anime({
  targets: '#slog',
  scale: [0, 1], // from 100 to 250
  translateX: [0, 0], // from 100 to 250
  translateY: [100, 0], // from 100 to 250
  delay: 50,
  
  
});
   anime({
  targets: '#loginf',
  scale: [0, 1], // from 100 to 250
  translateX: [0, 0], // from 100 to 250
  translateY: [-100, 0], // from 100 to 250
  delay: 100,
  
  
});
</script>
</body>
</html>