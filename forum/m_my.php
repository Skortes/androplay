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

verh('Мои сообщения');
 include '../system/funcs.php';


$num = 10;  
$posts = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `user` = ?",array($cms->us['id']));
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 		

 echo '<div class="munus">
 <div class="zag">Всего сообщений: <b>'.$posts.'</b></div>';


 $post = DB::$dbs->query("SELECT * FROM `forum_post` where `user` = ? order by `time` desc limit $start,$num",array($cms->us['id']));
   while($p = $post -> fetch()){

    $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($p['thema']));

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($p['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($p['razd']))));

 $thema = DB::$dbs->queryFetch("SELECT * FROM `forum_themes` where `id` = ? limit 1",array(abs(intval($p['thema']))));

   echo '<div class="news">
   Раздел: <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a><br>
   Подраздел: <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a><br>
   Тема: <a href="/forum/thema'.$thema['id'].'">'.$thema['name'].'</a> ('.$cp.') <a href="/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'">>></a><br>
   Сообщение: '.$func->text($p['message']).' ('.t($p['time']).')<br>
   </div>';

   }
   $func->page('/forum/m_my.php?');
 

 echo '</div>';
 niz();
 ?>