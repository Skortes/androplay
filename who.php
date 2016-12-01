<?php 
$title = 'Кто онлайн?';
  
include_once 'inc/head.php';
include 'inc/funcs.php';
	echo'<div class="menu">Обитатели</div>';
    $s = DB::$dbs->queryFetch("SELECT `on`,`who` FROM `set`");
	$num = $s['who'];
$posts = DB::$dbs->querySingle("SELECT count(id) from `us` where `last`>?",array(time()-$s['on']));
if($posts==0){echo'<div class="menu1">Пользователей онлайн нет...</div>';}else{
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
	$regs = DB::$dbs->query("SELECT id,last from `us` where `last`>? order by `last` desc limit $start,$num",array(time()-$s['on']));
	while($reg = $regs->fetch()){
	echo'<div class="menu">'.$func->uNick($reg['id']).' ['.t($reg['last']).']</div>';
	}
	$func->page('?');
	}

include_once 'inc/foot.php';
?>