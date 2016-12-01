<?
$title = 'Новости';
  
include_once '../inc/head.php';

$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['novosti']==1){
 include '../inc/funcs.php';
 if($func->getCount('id','news')==0){ echo '<div class="menu1">Новостей пока что нет...</div>'; }else{
                                                                                 if(isset($cms->us['id']) and isset($_GET['vote'])){
		if(DB::$dbs->querySingle("SELECT count(id_news) from `news_vote` where `id_us` = ? and `id_news` = ?",array($cms->us['id'],abs(intval($_GET['vote']))))==0 and DB::$dbs->querySingle("SELECT count(id) from `news` where `id` = ?",array(abs(intval($_GET['vote']))))==1){
			DB::$dbs->query("INSERT INTO `news_vote` set `id_us` = ?, `id_news` = ?",array($cms->us['id'],abs(intval($_GET['vote'])))); echo '<div class="menu1">Ваш голос учтён!</div>'; header('refresh:1; url=/news');
				}else{ echo'<div class="menu1">Ошибка!</div>'; }
								                                     
															 }
															 
$num = 10;  
$posts = $func->getCount('id','news');  
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 		
 $news = DB::$dbs->query("SELECT * FROM `news` order by `id` desc limit $start,$num");
   while($n = $news -> fetch()){
 
  echo'<div class="menu"><b>'.$n['name'].'</b> <small>('.t($n['t']).')</small><br/>'.$func->text($n['text']).'<br/>
  Разместил: '.$func->uNick($n['us']).'<br/>
  <a href="/news/index.php?vote='.$n['id'].'"><img src="/css/img/yes.png" alt="+" /></a> '.DB::$dbs->querySingle("SELECT count(id_us) from `news_vote` where `id_news` = ?",array($n['id'])).' <a href="/news/komm.php?id='.$n['id'].'"><img src="/css/img/comm.png" alt="+" /></a> '.DB::$dbs->querySingle("SELECT count(id) from `news_komm` where `id_news` = ?",array($n['id'])).'</div>';
   }
   $func->page('?');
                                                                               }
}else{header('location:/index.php');}
								
include'../inc/foot.php';
 ?>