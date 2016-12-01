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

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($thema['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($thema['razd']))));

if($cms->us['level'] < 6){header('location:/forum/thema'.$thema['id']); exit;}


verh($thema['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">Вы действительно хотите <b>'.($thema['status'] != 2 ? 'закрепить' : 'открепить').'</b> тему?</div>
 <div class="news"><a href="/forum/thema'.$thema['id'].'/zak?yes">Да</a> | <a href="/forum/thema'.$thema['id'].'">Отмена</a></div>';

   if(isset($_GET['yes']))
   {
  
DB::$dbs->query("UPDATE `forum_themes` set `status` = ? where `id` = ? limit 1",array(($thema['status'] != 2 ? '2' : '0'),$thema['id']));

          $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 

header('location:/forum/thema'.$thema['id'].'/page'.ceil($cp/10)); exit;


  }


 echo '</div>';
 niz();
 ?>