<?
$title = 'Фотография';
  
include_once '../inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['galer']==0){header('location:../');}

 $photo = DB::$dbs->queryFetch("SELECT * FROM `photos` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
 if(empty($photo['id']) or !isset($cms->us['id'])){ header('location:/photos');}
 include '../inc/funcs.php';
 echo'<div class="main"><img src="/photos/'.$photo['path'].'" alt="*" width="150" height="150" /><br/>Загрузил: '.$func->uNick($photo['us']).' ['.t($photo['date']).'] '.(!$photo['opis']?NULL:'<br/><b>'.$photo['opis'].'</b>').'</div>';
 echo'<div class="menu"><img src="/css/img/007.png" alt="*" align="middle" /> <a href="'.$photo['path'].'">Скачать оригинал</a></div>';
 if($cms->us['id'] == $photo['us'] or $cms->us['level']==10){
 echo'<div class="menu"><img src="/css/img/005.png" alt="*" align="middle" /> <a href="?id='.$photo['id'].'&ank">Сделать анкетной</a></div>';
 echo'<div class="menu"><img src="/css/img/009.png" alt="*" align="middle" /> <a href="?id='.$photo['id'].'&opis">Изменить описание</a> (max 250)</div>';
 echo'<div class="menu"><img src="/css/img/004.png" alt="*" align="middle" /> <a href="?id='.$photo['id'].'&del">Удалить изображение</a></div>';
 if(isset($_GET['opis'])){
 echo'<div class="menu"><form action="?id='.$photo['id'].'&opis&ok" method="post"><input type="text" name="opis" value="'.$photo['opis'].'"/><input type="submit" value="Сохранить"/></form></div>';
 if(isset($_GET['ok'])){
 DB::$dbs->query("UPDATE `photos` set `opis` = ? where `id` = ? limit 1",array(secure($_POST['opis']),$photo['id']));
  header('location:/photos/photo.php?id='.$photo['id'].'');
 }
 }
 if(isset($_GET['del'])){
 echo'<div class="menu">Вы уверены что хотите удалить это изображение? (<a href="?id='.$photo['id'].'&del&da">Да</a>/<a href="?id='.$photo['id'].'">Нет</a>)</div>';
 if(isset($_GET['da'])){
 unlink('../photos/'.$photo['path']);
 DB::$dbs->query("DELETE FROM `photos` where `id` = ? limit 1",array($photo['id']));
  header('location:/photos');
 }
 }
 if(isset($_GET['ank'])){
 DB::$dbs->query("UPDATE `photos` set `osn` = ? where `us` = ? and `osn` = ? limit 1",array(0,$cms->us['id'],1));
 DB::$dbs->query("UPDATE `photos` set `osn` = ? where `id` = ? limit 1",array(1,$photo['id']));
 header('location:/photos/photo.php?id='.$photo['id'].'');
 }
 }

 echo'<div class="main"><img src="/css/img/039.png" alt="*" align="middle" /> Комментарии</div>';
 echo'<div class="menu"><form action="?id='.$photo['id'].'&komm" method="post">Коммент:</br> <input type="text" name="komm"/>
</br>
 <input type="submit" value="Написать"/></form></div>';
 if(isset($_GET['komm'])){
 $komm = secure($_POST['komm']);
 if(empty($_POST['komm'])){
echo'<div class="main">Вы не ввели текст сообщения!</div>';
 }else{DB::$dbs->query("INSERT INTO `photo_komm` set `us` = ?, `photo` = ?, `text` = ?, `t` = ?",array($cms->us['id'],$photo['id'],$komm,time()));
if($cms->us['id']!==$photo['us']){ $val = $func->uNick($cms->us['id']).' оставил'.($cms->us['sex']=='Муж'?NULL:'а').' комментарий к вашей [url=/photos/photo.php?id='.$photo['id'].']фотографии[/url].';
       DB::$dbs->query("INSERT INTO `action` set `us` = ?, `value` = ?, `t` = ?, `see` = ?",array($photo['us'],$val,time(),1)); } header('location:/photos/photo.php?id='.$photo['id'].'');}
 }
   $num = 5;
$posts = DB::$dbs->querySingle("SELECT count(id) from `photo_komm` where `photo` = ?",array($photo['id']));;
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
  $komms = DB::$dbs->query("SELECT * FROM `photo_komm` where `photo` = ? order by `id` desc limit $start,$num",array($photo['id']));
    while($kom = $komms->fetch()){
	echo '<div class="menu">'.$func->uNick($kom['us']).' ['.t($kom['t']).']'.($cms->us['level']>=7?'[<a href="?id='.$photo['id'].'&delk='.$kom['id'].'">x</a>]':NULL).'<br/>
	'.$func->text($kom['text']).'</div>';
	}
	if(isset($_GET['delk']) and $cms->us['level']>=7){ DB::$dbs->query("DELETE from `photo_komm` where `id` = ? limit 1",array(abs(intval($_GET['delk'])))); header('location:/photos/photo.php?id='.$photo['id'].''); }
	$func->page('?id='.$photo['id'].'&');
include_once '../inc/foot.php';
?>