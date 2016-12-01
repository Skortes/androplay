<?php         
$title = 'Гостевая';
  
include_once 'inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['guest']==1){
include 'inc/funcs.php';
	if (isset($_GET['del']) && $cms->us['level']>=7){
	DB::$dbs->query("DELETE FROM `guest` WHERE `id`= ? limit 1",array($func->num($_GET['del'])));
			echo '<div class="menu">Удалено</div>';}

$add = (isset($_GET['add']) ? secure($_GET['add']):NULL);
if(isset($add)){
 if($_SESSION['flood']>time()-30){ $cms->error = 'Антифлуд! Подождите '.$func->flood('sec',30,$_SESSION['flood']).'.'; }
 $message = secure($_POST['message']);
   if(DB::$dbs->querySingle("SELECT count(id) from `guest` where `user_id` = ? and `message` = ?",array($cms->us['id'],$message))>=1){
   $cms->error = 'Вы уже писали подобное!';
}
        	if(!$message){$cms->error = 'Пустое сообщение!'; }
        	$uid = (isset($cms->us['id'])?$cms->us['id']:0);
		if(!isset($cms->error)){DB::$dbs->query("INSERT INTO `guest` (`message`,`time`,`user_id`) VALUES (?,?,?)",array($message,time(),$uid)); $_SESSION['flood'] = time();
				echo'<div class="menu">Добавлено</div>'; header('refresh:1; url=guest.php'); }else{ echo'<div class="err">'.$cms->error.'</div>'; }}
			if(isset($_GET['otv'])){
   $inf = DB::$dbs->queryFetch("SELECT user_id from `guest` where `id` = ? limit 1",array($func->num($_GET['otv'])));
    if($inf['user_id'] == 0){ $us['nick'] = 'Гость'; }else{
   $us = DB::$dbs->queryFetch("SELECT nick from `us` where `id` = ? limit 1",array($inf['user_id']));
    }
}			
include 'inc/bb.php';
echo'<div class="menu1">';
echo'	<form action="guest.php?add" name="form" method="post" accept-charset="utf-8">
	<label for="message">Сообщение</label>	<span class="small_text">
		(<a href="faq.php?go=smile">смайлы</a>/<a href="?">обн</a>)
	</span>
	<br />

	<textarea type="text" name="message" value="'.(isset($_GET['otv'])?'[b]'.$us['nick'].'[/b], ':null).'" /></textarea><br/><input type="submit" name="submit" value="Сказать" />
	</form></div>';
  
if($func->getCount('id','guest')==0) {echo '<div class="menu1">Нет сообщений...</div>'; }else{
$num = 10;
$posts = $func->getCount('id','guest');
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
$guest = DB::$dbs->query("SELECT * FROM `guest` ORDER BY `id` DESC limit $start,$num");
while($g = $guest -> fetch()){
echo'<div class="menu1">'.($g['user_id']==0?'<b>Гость</b>':$func->uNick($g['user_id'])).' <span class="small_text">['.t($g['time']).']</span><span class="small_text">';
echo (($cms->us['id']==$g['user_id'])?NULL:'[<a href="?otv='.$g['id'].'">отв</a>]').' '.($cms->us['level']>=7?'[<a href="?del='.$g['id'].'">удл.</a>]':NULL).'';
echo'</span><br />';
echo $func->text($g['message']).'</div>';}
$func->page('?');}
}else{header('location:/');}
include_once 'inc/foot.php';
 ?>