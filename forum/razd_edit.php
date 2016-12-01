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


verh($thema['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | '.$razd['name'].'</div>';

 include '../system/funcs.php';
 
if(isset($_POST['submit'])){
 $name = secure($_POST['name']);

        	if(!$name){$cms->error = 'Пустое название!'; }
        	$uid = (isset($cms->us['id'])?$cms->us['id']:0);
		if(!isset($cms->error)){
		
							 DB::$dbs->query("UPDATE `forum_razd` set `name` = ? where `id` = ? limit 1",array($name,$razd['id']));

				header('location:/forum/');
			
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}

 
 echo '<div class="block_menu">
 <form action="/forum/razd'.$razd['id'].'/edit" method="post">
 Название раздела:<br><input name="name" value="'.$razd['name'].'"/><br>
 <input type="submit" name="submit" value="Сохранить"/>
	</form>
 
 </div></div>';

 echo '</div>';
 niz();
 ?>