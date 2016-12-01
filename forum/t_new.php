<?
/* Разработчики KingCMS: MrDeath, PaRaDoX
   Офф. дизайнер: МАНЬЯК_ЧИКАТИЛО
   Офф. сайт: http://profiwm.ru 
   Офф. пример: http://kingcms.ru
   ICQ: 1503915
  Кидаем на развитие сюда R218687575965 */

include_once '../system/sys.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['forum']==0){header('location:../');}
if(!isset($cms->us['id'])){header('location:/error.php?user');}

verh('Новые темы');
 include '../system/funcs.php';


$num = 10;  
$posts = DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `time` > ?",array(time()-3600));
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 		

 echo '<div class="munus">
 <div class="zag">Всего тем: <b>'.$posts.'</b></div>';


 $themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `time` > ? order by `time` desc limit $start,$num",array((time()-3600)));
   while($ts = $themes -> fetch()){

    $tp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($ts['id']));

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($ts['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($ts['razd']))));

   echo '<div class="news">
   Раздел: <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a><br>
   Подраздел: <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a><br>
   Тема: <a href="/forum/thema'.$ts['id'].'">'.$ts['name'].'</a> ('.$tp.') <a href="/forum/thema'.$ts['id'].'/page'.ceil($tp/10).'">>></a><br>
   '.$func->uNick($ts['author']).'/'.$func->uNick($ts['last_user']).' ('.t($ts['last_time']).')
   </div>';

   }
   $func->page('/forum/t_new.php?');
 

 echo '</div>';
 niz();
 ?>