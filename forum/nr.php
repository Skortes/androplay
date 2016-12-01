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

verh('Новый раздел');


echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | Новый раздел</div>';
 include '../system/funcs.php';
 
 
 if(isset($_POST['submit'])){

 $name = secure($_POST['name']);
        	if(!$name){$cms->error = 'Пустое название!'; }
        	
		if(!isset($cms->error)){
    
    
		DB::$dbs->query("INSERT INTO `forum_razd` (`name`) VALUES (?)",array($name));
		
				header('location:/forum');
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}

 echo '<div class="block_menu"><form action="/forum/nr" method="post">
 Название раздела:<br><input name="name"/><br>
<input type="submit" name="submit" value="Создать"/>
	</form></div>
	</div>';
 niz();
 ?>