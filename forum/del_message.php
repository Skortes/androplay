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

 $msg = DB::$dbs->queryFetch("SELECT * FROM `forum_post` where `id` = ?limit 1",array(abs(intval($_GET['id']))));
  if($msg == 0){header('location:/forum/thema'.$msg['thema'].'');}

 $msgauthor = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ?limit 1",array(abs(intval($msg['user']))));

  if($msg['user'] != $cms->us['id'] && $cms->us['level'] < 8 && $cms->us['level'] > $msgauthor['level']){
  header('location:/forum/thema'.$msg['thema']);
  }

 $thema = DB::$dbs->queryFetch("SELECT * FROM `forum_themes` where `id` = ? limit 1",array(abs(intval($msg['thema']))));
if($thems['status'] == 1 or $thema['status'] == 3){header('location:/forum/thema'.$msg['id'].'');}

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($thema['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($thema['razd']))));

if($cms->us['level'] < 6){header('location:/forum/thema'.$thema['id']); exit;}

verh($thema['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">Вы действительно хотите <b>'.($msg['status'] == 1 ? 'восстановить' : 'удалить').'</b> сообщение?</div>
 <div class="news"><a href="/forum/del_message'.$msg['id'].'?yes">Да</a> | <a href="/forum/thema'.$thema['id'].'">Отмена</a></div>';


if(isset($_GET['yes'])){
		
							 DB::$dbs->query("UPDATE `forum_post` set `status` = '".($msg['status'] == 1 ? '0' : '1')."' where `id` = '".$msg['id']."' limit 1");

        $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 

				header('location:/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'');
			
				
				}


 echo '</div>';
 niz();
 ?>