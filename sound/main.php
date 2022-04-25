<?php
session_start();
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
?>
    <div id="welcome">
        <p>JustChat SOUND</p>
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
    