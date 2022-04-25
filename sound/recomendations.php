<?php
session_start();
if($_SESSION[user] == NULL){
    exit();
}
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
$logget = mysqli_query($connection, "SELECT COUNT(`what`) as colvo FROM `music_users` WHERE `login` = '$_SESSION[user]'");
        if(($acf = mysqli_fetch_assoc($logget))){
          if ($acf[colvo] > 2){
            $logget = mysqli_query($connection, "SELECT * FROM `music_users` where `login` = '$_SESSION[user]' order by `value` DESC limit 5");
              while(($acc = mysqli_fetch_assoc($logget))){
                
                  ?>
<div id="mjss">
                    <?php
                if($acc[what] == "Классика"){
                    
                    echo '🍷Подумайте о высоком';
                }
                if($acc[what] == "Реп"){
                    
                    echo '😎Тексты со смыслом';
                }
                if($acc[what] == "Русский реп"){
                    
                    echo '⬜🟦🟥Русский реп';
                }
                if($acc[what] == "Шансон"){
                    
                    echo '👮‍♂️Блатное';
                }
                if($acc[what] == "Лирика"){
                    
                    echo '😍Ангельские голоса';
                }
                if($acc[what] == "Хип-хоп"){
                    
                    echo '🔥Ловите ритм';
                }
                if($acc[what] == "Электро"){
                    
                    echo '⚡Высокое напряжение';
                }
                if($acc[what] == "Дабстеп"){
                    
                    echo '❌Полная жесть!❌';
                }
                if($acc[what] == "Мешап"){
                    
                    echo '😋Коля Коля';
                }
                if($acc[what] == "Метал"){
                    
                    echo '🎸Гитару в руки!';
                }
                
                ?>
                </div>
                <table>
                                    <?php
                                    $counter = 0;
                      $loggete = mysqli_query($connection, "SELECT * FROM `music` where `type` = '$acc[what]' order by rand() limit 5");
                      while(($acc = mysqli_fetch_assoc($loggete))){
                        $counter++;
                ?>
                    <tr width="100%">
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="10%"><?php echo $counter; ?></td>
                        <?php
                            if($acc[ptype] == 'null'){
                                ?>
                                <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="default.png" alt=""></td>
                           <?php
                            }else{
                                ?>
                                     <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="photo/<?php echo $acc[id]; ?>.<?php echo $acc[ptype]; ?>" alt=""></td>
                                <?php
                            }
                        ?>
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><?php echo $acc[name]; ?></td>
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><a id="author"><?php echo $acc[author]; ?></a></td>
                        <?php
                             $logge = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = '$acc[id];'");
                             if(($accd = mysqli_fetch_assoc($logge))){
                                 
                             
                        ?>
                        <td onclick="like_off(<?php echo $acc[id]; ?>)" width="10%">✔</td>
                        <?php
                             }else{
                                 ?>
                                     <td onclick="like_on(<?php echo $acc[id]; ?>)" width="10%">❤</td>
                                 <?php
                             }
                        ?>
                    </tr>
                <?php
                      }
                      ?>
</table>
                      <?php
              }
          }else{
              ?>
                <div id="mjss">
                    👀Узнаем о вас больше
                </div>
                <div style="text-align: left; padding: 10px; font-size: 15px; color: Grey; ">
                Сервис учитывает ваши предпочтения в музыке и выдаёт то, что вам может понравится!<br>
                Но пока у вас слишком мало добавленных треков, чтобы мы узнали что вам нравится.
                </div>
                <div id="mjss">
                    👍Возможно вы некоторые знаете!
                </div>
<table>
              <?php
              $counter = 0;
              $logget = mysqli_query($connection, "SELECT * FROM `music` order by rand() limit 20");
              while(($acc = mysqli_fetch_assoc($logget))){
                $counter++;
                ?>
                    <tr width="100%">
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="10%"><?php echo $counter; ?></td>
                        <?php
                            if($acc[ptype] == 'null'){
                                ?>
                                <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="default.png" alt=""></td>
                           <?php
                            }else{
                                ?>
                                     <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="20%"><img width="50px" src="photo/<?php echo $acc[id]; ?>.<?php echo $acc[ptype]; ?>" alt=""></td>
                                <?php
                            }
                        ?>
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><?php echo $acc[name]; ?></td>
                        <td onclick="audioplay(<?php echo $acc[id]; ?>, '<?php echo $acc[mtype]; ?>', '<?php echo $acc[name]; ?>')" width="40%"><a id="author"><?php echo $acc[author]; ?></a></td>
                        <?php
                             $logge = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = '$acc[id];'");
                             if(($accd = mysqli_fetch_assoc($logge))){
                                 
                             
                        ?>
                        <td onclick="like_off(<?php echo $acc[id]; ?>)" width="10%">✔</td>
                        <?php
                             }else{
                                 ?>
                                     <td onclick="like_on(<?php echo $acc[id]; ?>)" width="10%">❤</td>
                                 <?php
                             }
                        ?>
                    </tr>
                <?php
              }
              ?>
              </table>
              <?php
          }
        }
?>