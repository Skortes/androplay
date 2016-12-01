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

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($podrazd == 0){header('location:/forum');}

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($podrazd['razd']))));

if($cms->us['level'] < 8){header('location:/forum'); exit;}


verh('Подраздел '.$podrazd['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | '.$podrazd['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">Вы действительно хотите <b>удалить</b> подраздел?</div>
 <div class="news">
 В этом подразделе <b>'.DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `podrazd` = ?",array($podrazd['id'])).'</b> тем и <b>'.DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `podrazd` = ?",array($podrazd['id'])).'</b>
 сообщений. После удаления, восстановить раздел будет невозможно.<br>
 <a href="/forum/podrazd'.$podrazd['id'].'/delete?yes">Да, <b>удалить</b>!</a> | <a href="/forum/">Отмена</a><br><br>
 
 <small>Удаление раздела может занять несколько минут.</small></div>';

   if(isset($_GET['yes']))
   {
   
      
 
  $podrazd_posts = DB::$dbs->query("SELECT * FROM `forum_post` where `podrazd` = ? order by `id`",array($podrazd['id']));
   while($podrazd_post = $podrazd_posts -> fetch()){
   
  $podrazd_files = DB::$dbs->query("SELECT * FROM `forum_file` where `post` = ? order by `id`",array($podrazd_post['id']));
   while($podrazd_file = $podrazd_files -> fetch()){
   
   DB::$dbs->query("DELETE from `forum_file` where `id` = ? limit 1",array(abs(intval($podrazd_file['id']))));
   
   unlink('files/'.$podrazd_file['file']);
   
   }
      
   DB::$dbs->query("DELETE from `forum_post` where `id` = ? limit 1",array(abs(intval($podrazd_post['id']))));
   
   } 
   

  $podrazd_themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `razd` = ? order by `id`",array($podrazd['id']));
   while($podrazd_thema = $podrazd_themes -> fetch()){
   
   DB::$dbs->query("DELETE from `forum_rss` where `thema` = ? limit 1",array(abs(intval($podrazd_thema['id']))));

   DB::$dbs->query("DELETE from `forum_kto` where `id` = ? limit 1",array(abs(intval($podrazd_thema['id']))));

   DB::$dbs->query("DELETE from `forum_themes` where `id` = ? limit 1",array(abs(intval($podrazd_thema['id']))));
   
   }
   
   DB::$dbs->query("DELETE from `forum_podrazd` where `id` = ? limit 1",array(abs(intval($podrazd['id']))));

   header('location:/forum/'); exit;

  }

 echo '</div>';
 niz();
 ?>