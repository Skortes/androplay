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

verh('Правила подраздела '.$podrazd['name'].'');


echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | '.$podrazd['name'].'</div>';
 include '../system/funcs.php';
echo '<div class="block_menu">'.(!empty($podrazd['rules']) ? $func->text($podrazd['rules']):'Правила для этого подраздела пока не установлены').'</div></div>';
niz();
?>