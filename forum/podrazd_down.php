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

if($cms->us['level'] < 8){header('location:/forum/thema'.$thema['id']); exit;}

verh('Подраздел '.$podrazd['name'].'');

 include '../system/funcs.php';


							 DB::$dbs->query("UPDATE `forum_podrazd` set `pos` = `pos`-1 where `id` = ? limit 1",array($podrazd['id']));

				header('location:/forum/');



 niz();
 ?>