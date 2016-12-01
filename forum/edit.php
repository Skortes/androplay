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

verh('Статус темы "'.$thema['name'].'"?');

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';
 
if(isset($_POST['submit'])){
 $name = secure($_POST['name']);

        	if(!$name){$cms->error = 'Пустое сообщение!'; }
        	$uid = (isset($cms->us['id'])?$cms->us['id']:0);
		if(!isset($cms->error)){
		
							 DB::$dbs->query("UPDATE `forum_themes` set `name` = ? where `id` = ? limit 1",array($name,$thema['id']));

        $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 

				header('location:/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'');
			
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}

 
 echo '<div class="block_menu">
 <form action="/forum/thema'.$thema['id'].'/edit" method="post">
 Название темы:<br><input name="name" value="'.$thema['name'].'"/><br>
 <input type="submit" name="submit" value="Сохранить"/>
	</form>
 
 </div></div>';

 echo '</div>';
 niz();
 ?>