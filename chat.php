<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'password', 'justchat');

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
        <a id="plus" href="new.php">➕</a>
    </div>
    <div id="leave">
        <a id="plus" href="out.php">⬅</a>
    </div>
    <div id="center">
      <div id="global">
          <div id="cont">
        <h1>Чаты</h1>
        <div id="over">
        </div>
        <br>
        <a id="sound" href="sound/index.php">Sound</a>
        </div>
</div> 
</div>
<script src="anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    
function going(login){
    location="user.php?u=" + login;
}
var notification = new Audio('img/notification.mp3');
var n = '0';
var gp = 0;
$.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'noty',
             who: '<?php echo $login; ?>'},
      success: function(data){  
        
       n = data;
      
        
	}
});
loop();
function loop(){
    $.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'lis'},
      success: function(data){  
        
       
        $('#over').html(data);
        if(gp == 0){
            gp = 1;
        anime({
  targets: '#unity',
  scale: [1, 1], // from 100 to 250
  translateX: [-100, 0], // from 100 to 250
  delay: anime.stagger(50) // increase delay by 100ms for each elements.
});
        }
	}
});
$.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'noty',
             who: '<?php echo $login; ?>'},
      success: function(data){  
        
       
      if(n != data){
        notification.play();
          n = data;
      }
        
	}
});
    setTimeout(loop, 1000);
}
</script>
</body>
</html>