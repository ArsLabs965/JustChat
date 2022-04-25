<?php
    session_start();
    
    if($_SESSION[user] == NULL){
        exit();
    }
    $connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
    $arrayy = ["'",'"',"@", "/", "|", "\\", "*", ":", "<", ">"];
    $qu = str_replace($arrayy, "", trim($_GET[serch]));
    if($qu == ""){
        exit();
    }
    
    $counter = 0;
    $logge = mysqli_query($connection, "SELECT * FROM `music` WHERE `name` like '%" . $qu . "%'");
                while(($acc = mysqli_fetch_assoc($logge))){
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
                            $TTL = $acc[id];
                                 $logget = mysqli_query($connection, "SELECT * FROM `music_like` WHERE `login` = '$_SESSION[user]' AND `music` = '$acc[id]'");
                                 if(($acc = mysqli_fetch_assoc($logget))){
                                     
                                 
                            ?>
                            <td onclick="like_off(<?php echo $TTL; ?>)" width="10%">✔</td>
                            <?php
                                 }else{
                                     ?>
                                         <td onclick="like_on(<?php echo $TTL; ?>)" width="10%">❤</td>
                                     <?php
                                 }
                            ?>
                        </tr>
                    <?php
                    
                }
                if($counter == 0){
                    ?>
                        <p>К сожалению по вашему запросу ничего не найдено(</p>
                    <?php
                }
?>