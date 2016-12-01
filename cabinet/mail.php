<?
$title = 'Почта';
  
include_once '../inc/head.php';

  if(!$cms->us['id']){header('location:/');}
  	$num = 10;
$posts = DB::$dbs->querySingle("SELECT count(id) FROM `poch` where `us` = ?",array($cms->us['id']));
if($posts==0){echo'<div class="menu">Контактов нет...</div>';}else{
 include '../inc/funcs.php';
$total = intval(($posts - 1) / $num) + 1;
$page = $func->num($_GET['page']);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
 $mails = DB::$dbs->query("SELECT * from `poch` where `us` = ? order by `last` desc limit $start,$num",array($cms->us['id']));
 while($mail = $mails -> fetch()){
 echo'<div class="menu">'.$func->uNick($mail['kem']).' <a href="msg.php?u='.$mail['kem'].'"><img src="/css/img/go.png" alt="*" align="middle"/></a> [<b>'.DB::$dbs->querySingle("SELECT count(id) from `msg` where `us` = ? and `kem` = ? and `see` = ?",array($cms->us['id'],$mail['kem'],1)).'</b>/'.DB::$dbs->querySingle("SELECT count(id) from `msg` where `us` = ? and `kem` = ? or `kem` = ? and `us` = ?",array($cms->us['id'],$mail['kem'],$cms->us['id'],$mail['kem'])).'] ['.t($mail['last']).'] <a href="?del='.$mail['id'].'"><img src="/css/img/028.png" alt="*" align="middle"/></a></div>';
 }
 if(isset($_GET['del'])){
 $inf = DB::$dbs->queryFetch("SELECT us,kem from `poch` where `id` = ? limit 1",array(abs(intval($_GET['del']))));
   if($inf['us'] == $cms->us['id']){ DB::$dbs->query("DELETE from `poch` where `id` = ? limit 1",array(abs(intval($_GET['del'])))); header('location:/cabinet/mail.php'); }else{echo'<div class="main">Не прокатит :-)</div>';}
 }
 $func->page('?');
 }
 
include_once '../inc/foot.php';
?>