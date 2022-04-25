<?php
$option = 0;
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$_SESSION[lst] = 0;
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
        <a id="plus" href="chat.php">⬅</a>
    </div>
    <div id="inp">
    <a style="text-decoration: none;" href="userfile.php?u=<?php echo $login; ?>" id="snd">📎</a><input id="inputchat" placeholder="Сообщение" class="chat" type="text"><a onclick="send()" id="snd">🔼</a>
    </div>
    <div id="center">
      <div id="global">
          <div id="cont">
        <h2><?php echo $login; ?></h2>
        <div id="status"></div><br>
        <div id="overchat">
        
        <div id="his0">

            </div>
            <div id="bggrey">Непрочитанные сообщения</div>
            <div id="mass0">

            </div>
        </div>
        
       
        </div>
</div> 
</div>
<script src="anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    var sends = new Audio('img/send.mp3');
    var recive = new Audio('img/recive.mp3');
    var notification = new Audio('img/notification.mp3');
    var none = 0;
    var valueonline = '';
var n = '0';
var lasttext = '';
    var mass = 0;
    var here = 0;
    loadnw();
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
    $('.chat').keydown(function(e){
        if(e.keyCode === 13){
            send();
        }
    });
    function send(){
      var ttext = $('.chat').val();
        if(ttext != ''){
          sends.play();
        $('.chat').val('');
        $('#mass' + mass).html('<div id="mymass"><div id="mymassa">' + ttext + " (Отправляем)</div></div>");
        anime({
  targets: '#mass' + mass,
  scale: [1, 1], // from 100 to 250
  translateX: [0, 0], // from 100 to 250
  translateY: [100, 0], // from 100 to 250
  delay: 0,
  
  
});
        
        $('#overchat').scrollTop(9999999);
        $.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'send',
            mass: mass,
            text: ttext,
             who: '<?php echo $login; ?>'},
      success: function(data){  
        $('#mass' + mass).html(data);
        mass++;
	}
});
        }
    }
    
    function loop(){
        var scroll = $("#overchat").scrollTop();
       if(scroll < 10 && none == 0){
        $("#overchat").scrollTop(scroll + 20)
        loadnw();
       }
        if(lasttext != $('.chat').val()){
          $('#overchat').scrollTop(9999999);
            $.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'write',
            value: 1},
      success: function(data){  
	}
});
        }else{
            $.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'write',
            value: 0},
      success: function(data){  
	}
});
        }
        lasttext = $('.chat').val();
        $.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'check',
            mass: mass,
             who: '<?php echo $login; ?>'},
      success: function(data){  
        
       
        $('#mass' + mass).html(data);
        anime({
  targets: '#mass' + mass,
  scale: [1, 1], // from 100 to 250
  translateX: [-100, 0], // from 100 to 250
  translateY: [0, 0], // from 100 to 250
  delay: 0,
  
  
});
        if(data != ''){
        mass++;
        recive.play();
        $('#overchat').scrollTop(9999999);
        }
	}
});

$.ajax({
      method: "GET",
      url: "control.php",
      dataType: "text",
      data: {mode: 'was',
             who: '<?php echo $login; ?>'},
      success: function(data){  
        
        
       
        $('#status').html(data);
        if(data != valueonline){
          valueonline = data;
          anime({
  targets: '#status',
  scale: [1, 1], // from 100 to 250
  translateX: [-30, 0], // from 100 to 250
  translateY: [0, 0], // from 100 to 250
  delay: 0,
  
  
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
    function loadnw(){
        if(none == 0){
        var ti = "control.php?mode=al&who=<?php echo $login; ?>";
        
        
        $.get( ti, function( data ) {
 
  if(data == 'none'){
    none = 1;
  }else{
    $( "#his" + here ).html( data );
    anime({
  targets: "#his" + here,
  scale: [1, 1], // from 100 to 250
  translateX: [-100, 0], // from 100 to 250
  translateY: [0, 0], // from 100 to 250
  delay: 0,
  
  
});
  if(here < 2){
            $('#overchat').scrollTop(9999999);
        }
        here++;
  }
});
        
        }
}

  

</script>
</body>
</html>