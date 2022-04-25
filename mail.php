<?php
$option = 0;
require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');
$logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");

              if(($ac = mysqli_fetch_assoc($logge))){
                if($ac[mail] != NULL){
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/chat.php");
                    exit();
                }
              }
if(isset($_POST[send])){
    $array = ["'",'"'," ", "/", "|", "\\", "*", ":", "<", ">"];
    $mailu = str_replace($array, "", trim($_POST[mail]));
    if($mailu != ''){
        //mysqli_query($connection, "UPDATE `accaunts` SET `mail` = '$mail' WHERE `login` = '$_SESSION[user]'");
        $_SESSION[code] = rand(100000, 999999);
        $_SESSION[mail] = $mailu;
        $mail->CharSet = 'utf-8';

$name = $_POST['user_name'];
$phone = $_POST['user_phone'];
$email = $_POST['user_email'];

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';  																							// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'MAIL'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = 'PASSWORD'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$mail->setFrom('MAIL'); // от кого будет уходить письмо?
$mail->addAddress($mailu);     // Кому будет уходить письмо 
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Just Chat';
$mail->Body    = 'Вот ваш код: ' . $_SESSION[code] . '. Никому его не сообщайте!';
$mail->AltBody = '';

if(!$mail->send()) {
    $option = 2;
} else {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/mailcode.php");
    exit();
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
        <h1>Почта</h1>
        Подключите электронную почту, чтобы уведомять вас о новых сообщениях<br>
        <?php
             if($option == 1){
                echo '<br><a id="red">Проверьте, всё ли верно, и не использовали ли вы спецсимволы</a><br>';
            }
            if($option == 2){
                echo '<br><a id="red">Не удалось отправить</a><br>';
            }
        ?>
        <form action="" id="loginf" method="POST">
            Почта<br><input type="text" name="mail" id="input"><br><br>
            <input type="submit" value="Подтвердить" name="send" id="input"><br><br>
            <a href="chat.php">Отложить на потом</a>
            

        </form>
        </div>
</div> 
</div>
</body>
</html>