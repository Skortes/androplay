<?php 
$title = 'Гости онлайн?';
  
include_once 'inc/head.php';
include 'inc/funcs.php';
    $s = DB::$dbs->queryFetch("SELECT `on`,`who` FROM `set`");
	$num = $s['who'];
$posts = DB::$dbs->querySingle("SELECT count(id) from `us` where `last`>?",array(time()-$s['on']));

		echo'<div class="menu">Гости</div>';
		$gues = DB::$dbs->query("SELECT ip,soft,last from `guests` where `last`>? order by `last` desc",array(time()-$s['on']));
	while($gue = $gues->fetch()){
	echo'<div class="menu"><b>'.secure($gue['ip']).'</b> '.($cms->us['level']>=7?'['.secure($gue['soft']).']':NULL).' ['.t($gue['last']).']</div>';
	}
include_once 'inc/foot.php';
?>