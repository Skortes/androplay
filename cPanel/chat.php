<?php
$title ='Управление комнатами чата';
include_once '../inc/head.php';

include '../inc/funcs.php';
if(!isset($cms->us['id']) OR $cms->us['level']<=7){ header('location:/'); }

   if(isset($_GET['editr'])){
 $id = $func->num($_GET['editr']);
   $inf = DB::$dbs->queryFetch("SELECT * from `chat_rooms` where `id` = ? limit 1",array($id));
   if(!$inf['name']){echo'<div class="main">Ошибка.</div>';}else{
echo'<div class="menu"><form action="?raz&editr='.$id.'&ok" method="post">Название: <input type="text" name="name" value="'.$inf['name'].'"/> Описание: <input type="text" name="opis" value="'.$inf['opis'].'"/> Топик: <input type="text" name="topic" value="'.$inf['topic'].'"/><input type="submit" value="Сохранить"/></form></div>';
 if(isset($_GET['ok'])){
 $name = secure($_POST['name']);
 $opis = secure($_POST['opis']);
 $topic = secure($_POST['topic']);
   if($name and $name!==$inf['name']){
   DB::$dbs->query("UPDATE `chat_rooms` set `name` = ? , `opis` = ? , `topic` = ? where `id` = ? limit 1",array($name,$opis,$topic,$id));
   echo'<div class="menu">Сохраненно.</div>'; header('refresh:1; url=/chat/');
   }else{echo'<div class="menu">Ошибка.</div>';}
 }
  }
                            }
$raz = DB::$dbs->query("SELECT `id`,`name` FROM `chat_rooms` ORDER BY `name` desc");
while($r = $raz -> fetch()){
	echo'<div class="menu"> <img src="/css/img/balloon.gif"> <a href="/chat/chat.php?room='.$r['id'].'"> '.$r['name'].'</a> [<a href="?raz&editr='.$r['id'].'">ред</a>][<a href="?raz&delr='.$r['id'].'">удал</a>]</div>';
}
			$addr = (isset($_GET['addr']) ? secure($_GET['addr']):NULL);
				if(isset($addr)){
					$name = secure($_POST['name']);
                    $opis = secure($_POST['opis']);
                    $topic = secure($_POST['topic']);
                    $pos = secure($_POST['pos']);
                    if (preg_match( '/[^0-9]/', $pos )){
                        $cms->error = 'Не верно указана позиция!!!';
                    }
						if(DB::$dbs->querySingle("SELECT count(id) from `chat_rooms` where `name` = ?",array($name))>=1){
   						$cms->error = 'Комната с таким именем уже существует!';
						}
						if(!$name){$cms->error = 'Не введено имя комнаты!'; }
						if(!isset($cms->error)){DB::$dbs->query("INSERT INTO `chat_rooms` (`name`,`opis`,`topic`,`pos`) VALUES (?,?,?,?)",array($name,$opis,$topic,$pos));
							echo'<div class="main">Добавлено</div>'; header('refresh:1; url=/chat/'); }else{ echo'<div class="main">'.$cms->error.'</div>'; }
				}
				echo'<div class="main">';
				echo'<form action="?raz&addr" name="form" method="post" accept-charset="utf-8">';
				echo'<label for="text">Название комнаты:</label><br />';
				echo'<input type="text" name="name" /><br />';
				echo'<label for="text">Описание комнаты:</label><br />';
				echo'<input type="text" name="opis" /><br />';
                echo'<label for="text">Топик:</label><br />';
				echo'<input type="text" name="topic" /><br />';
                echo'<label for="text">Позиция:</label><br />';
				echo'<input type="text" name="pos" /><br />';
				echo'<input type="submit" name="submit" value="Добавить" />';
				echo'</form></div>';



if(isset($_GET['delr']) and $cms->us['level']>=9){
 DB::$dbs->query("DELETE from `chat_msg` where `room` = ?",array($func->num($_GET['delr'])));
	DB::$dbs->query("DELETE from `chat_rooms` where `id` = ? limit 1",array($func->num($_GET['delr'])));
   header('location:chat.php?raz');
}
else{
echo'<div class="menu"><a href="/cPanel"><-Админка</a></div>';
}
include '../inc/foot.php';
?>