<?php
session_start();
if($_SESSION[user] == NULL){
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');
$array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
       
$login = str_replace($array, "", trim($_GET[who]));
$arrayp = ["'",'"'];
$tex = str_replace($arrayp, "", trim($_GET[text]));


if($_GET[mode] == 'send'){
    $logge = mysqli_query($connection, "SELECT * FROM `chats` WHERE `who` = '$_SESSION[user]' AND `login` = '$login'");
                if(!($ac = mysqli_fetch_assoc($logge))){
                    mysqli_query($connection, "INSERT INTO `chats` (`login`, `who`) VALUES ('$login', '$_SESSION[user]')");
                }else{
                    mysqli_query($connection, "UPDATE `chats` SET `time` = NOW() WHERE `who` = '$_SESSION[user]' AND `login` = '$login'");
                }
                mysqli_query($connection, "UPDATE `chats` SET `time` = NOW() WHERE `login` = '$_SESSION[user]' AND `who` = '$login'");
                mysqli_query($connection, "INSERT INTO `massages` (`login`, `who`, `text`) VALUES ('$_SESSION[user]', '$login', '$tex')");
                $mass = $_GET[mass] + 1;
                echo '<div id="mymass"><div id="mymassa">' . htmlspecialchars($tex) . '</div></div><div id="mass' . $mass . '"></div>';
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
$mail->Body    = 'На ваш аккаунт ' . $login . ' пришло новое сообщение от ' . $_SESSION[user] . ': ' . htmlspecialchars($tex);
$mail->AltBody = '';

if(!$mail->send()) {
   
} else {
    
}
   }
               
               
}
if($_GET[mode] == 'check'){
    $logge = mysqli_query($connection, "SELECT * FROM `massages` WHERE `who` = '$_SESSION[user]' AND `login` = '$login' AND `seen` = 0");
    mysqli_query($connection, "UPDATE `accaunts` SET `time` = NOW() WHERE `login` = '$_SESSION[user]'");
    mysqli_query($connection, "UPDATE `accaunts` SET `chat` = '$login' WHERE `login` = '$_SESSION[user]'");
                if(($ac = mysqli_fetch_assoc($logge))){
                    $logge = mysqli_query($connection, "SELECT * FROM `massages` WHERE `who` = '$_SESSION[user]' AND `login` = '$login'  AND `seen` = 0  ORDER BY `time`");
                    $mass = $_GET[mass] + 1;
                while(($ac = mysqli_fetch_assoc($logge))){
                    
                    echo '<div id="notmymass"><div id="notmymassa">';
                    if($ac[fileway] != NULL){
                        list($typef, $rash) = explode('/', $ac[filetype]);
                        if($typef == 'image'){
                            echo '<img src="files/' . $ac[fileway] . '" width="100%" alt="">';
                            echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                        }else
                        if($typef == 'video'){
                            echo '<video controls src="files/' . $ac[fileway] . '" width="100%" alt=""></video>';
                            echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                        }else
                        if($typef == 'audio'){
                            echo '<audio controls src="files/' . $ac[fileway] . '" width="100%" alt=""></audio>';
                            echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                        }
                            echo '<a download href="files/' . $ac[fileway] . '">Скачать</a><br><br>';
                        
                    }
                    echo htmlspecialchars($ac[text]) . '</div></div>';
                }
                    echo '<div id="mass' . $mass . '"></div>';
                    mysqli_query($connection, "UPDATE `massages` SET `seen` = 1 WHERE `who` = '$_SESSION[user]' AND `login` = '$login'");
                }
                
               
               
               
}
if($_GET[mode] == 'was'){
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
   
               
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
                                        if($ac[writing]){
                                            echo 'Печатет...';
                                        }else{
                                        echo 'В вашем чате';
                                        }
                                    }else{
                                        echo 'В сети';
                                    }
                                }
                               
                            }else{
                                echo date('s') - $second . ' секунд назад';
                            }
                        }else{
                            echo date('i') - $minute . ' минут назад';
                        }
                    }else{
                        echo 'Сегодня в ' . $hour . ':' . $minute;
                    }
                }else if($day + 1 == date('d')){
                    echo 'Вчера в ' . $hour . ':' . $minute;
                }else{
                    echo $day . ' числа в ' . $hour . ':' . $minute;
                }
               
            }else{
                echo $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
            }
           
        }else{
            echo $year . ' год, ' . $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
        }
    }
}
if($_GET[mode] == 'lis'){
    $logge = mysqli_query($connection, "SELECT * FROM `chats` WHERE `login` = '$_SESSION[user]' ORDER BY `time` DESC");

    while(($ac = mysqli_fetch_assoc($logge))){
        ?>
        <div id="unity" onclick="going('<?php echo $ac[who]; ?>')" style="background-color: rgb(5, 5, 200);">
        <div id="onec">
            
            <a id="plus" href="user.php?u=<?php echo $ac[who]; ?>">
        <?php
        echo $ac[who];
        echo ' ';
        //SELECT COUNT(*) as count FROM workers WHERE age=23
        $logget = mysqli_query($connection, "SELECT COUNT(*) as count FROM `massages` WHERE `who` = '$_SESSION[user]' AND `login` = '$ac[who]' AND `seen` = 0");
        $acc = mysqli_fetch_assoc($logget);
        if($acc[count] > 0){
        echo '<a id="nseen">';
            echo $acc[count];
        echo '</a>';
        }
        ?>
        </a>
            </div>
            <div id="onecc">
                <?php
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
                                           echo 'Прямо сейчас!';
                                       }else{
                                           echo date('s') - $second . ' секунд назад';
                                       }
                                   }else{
                                       echo date('i') - $minute . ' минут назад';
                                   }
                               }else{
                                   echo 'Сегодня в ' . $hour . ':' . $minute;
                               }
                           }else if($day + 1 == date('d')){
                               echo 'Вчера в ' . $hour . ':' . $minute;
                           }else{
                               echo $day . ' числа в ' . $hour . ':' . $minute;
                           }
                          
                       }else{
                           echo $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                       }
                      
                   }else{
                       echo $year . ' год, ' . $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                   }
           
                ?>
                </div>
            </div>
        <?php
    }
}
if($_GET[mode] == 'noty'){
    $logget = mysqli_query($connection, "SELECT COUNT(*) as count FROM `massages` WHERE `who` = '$_SESSION[user]' AND `seen` = 0 AND `login` != '$login'");
    $acc = mysqli_fetch_assoc($logget);
    echo $acc[count];
}
if($_GET[mode] == 'write'){
   if($_GET[value]){
    mysqli_query($connection, "UPDATE `accaunts` SET `writing` = 1 WHERE `login` = '$_SESSION[user]'");
   }else{
    mysqli_query($connection, "UPDATE `accaunts` SET `writing` = 0 WHERE `login` = '$_SESSION[user]'");
   }
}
if($_GET[mode] == 'al'){
    $page = $_SESSION[lst];
   if($page == -1){
    echo 'none';
    exit();
   }
    $_SESSION[lst] = $_SESSION[lst] + 1;
$pagee = $page + 1;
$page *= 10;
    echo '<div id="his' . $pagee . '"></div>';
    $logget = mysqli_query($connection, "SELECT * FROM (SELECT * FROM `massages` WHERE `seen` = 1 AND `who` = '$_SESSION[user]' AND `login` = '$login' OR `login` = '$_SESSION[user]' AND `who` = '$login' ORDER BY `time` DESC LIMIT " . $page . ", 10) t ORDER BY `time`");
    $colvo = 0;
    while(($ac = mysqli_fetch_assoc($logget))){
        $colvo++;
        if($ac[login] == $_SESSION[user]){
            echo '<div id="mymass"><div id="mymassa">';
            if($ac[fileway] != NULL){
                list($typef, $rash) = explode('/', $ac[filetype]);
                if($typef == 'image'){
                    echo '<img src="files/' . $ac[fileway] . '" width="100%" alt="">';
                    echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                }else
                if($typef == 'video'){
                    echo '<video controls src="files/' . $ac[fileway] . '" width="100%" alt=""></video>';
                    echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                }else
                if($typef == 'audio'){
                    echo '<audio controls src="files/' . $ac[fileway] . '" width="100%" alt=""></audio>';
                    echo '<a href="files/' . $ac[fileway] . '">Открыть</a> ';
                }
                    echo '<a download href="files/' . $ac[fileway] . '">Скачать</a><br><br>';
                
            }
            echo htmlspecialchars($ac[text]) . ' <samp id="dt">';
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
                                    echo 'Прямо сейчас!';
                                }else{
                                    echo date('s') - $second . ' секунд назад';
                                }
                            }else{
                                echo date('i') - $minute . ' минут назад';
                            }
                        }else{
                            echo 'Сегодня в ' . $hour . ':' . $minute;
                        }
                    }else if($day + 1 == date('d')){
                        echo 'Вчера в ' . $hour . ':' . $minute;
                    }else{
                        echo $day . ' числа в ' . $hour . ':' . $minute;
                    }
                   
                }else{
                    echo $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                }
               
            }else{
                echo $year . ' год, ' . $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
            }
            echo '</samp></div></div>';
        }else{
            echo '<div id="notmymass"><div id="notmymassa">';
            if($ac[fileway] != NULL){
                list($typef, $rash) = explode('/', $ac[filetype]);
                if($typef == 'image'){
                    echo '<img src="files/' . $ac[fileway] . '" width="100%" alt=""><br>';
                }else
                if($typef == 'video'){
                    echo '<video controls src="files/' . $ac[fileway] . '" width="100%" alt=""></video><br>';
                }else
                if($typef == 'audio'){
                    echo '<audio controls src="files/' . $ac[fileway] . '" width="100%" alt=""></audio><br>';
                }
                echo '<a href="files/' . $ac[fileway] . '">Скачать</a><br><br>';
            }
            echo htmlspecialchars($ac[text]) . ' <samp id="dt">';
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
                                    echo 'Прямо сейчас!';
                                }else{
                                    echo date('s') - $second . ' секунд назад';
                                }
                            }else{
                                echo date('i') - $minute . ' минут назад';
                            }
                        }else{
                            echo 'Сегодня в ' . $hour . ':' . $minute;
                        }
                    }else if($day + 1 == date('d')){
                        echo 'Вчера в ' . $hour . ':' . $minute;
                    }else{
                        echo $day . ' числа в ' . $hour . ':' . $minute;
                    }
                   
                }else{
                    echo $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
                }
               
            }else{
                echo $year . ' год, ' . $day . ' ' . $mo . ' в ' . $hour . ':' . $minute;
            }
            echo '</samp></div></div>';
        }
        
    }
    if($colvo == 0){
        $_SESSION[lst] = -1;
        ?>
<div id="bggrey">Конец чата</div>
        <?php
    }
}
?>