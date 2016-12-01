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

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($razd == 0){header('location:/forum');}

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($razd['podrazd']))));

if($cms->us['level'] < 8){header('location:/forum'); exit;}


verh('Раздел '.$razd['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | '.$razd['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">Вы действительно хотите <b>удалить</b> раздел?</div>
 <div class="news">
 В этом разделе <b>'.DB::$dbs->querySingle("SELECT count(id) from `forum_podrazd` where `razd` = ?",array($razd['id'])).'</b> подразделов, <b>'.DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `razd` = ?",array($razd['id'])).'</b> тем и <b>'.DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `razd` = ?",array($razd['id'])).'</b>
 сообщений. После удаления, восстановить раздел будет невозможно.<br>
 <a href="/forum/razd'.$razd['id'].'/delete?yes">Да, <b>удалить</b>!</a> | <a href="/forum/">Отмена</a><br><br>
 
 <small>Удаление раздела может занять несколько минут.</small></div>';

   if(isset($_GET['yes']))
   {
   
      
 
  $razd_posts = DB::$dbs->query("SELECT * FROM `forum_post` where `razd` = ? order by `id`",array($razd['id']));
   while($razd_post = $razd_posts -> fetch()){
   
  $razd_files = DB::$dbs->query("SELECT * FROM `forum_file` where `post` = ? order by `id`",array($razd_post['id']));
   while($razd_file = $razd_files -> fetch()){
   
   DB::$dbs->query("DELETE from `forum_file` where `id` = ? limit 1",array(abs(intval($razd_file['id']))));
   
   unlink('files/'.$razd_file['file']);
   
   }
      
   DB::$dbs->query("DELETE from `forum_post` where `id` = ? limit 1",array(abs(intval($razd_post['id']))));
   
   } 
   

  $razd_themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `razd` = ? order by `id`",array($razd['id']));
   while($razd_thema = $razd_themes -> fetch()){
   
   DB::$dbs->query("DELETE from `forum_rss` where `thema` = ? limit 1",array(abs(intval($razd_thema['id']))));

   DB::$dbs->query("DELETE from `forum_kto` where `id` = ? limit 1",array(abs(intval($razd_thema['id']))));

   DB::$dbs->query("DELETE from `forum_themes` where `id` = ? limit 1",array(abs(intval($razd_thema['id']))));
   
   }

  $razd_podrazds = DB::$dbs->query("SELECT * FROM `forum_podrazd` where `razd` = ? order by `id`",array($razd['id']));
   while($razd_podrazd = $razd_podrazds -> fetch()){
   
   DB::$dbs->query("DELETE from `forum_podrazd` where `id` = ? limit 1",array(abs(intval($razd_podrazd['id']))));

   }

   DB::$dbs->query("DELETE from `forum_razd` where `id` = ? limit 1",array(abs(intval($razd['id']))));

   header('location:/forum/'); exit;

  }


 echo '</div>';
 niz();
 ?>