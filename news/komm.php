<?
$title = 'Новости';
  
include_once '../inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['novosti']==1){
 $new = DB::$dbs->queryFetch("SELECT name from `news` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
   if(empty($new['name'])){ header('location:/');  exit;}
	echo '<div class="menu1"><a href="/news"><-К новостям</a> | <a href="?id='.abs(intval($_GET['id'])).'">Обновить</a></div>';
	if(isset($cms->us['id'])){
	 echo'<div class="menu1">
	 <form action="?id='.abs(intval($_GET['id'])).'&add" method="post">
	 Сообщение: <a href="../faq.php?go=smile">(смайлы)</a><br/>
	 <textarea name="text"></textarea><br/>
	 <input type="submit" value="Написать"/></form></div>';
	  if(isset($_GET['add'])){
	  $text = secure($_POST['text']);
	  if(empty($text)){$cms->error='Вы не ввели текст сообщения!';}
	  if(DB::$dbs->querySingle("SELECT count(id) from `news_komm` where `id_news` = ? and `us` = ? and `text` = ?",array(abs(intval($_GET['id'])),$cms->us['id'],$text))>=1){ $cms->error = 'Вы уже писали подобное...'; }
	                         if(!isset($cms->error)){ DB::$dbs->query("INSERT INTO `news_komm` set `id_news` = ?, `us` = ?, `text` = ?, `t` = ?",array(abs(intval($_GET['id'])),$cms->us['id'],$text,time())); header('location:/news/komm.php?id='.abs(intval($_GET['id'])).''); }else{ echo'<div class="menu1"><font color="red"><b>'.$cms->error.'</b></font></div>'; } 
							 }
	                        }
	 $num = 10;  
  $posts = DB::$dbs->querySingle("SELECT count(id) FROM `news_komm` where `id_news` = ?",array(abs(intval($_GET['id'])))); 
   if($posts == 0){ echo'<div class="menu1">Комментариев пока нет!</div>'; 
   include_once '../inc/foot.php';
    exit; }
  $total = intval(($posts - 1) / $num) + 1;  
  $page = abs(intval($_GET['page']));  
  if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
     $start = $page * $num - $num; 		
	  $komms = DB::$dbs->query("SELECT * FROM `news_komm` where `id_news` = ? order by `id` desc limit $start,$num;",array(abs(intval($_GET['id']))));
	    include '../inc/funcs.php';
   while($komm = $komms -> fetch()){
    echo '<div class="menu1">'.$func->uNick($komm['us']).': '.$func->text($komm['text']).' <small>('.t($komm['t']).')</small> '.($cms->us['level']>=7?'[<a href="?id='.$func->num($_GET['id']).'&delkomm='.$komm['id'].'">x</a>]':NULL).'</div>';
   }
    if(isset($_GET['delkomm']) and $cms->us['level']>=7){DB::$dbs->query("DELETE from `news_komm` where `id` = ? limit 1",array($func->num($_GET['delkomm']))); header('location:/news/komm.php?id='.$func->num($_GET['id']).''); }
   $func->page('?id='.abs(intval($_GET['id'])).'&');
}else{
header('location:../index.php');}

include_once '../inc/foot.php';
	
?>