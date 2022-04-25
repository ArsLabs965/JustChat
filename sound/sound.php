<?php
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
<link rel="stylesheet" href="mainstyle.css">
</head>
<body>
<div id="aud"></div>
<div id="message"></div>
    <div id="maincontent">

    <div id="welcome">
        <p>Добро пожаловать!</p>
    </div>
    <div id="btnzone">
        <div id="your" onclick="goyour()">
            Ваши треки
        </div>
        <br>
        <div id="serch" onclick="goserch()">
            Поиск
        </div>
        <div id="load" onclick="goadd()">
            Загрузить
        </div>
        <div id="maybe">
        <p>Вам понравятся:</p>
       <div id="rec">

       </div>
    </div>
    </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $.ajax({
      method: "GET",
      url: "recomendations.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#rec").html(data);
	}
});
        function goadd(){
            $.ajax({
      method: "GET",
      url: "add.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#maincontent").html(data);
	}
});
            //document.location.href = "add.php";
        }
        function goyour(){
         
            $.ajax({
      method: "GET",
      url: "your.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#maincontent").html(data);
	}
});
        }
        function goserch(){
            $.ajax({
      method: "GET",
      url: "serch.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#maincontent").html(data);
	}
});
        }
        function gomain(){
            $.ajax({
      method: "GET",
      url: "main.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#maincontent").html(data);
       $.ajax({
      method: "GET",
      url: "recomendations.php",
      dataType: "text",
      data: {},
      success: function(data){  
       $("#rec").html(data);
	}
});
	}
});
        }
        var val_s, types_s, name_s;
       

        function audioplay(value, types, name){
            $("#aud").html(name + '<br><audio id="audio" controls autoplay src="music/' + value + '.' + types + '"></audio>');
            val_s = value;
            types_s = types;
            name_s = name;
        }
       

        var query = '';
        function check(){
            if(query != $("#serch_inp").val()){
                query = $("#serch_inp").val();
                get_re();
            }
            setTimeout(check, 500);
        }
        check();
        function get_re(){

        
       $.ajax({
      method: "GET",
      url: "serch_en.php",
      dataType: "text",
      data: {serch: $("#serch_inp").val()},
      success: function(data){  
        
       $("#received").html(data);
      
        
	}
});
}

function like_off(m_id){
    $.ajax({
      method: "GET",
      url: "likes.php",
      dataType: "text",
      data: {type: 'off', id: m_id},
      success: function(data){  
        $("#message").html('<div id="mjs">Удалено из Ваших треков</div>');
        goyour();
       setTimeout(cl_message, 2000);
      }
        
	});

}

function like_on(m_id){

    $.ajax({
      method: "GET",
      url: "likes.php",
      dataType: "text",
      data: {id: m_id, type: 'on'},
      success: function(data){  
          console.log(data);
        $("#message").html('<div id="mjs">Добавлено в Ваши треки</div>');
        goyour();
       setTimeout(cl_message, 2000);
      }
        
	});
}

function cl_message(){
    $("#message").html('');
}
    </script>
</body>
</html>