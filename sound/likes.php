<?php
session_start();
if($_SESSION[user] == NULL){
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if($_GET[type] == 'off'){
    $logge = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = " . $_GET[id]);
    if(($ac = mysqli_fetch_assoc($logge))){
        mysqli_query($connection, "DELETE FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = " . $_GET[id]);
        $logge = mysqli_query($connection, "SELECT * FROM `music` WHERE `id` = " . $_GET[id]);
        if(($acc = mysqli_fetch_assoc($logge))){
            $logge = mysqli_query($connection, "SELECT * FROM `music_users` WHERE `login` = '$_SESSION[user]' AND `what` = '$acc[type]'");
        if(($accd = mysqli_fetch_assoc($logge))){
            if($accd[value] == 1){
                mysqli_query($connection, "DELETE FROM `music_users` WHERE `login` = '$_SESSION[user]' AND `what` = '$acc[type]'");
            }else{
                $tt = $accd[value] - 1;
                mysqli_query($connection, "UPDATE `music_users` SET `value` = '$tt' WHERE `login` = '$_SESSION[user]' AND `what` = '$acc[type]'");
            }
        }
        }
    }
}else
if($_GET[type] == 'on'){
    
    $logge = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = '$_GET[id]'");
    if(!($ac = mysqli_fetch_assoc($logge))){

 
        
        mysqli_query($connection, "INSERT INTO `music_like` (`login`, `music`) VALUES ('$_SESSION[user]', '$_GET[id]')");
        $logget = mysqli_query($connection, "SELECT * FROM `music` WHERE `id` = '$_GET[id]'");
        if(($acf = mysqli_fetch_assoc($logget))){
            $logges = mysqli_query($connection, "SELECT * FROM `music_users` WHERE `login` = '$_SESSION[user]' AND `what` = '$acf[type]'");
            if($acf[type] != 'default')
            if(($ac = mysqli_fetch_assoc($logges))){
                $newvalue = $ac[value] + 1;
                mysqli_query($connection, "UPDATE `music_users` SET `value` = '$newvalue' WHERE `login` = '$_SESSION[user]' AND `what` = '$acf[type]'");
            }else{
                mysqli_query($connection, "INSERT INTO `music_users` (`login`, `what`) VALUES ('$_SESSION[user]', '$acf[type]')");
            }
        }
        
    }
}
?>