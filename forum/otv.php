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

 $ous = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ? limit 1",array(abs(intval($_GET['otv']))));
  if($ous == 0){header('location:/forum/thema'.$thema['id']);}

verh($thema['name']);
 include '../system/funcs.php';

 echo '<div class="munus">';


  if($thema['status'] == 3)
  {
  
  echo '<div class="zag">Эта тема была удалена!</div>';
  
  }
  else
  {

  if($thema['status'] == 1){header('location:/forum/thema'.$thema['id']);}

if(isset($_POST['submit'])){

 if($_SESSION['flood']>time()-5){ $cms->error = 'Антифлуд! Подождите '.$func->flood('sec',5,$_SESSION['flood']).'.'; }
 $message = secure($_POST['message']);
   if(DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `user` = ? and `message` = ?",array($cms->us['id'],$message))>=1){
   $cms->error = 'Вы уже писали подобное!';
}
        	if(!$message){$cms->error = 'Пустое сообщение!'; }
        	$uid = (isset($cms->us['id'])?$cms->us['id']:0);

  if(@file_exists($_FILES['filename']['tmp_name']))
  {
  
  if($_FILES['filename']['size'] != 0 and $_FILES['filename']['size'] > 1024000)$cms->error = 'Слишком большой файл!';
  
  $filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', '7z', 'txt', 'mp3', 'avi', 'mp4', '3gp' );
  $upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], "." )+1);  
  
  if(!in_array($upfiletype,$filetype)) $cms->error = 'Вы пытаетесь загрузить недопустимый формат файла...';
  
  }


		if(!isset($cms->error)){

        $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 
		
		$_message = '[b]'.$ous['nick'].'[/b], '.$message;
		DB::$dbs->query("INSERT INTO `forum_post` (`razd`,`podrazd`,`thema`,`user`,`message`,`time`) VALUES (?,?,?,?,?,?)",array($thema['razd'],$thema['podrazd'],$thema['id'],$uid,$_message ,time()));
        DB::$dbs->query("UPDATE `us` set `balls` = `balls` + '1' where `id` = ? limit 1",array($cms->us['id']));
header('location:/forum/thema'.$thema['id'].'/page'.ceil(($cp+1)/10).'');



    $post_id = DB::$dbs->lastInsertId();

    if(@file_exists($_FILES['filename']['tmp_name'])){
    
    $fgn = time().'_'.rand(1234,5678).'.'.$upfiletype;
  
    move_uploaded_file($_FILES['filename']['tmp_name'], "files/".$fgn."");
	
		DB::$dbs->query("INSERT INTO `forum_file` (`post`,`file`) VALUES (?,?)",array($post_id,$fgn));
  
    }
    
							 DB::$dbs->query("UPDATE `forum_themes` set `last_time` = '".time()."',`last_user` = '".$uid."' where `id` = '".$thema['id']."' limit 1");



   $value = $func->uNick($cms->us['id']).' ответил вам в теме <a href="/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'">'.$thema['name'].'</a>!';
            DB::$dbs->query("INSERT INTO `action` set `value` = ?, `t` = ?, `us` = ?, `see` = ?",array($value,time(),$ous['id'],1));



 $rss = DB::$dbs->query("SELECT * FROM `forum_rss` where `thema` = ? and `user` != ? and `user` != ? order by `id`",array($thema['id'],$cms->us['id'],$ous['id']));
   while($_rss = $rss -> fetch()){
   
   $value = $func->uNick($cms->us['id']).' написал в теме <a href="/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'">'.$thema['name'].'</a>!';
            DB::$dbs->query("INSERT INTO `action` set `value` = ?, `t` = ?, `us` = ?, `see` = ?",array($value,time(),$_rss['user'],1));
            
            }

$_SESSION['flood'] = time();


				header('location:/forum/thema'.$thema['id'].'/page'.ceil(($cp+1)/10).'');
								
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}


 echo '<div class="block_menu"><form action="/forum/thema'.$thema['id'].'/otv'.$ous['id'].'" method="post" method="post"enctype="multipart/form-data">
      Сообщение для '.$func->uNick($ous['id']).':<br><textarea rows="3" name="message"></textarea><br>
      
      Файл:<br><input type="file" name="filename"/><br>
      
      <input type="submit" name="submit" value="Написать"/>
	</form></div>';
  
  
  }

   echo '<div class="zag"><b><a href="/faq.php?go=smile">Смайлы</a> | <a href="/faq.php?go=bbcodes">ББ коды</a> </b></div>';

 echo '</div>';
 niz();
 ?>