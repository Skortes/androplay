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

 $thema = DB::$dbs->queryFetch("SELECT * FROM `forum_themes` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($thema == 0){header('location:/forum');}

verh('Кто в теме "'.$thema['name'].'"?');

echo '<div class="munus"><div class="zag">В теме "'.$thema['name'].'" '.DB::$dbs->querySingle("SELECT count(id) from `forum_kto` where `thema` = ? and `time` > ?",array($thema['id'],time()-120)).' человек</div>';

 include '../system/funcs.php';


$num = 10;  
$posts = DB::$dbs->querySingle("SELECT count(id) from `forum_kto` where `thema` = ? and `time` > ?",array($thema['id'],time()-120));
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 		


    echo '<div class="news">';
 $kto = DB::$dbs->query("SELECT * FROM `forum_kto` where `thema` = ? and `time` > ? order by `time` desc limit $start,$num",array($thema['id'],(time()-120)));
   while($k = $kto -> fetch()){

   echo $func->uNick($k['user']).', ';

   }
   echo '</div>';
   $func->page('/forum/thema'.$thema['id'].'/who?');
 

 echo '</div>';
 niz();
 ?>