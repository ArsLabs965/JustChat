<?php
session_start();
$connection = mysqli_connect('127.0.0.1', 'root', 'database0422!', 'justchat');
if($_SESSION[user] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    exit();
}
$err = 0;
$isphoto = 0;
if(isset($_POST[btn])){
    $arrayy = ["'",'"',"@", "/", "|", "\\", "*", ":", "<", ">"];
    $name = str_replace($arrayy, "", trim($_POST[name]));
    $author = str_replace($arrayy, "", trim($_POST[author]));
    $type = str_replace($arrayy, "", trim($_POST[type]));
    if($name != "" AND $author != ""){
        if($name == $_POST[name] AND $author == $_POST[author]){
            if(isset($_FILES[music]) AND $_FILES[music][size] > 0 AND $_FILES[music][size] < 99999999){
                $name_s = $_FILES[music][name];
                $tmp_s = $_FILES[music][tmp_name];
                $size_s = $_FILES[music][size];
                $type_s = $_FILES[music][type];
list($au, $gavno_s) = explode('/', $type_s);
if($au == 'audio'){
    if(isset($_FILES[photo]) AND $_FILES[photo][size] > 0 AND $_FILES[photo][size] < 99999999){
        $name_p = $_FILES[photo][name];
        $tmp_p = $_FILES[photo][tmp_name];
        $size_p = $_FILES[photo][size];
        $type_p = $_FILES[photo][type];
list($au, $gavno_p) = explode('/', $type_p);
$isphoto = 1;
if($au == 'image'){
   
    
  
   
}else{
$err = 4;
}
    }
    if($isphoto == 0 || $err != 4){
        if($isphoto != 1){
            $gavno_p = 'null';
            
        }
        if($gavno_s == 'mpeg'){
            $gavno_s = 'mp3';
        }
        mysqli_query($connection, "INSERT INTO `music` (`name`, `author`, `type`, `mtype`, `ptype`) VALUES ('$name', '$author', '$type', '$gavno_s', '$gavno_p')");
    $logge = mysqli_query($connection, "SELECT * FROM `music` ORDER BY `id` DESC limit 1");
                if(($ac = mysqli_fetch_assoc($logge))){
                    
                    move_uploaded_file($tmp_s, "music/" . $ac[id] . "." . $gavno_s);
                    if($isphoto == 1){
                    move_uploaded_file($tmp_p, "photo/" . $ac[id] . "." . $gavno_p);
                    }
                    if($_POST['include'] == 'on'){
                    mysqli_query($connection, "INSERT INTO `music_like` (`login`, `music`) VALUES ('$_SESSION[user]', '$ac[id]')");
                    $logge = mysqli_query($connection, "SELECT * FROM `music_users` WHERE `login` = '$_SESSION[user]' AND `what` = '$type'");
                    if($type != 'default')
                    if(($ac = mysqli_fetch_assoc($logge))){
                        $newvalue = $ac[value] + 1;
                        mysqli_query($connection, "UPDATE `music_users` SET `value` = '$newvalue' WHERE `login` = '$_SESSION[user]' AND `what` = '$type'");
                    }else{
                        mysqli_query($connection, "INSERT INTO `music_users` (`login`, `what`) VALUES ('$_SESSION[user]', '$type')");
                    }
                    }
                    
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/sound/sound.php");
                }
    }
}else{
    $err = 3;
}
            }else{
                $err = 1;
            }
        }else{
            $err = 2;
        }
    }else{
        $err = 1;
    }
}
?>

    <div id="welcome">
        <p>Загрузить</p>
    </div>
    <div id="back">
        <a onclick="gomain()"><---</a>
    </div>
    <div id="padd">
        <?php
            if($err == 1){
                ?>
                    <a id="error">Вы не всё заполнили</a><br><br>
                <?
            }
            if($err == 2){
                ?>
                    <a id="error">Мы убрали спецсимволы</a><br><br>
                <?
            }
            if($err == 3){
                ?>
                    <a id="error">Не верный формат аудио файла</a><br><br>
                <?
            }
            if($err == 4){
                ?>
                    <a id="error">Не верный формат Изображения</a><br><br>
                <?
            }
        ?>
        <form method="POST" action="add.php" enctype="multipart/form-data">
            Выберите Аудиозапись которую хотите добавить в каталог Just Chat SOUND<br><br>
            <input name="music" type="file"><br><br>
            Выберите Фотографию, чтобы привязать её к композиции<br>(Можно оставить пустым)<br><br>
            <input name="photo" type="file"><br><br>
            Название вашей Аудиозаписи<br><br>
            <input name="name" value="<?php echo $name; ?>" placeholder="Начните вводить" type="text"><br><br>
            Имя Автора<br><br>
            <input name="author" value="<?php echo $author; ?>" placeholder="Начните вводить" type="text"><br><br>
            Выберите жанр<br><br>
            <select name="type">
    <option selected value="default">Не задано</option>
    <option value="Классика">Классика</option>
    <option value="Реп">Реп</option>
    <option value="Русский реп">Русский реп</option>
    <option value="Шансон">Шансон</option>
    <option value="Лирика">Лирика</option>
    <option value="Хип-хоп">Хип-хоп</option>
    <option value="Электро">Электро</option>
    <option value="Дабстеп">Дабстеп</option>
    <option value="Метал">Метал</option>
    <option value="Мешап">Мешап</option>
   </select><br><br><br>
            <input type="checkbox" name="include">Добавить в "Ваши треки"<br><br>
            <input type="submit" name="btn" value="ЗАГРУЗИТЬ">

        </form>
    </div>
    </div>
   