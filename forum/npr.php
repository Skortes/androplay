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

verh('Раздел '.$razd['name']);


echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | '.$razd['name'].' | Новый подраздел</div>';
 include '../system/funcs.php';
 
 
 if(isset($_POST['submit'])){

 $name = secure($_POST['name']);
 $rules = secure($_POST['rules']);

        	if(!$name){$cms->error = 'Пустое название!'; }
        	if(!$rules){$cms->error = 'Пустое описание правил!'; }
		if(!isset($cms->error)){
    
    
		DB::$dbs->query("INSERT INTO `forum_podrazd` (`razd`,`name`,`rules`) VALUES (?,?,?)",array($razd['id'],$name,$rules));
		
				header('location:/forum/razd'.$razd['id']);
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}

 echo '<div class="block_menu"><form action="/forum/razd'.$razd['id'].'/npr" method="post">
 Название подраздела:<br><input name="name"/><br>
 Правила подраздела:<br><textarea name="rules" style="width:99%;" rows="5"></textarea>
<input type="submit" name="submit" value="Создать"/>
	</form></div>
	</div>';
 niz();
 ?>