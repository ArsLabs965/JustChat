<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');
$array = ["'",'"',"@"," ", "/", "|", "\\", "*", ":", "<", ">"];
$login = str_replace($array, "", trim($_GET[u]));
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
        <div id="overchat">
            <div id="bggrey">История переписки</div>
          <?php
            
                $logget = mysqli_query($connection, "SELECT * FROM `massages` WHERE `who` = '$_SESSION[user]' AND `login` = '$login' OR `login` = '$_SESSION[user]' AND `who` = '$login' ORDER BY `time` DESC");
            while(($ac = mysqli_fetch_assoc($logget))){
                if($ac[login] == $_SESSION[user]){
                    echo '<div id="mymass"><div id="mymassa">';
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
                        }else{
                            echo '<a href="files/' . $ac[fileway] . '">Скачать</a><br><br>';
                        }
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
                        }
                        if($typef == 'video'){
                            echo '<video controls src="files/' . $ac[fileway] . '" width="100%" alt=""></video><br>';
                        }
                        if($typef == 'audio'){
                            echo '<audio controls src="files/' . $ac[fileway] . '" width="100%" alt=""></audio><br>';
                        }
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
          ?>
        </div>
        
       
        </div>
</div> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
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