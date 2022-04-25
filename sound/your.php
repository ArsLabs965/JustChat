<?php
session_start();
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
?>

<div id="welcome">
        <p>Ваши треки</p>
    </div>
    <div id="back">
        <a onclick="gomain()"><---</a>
    </div>
    <div id="padd">
        <table width="100%">
            <?php
            $counter = 0;
                $logge = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' ORDER BY `id` DESC");
                while(($ac = mysqli_fetch_assoc($logge))){
                    $counter++;
                    $logget = mysqli_query($connection, "SELECT * FROM `music` WHERE `id` = '$ac[music]'");
                    if(($acc = mysqli_fetch_assoc($logget))){
                        
                    }
                    ?>
                        <tr width="100%">
                            <td onclick="audioplay(<?php echo $ac[music]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="10%"><?php echo $counter; ?></td>
                            <?php
                                if($acc[ptype] == 'null'){
                                    ?>
                                    <td onclick="audioplay(<?php echo $ac[music]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="default.png" alt=""></td>
                               <?php
                                }else{
                                    ?>
                                         <td onclick="audioplay(<?php echo $ac[music]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="photo/<?php echo $ac[music]; ?>.<?php echo $acc[ptype]; ?>" alt=""></td>
                                    <?php
                                }
                            ?>
                            <td onclick="audioplay(<?php echo $ac[music]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><?php echo $acc[name]; ?></td>
                            <td onclick="audioplay(<?php echo $ac[music]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><a id="author"><?php echo $acc[author]; ?></a></td>
                            <?php
                                 $logget = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = '$ac[music]'");
                                 if(($acc = mysqli_fetch_assoc($logget))){
                                     
                                 
                            ?>
                            <td onclick="like_off(<?php echo $ac[music]; ?>)" width="10%">✔</td>
                            <?php
                                 }else{
                                     ?>
                                         <td width="10%">❤</td>
                                     <?php
                                 }
                            ?>
                        </tr>
                    <?php
                     
                }
                if($counter == 0){
                    echo '<p>У вас пока нет добавленных треков</p>';
                }
            ?>
        </table>
       
    </div>
    