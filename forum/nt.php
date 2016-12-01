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

verh('Подраздел '.$podrazd['name'].'');


echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | '.$podrazd['name'].' | Новая тема</div>';
 include '../system/funcs.php';
 
 
 if(isset($_POST['submit'])){

 if($_SESSION['flood']>time()-30){ $cms->error = 'Антифлуд! Подождите '.$func->flood('sec',30,$_SESSION['flood']).'.'; }
 $name = secure($_POST['name']);
 $message = secure($_POST['message']);
        	if(!$name){$cms->error = 'Пустое название!'; }
        	if(!$message){$cms->error = 'Пустое сообщение!'; }
        	$uid = (isset($cms->us['id'])?$cms->us['id']:0);
        	
		if(!isset($cms->error)){
    
    
		DB::$dbs->query("INSERT INTO `forum_themes` (`razd`,`podrazd`,`name`,`author`,`time`,`last_time`,`last_user`) VALUES (?,?,?,?,?,?,?)",array($podrazd['razd'],$podrazd['id'],$name,$uid,time(),time(),$uid));
		
				$thema_id = DB::$dbs->lastInsertId();

		DB::$dbs->query("INSERT INTO `forum_post` (`razd`,`podrazd`,`thema`,`user`,`message`,`time`) VALUES (?,?,?,?,?,?)",array($podrazd['razd'],$podrazd['id'],$thema_id,$uid,$message,time()));
DB::$dbs->query("INSERT INTO `forum_post` (`razd`,`podrazd`,`thema`,`user`,`message`,`time`) VALUES (?,?,?,?,?,?)",array($podrazd['razd'],$podrazd['id'],$thema_id,1,'Тема успешно создана!За нарушений правил Вы будите забанены!',time()));
        $_SESSION['flood'] = time();			
				
				header('location:/forum/thema'.$thema_id.'');
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}

 echo '<div class="block_menu"><form action="/forum/nt'.$podrazd['id'].'" method="post">
 Название темы:<br><input name="name"/><br>
      Сообщение:<br><textarea rows="3" name="message"></textarea>
<br><input type="submit" name="submit" value="Создать"/>
	</form></div>
	</div>';
 niz();
 ?>