<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
$array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
$login = str_replace($array, "", trim($_GET[u]));
$arrayp = ["'",'"'];

$tex = str_replace($arrayp, "", trim($_POST[msg]));
if(isset($_POST[send])){
    if(isset($_FILES[file]) AND $_FILES[file][size] > 0){
        $name = $_FILES[file][name];
        $tmp = $_FILES[file][tmp_name];
        $size = $_FILES[file][size];
        $type = $_FILES[file][type];
        if($size < 536870912){
            $tin = time() . $name;

            move_uploaded_file($tmp, "files/" . $tin);
            $logge = mysqli_query($connection, "SELECT * FROM `chats` WHERE `who` = '$_SESSION[user]' AND `login` = '$login'");
                if(!($ac = mysqli_fetch_assoc($logge))){
                    mysqli_query($connection, "INSERT INTO `chats` (`login`, `who`) VALUES ('$login', '$_SESSION[user]')");
                }else{
                    mysqli_query($connection, "UPDATE `chats` SET `time` = NOW() WHERE `who` = '$_SESSION[user]' AND `login` = '$login'");
                }
                mysqli_query($connection, "UPDATE `chats` SET `time` = NOW() WHERE `login` = '$_SESSION[user]' AND `who` = '$login'");
            if($_POST[msg] == ''){
                
                mysqli_query($connection, "INSERT INTO `massages` (`login`, `who`, `text`, `fileway`, `filetype`) VALUES ('$_SESSION[user]', '$login', 'Файл', '$tin', '$type')");
            }else{
                mysqli_query($connection, "INSERT INTO `massages` (`login`, `who`, `text`, `fileway`, `filetype`) VALUES ('$_SESSION[user]', '$login', '$tex', '$tin', '$type')");
            }
            $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
                $online = 0;
                if(($ac = mysqli_fetch_assoc($logge))){
                    list($date, $time) = explode(' ', $ac[time]);
                    list($year, $month, $day) = explode('-', $date);
                    list($hour, $minute, $second) = explode(':', $time);
                    $mo = '';
                            if($month == '01'){
                                $mo = 'Января';
                            }
                            if($month == '02'){
                                $mo = 'Февраля';
                            }
                            if($month == '03'){
                                $mo = 'Марта';
                            }
                            if($month == '04'){
                                $mo = 'Апреля';
                            }
                            if($month == '05'){
                                $mo = 'Мая';
                            }
                            if($month == '06'){
                                $mo = 'Июня';
                            }
                            if($month == '07'){
                                $mo = 'Июля';
                            }
                            if($month == '08'){
                                $mo = 'Августа';
                            }
                            if($month == '09'){
                                $mo = 'Сентября';
                            }
                            if($month == '10'){
                                $mo = 'Октября';
                            }
                            if($month == '11'){
                                $mo = 'Ноября';
                            }
                            if($month == '12'){
                                $mo = 'Декабря';
                            }
                    if($year == date('Y')){
                        if($month == date('m')){
                            if($day == date('d')){
                                if($hour == date('H')){
                                    if($minute == date('i')){
                                        if($second + 20 > date('s')){
                                            $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
   
               
                                if(($ac = mysqli_fetch_assoc($logge))){
                                    if($ac[chat] == $_SESSION[user]){
                                        $online = 1;
                                    }else{
                                      
                                    }
                                }
                                           
                                           
                                        }
                                    }
                                }
                            }
                           
                        }
                       
                    }
                }


   if($online == 0){
       $mailu = '';
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
    if(($ac = mysqli_fetch_assoc($logge))){
        $mailu = $ac[mail];
    }
    require_once('phpmailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    $mail->CharSet = 'utf-8';

$name = $_POST['user_name'];
$phone = $_POST['user_phone'];
$email = $_POST['user_email'];

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';  																							// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'admin@3019.ru'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = '20042212As!'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$mail->setFrom('admin@3019.ru'); // от кого будет уходить письмо?
$mail->addAddress($mailu);     // Кому будет уходить письмо 
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Just Chat';
$mail->Body    = 'На ваш аккаунт ' . $login . ' пришло новое сообщение от ' . $_SESSION[user] . ': ' . htmlspecialchars($tex);
$mail->AltBody = '';

if(!$mail->send()) {
   
} else {
    
}
   }
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/user.php?u=" . $login);
            exit();
        }else{
            $option = 1;
        }
    }else{
        $option = 2;
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
<div id="neww">
        <a id="plus" href="user.php?u=<?php echo $login; ?>">⬅</a>
    </div>
    
    <div id="center">
      <div id="global">
          <div id="cont">
        <h2><?php echo $login; ?></h2>
        <a id="status"></a><br>
        <?php
             if($option == 1){
                echo '<br><a id="red">Файл привышает допустимый размер (512 Мегабайт)</a><br>';
            }
            if($option == 2){
                echo '<br><a id="red">Файл не загружен</a><br>';
            }
           
        ?>
        <img id="loading" width="90%" src="img/loading.gif" alt="">
        <form action="" id="loginf" method="POST" enctype="multipart/form-data">
            Файл<br><input type="file" name="file"><br><br>
            текст к файлу<br><input type="text" name="msg" id="input"><br><br>
            <input onclick="load()" type="submit" value="Отправить" name="send" id="input"><br><br>
            
            

        </form>

       
        </div>
</div> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $("#loading").hide();
    function load(){
        $("#loading").show();
        $("#loginf").hide();
    }
    var mass = 0;
    loop();
    
    function loop(){
      

$.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'was',
             who: '<?php echo $login; ?>'},
      success: function(data){  
        
       
        $('#status').html(data);
        
	}
});



        setTimeout(loop, 1000);
    }
</script>
</body>
</html>