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

  if($cms->us['level'] < $msgauthor['level'])
  {

  if($msg['user'] != $cms->us['id']){
  
header('location:/forum/thema'.$msg['thema']); exit;
  
  }

  }

 $thema = DB::$dbs->queryFetch("SELECT * FROM `forum_themes` where `id` = ? limit 1",array(abs(intval($msg['thema']))));
if($thems['status'] == 1 or $thema['status'] == 3){header('location:/forum/thema'.$msg['id'].'');}

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($thema['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($thema['razd']))));
if($cms->us['level'] < 6){header('location:/forum/thema'.$thema['id']); exit;}


verh($thema['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">
 <form action="/forum/edit_message'.$msg['id'].'" method="post">
 Сообщение:<br><textarea rows="3" name="message">'.$msg['message'].'</textarea><br>
 <input type="submit" name="submit" value="Сохранить"/>
	</form><br>
	<form action="/forum/edit_message'.$msg['id'].'" method="post" enctype="multipart/form-data">
  Файл:<br><input type="file" name="filename"/><br>
      <input type="submit" name="upload" value="Загрузить"/>
	</form>';
	
if(isset($_POST['submit'])){
 $message = secure($_POST['message']);

        	if(!$message){$cms->error = 'Пустое сообщение!'; }
		if(!isset($cms->error)){
		
		DB::$dbs->query("INSERT INTO `forum_post_edit` (`post`,`user`,`message`,`time`) VALUES (?,?,?,?)",array($msg['id'],$cms->us['id'],$msg['message'],time()));

							 DB::$dbs->query("UPDATE `forum_post` set `message` = ? where `id` = ? limit 1",array($message,$msg['id']));


        $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 

				header('location:/forum/thema'.$thema['id'].'/page'.ceil($cp/10));
			
				
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}


if(isset($_POST['upload']))
{

if(!file_exists($_FILES['filename']['tmp_name'])) $cms->error = 'Выберите файл!';
if($_FILES['filename']['size'] != 0 and $_FILES['filename']['size'] > 1024000)$cms->error = 'Слишком большой файл!';

$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', '7z', 'txt', 'mp3', 'avi', 'mp4', '3gp' );
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], "." )+1);  
if(!in_array($upfiletype,$filetype)) $cms->error = 'Вы пытаетесь загрузить недопустимый формат файла...';


		if(!isset($cms->error)){
    $fgn = time().'_'.rand(1234,5678).'.'.$upfiletype;
    move_uploaded_file($_FILES['filename']['tmp_name'], "files/".$fgn."");
		DB::$dbs->query("INSERT INTO `forum_file` (`post`,`file`) VALUES (?,?)",array($msg['id'],$fgn));
header('location:/forum/edit_message'.$msg['id'].'');
								
}else{ echo'<div class="err">'.$cms->error.'</div>'; }}


$del_file = secure($_GET['del_file']);
if(isset($del_file)){

$file = DB::$dbs->queryFetch("SELECT * FROM `forum_file` where `id` = ? limit 1",array(abs(intval($del_file))));



DB::$dbs->query("delete from `forum_file` where `id` = ?",array(abs(intval($del_file))));
unlink('files/'.$file['file']);


}

$files = DB::$dbs->querySingle("SELECT count(id) from `forum_file` where `post` = ?",array($msg['id']));
if($files!=0)
{

  echo '<br>Прикрепленные файлы:<br>';

 $pfiles = DB::$dbs->query("SELECT * FROM `forum_file` where `post` = '".$msg['id']."' order by `id`");
   while($pfs = $pfiles -> fetch()){
   
   echo '[<a href="/forum/edit_message'.$msg['id'].'/del_file'.$pfs['id'].'">x</a>] <b><a href="/forum/files/'.$pfs['file'].'">'.$pfs['file'].'</a> ('.round(filesize('files/'.$pfs['file'].'')/1024).' кб)</b><br>';
   
   }
   
   }

  echo '</div></div>';

 echo '</div>';
 niz();
 ?>