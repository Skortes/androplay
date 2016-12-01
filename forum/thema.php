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

  if(DB::$dbs->querySingle("SELECT count(id) from `forum_kto` where `thema` = ? and `user` = ?",array($thema['id'],$cms->us['id'])) == 0)
  {
		DB::$dbs->query("INSERT INTO `forum_kto` (`thema`,`user`,`time`) VALUES (?,?,?)",array($thema['id'],$cms->us['id'],time()));
  
  }
  else
  {
  
							 DB::$dbs->query("UPDATE `forum_kto` set `time` = ? where `thema` = ? and `user` = ? limit 1",array(time(),$thema['id'],$cms->us['id']));

  }

verh($thema['name']);

 echo '<div class="munus">';

echo '<div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';

  if($thema['status'] == 3)
  {
  
  echo '<div class="zag">Эта тема была удалена!<br>
  <a href="/forum/thema'.$thema['id'].'/delete">Восстановить</a></div>';
  
  }
  else
  {

$num = 10;  
$posts = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id']));  
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 		

  

 echo '<div class="block_menu"><a href="/forum/thema'.$thema['id'].'/page'.$page.'">Обновить</a>';




if($cms->us['level'] >= 6)
{

echo ' | <a href="/forum/thema'.$thema['id'].'/close">'.($thema['status'] == 1 ? 'Открыть' : 'Закрыть').'</a> | <a href="/forum/thema'.$thema['id'].'/zak">'.($thema['status'] != 2 ? 'Закрепить' : 'Открепить').'</a> | <a href="/forum/thema'.$thema['id'].'/edit">Изменить</a> | <a href="/forum/thema'.$thema['id'].'/move">Переместить</a> | <a href="/forum/thema'.$thema['id'].'/delete">Удалить</a>';
  
  }

echo '</div>';

  if($thema['status'] == 1) echo '<div class="block_menu"><b>Тема закрыта!</b></div>';

 if(DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id']))==0){ echo '<div class="zag">Сообщений пока что нет...</div>'; }else{


          if($page == 1) $p_i = $page;
    
          elseif($page == 2) $p_i = ($page+9);
          
          else $p_i = ($page*10)-9;


 $post = DB::$dbs->query("SELECT * FROM `forum_post` where `thema` = ? order by `id` limit $start,$num",array($thema['id']));
   while($p = $post -> fetch()){
 
 
 echo '<div class="block_menu"><b>'.$p_i++.'.</b> ';
  $stus = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($p['user']))->fetch();

 if($p['status'] == 1)
 {
 
 
 echo 'Сообщение удалено!<br><br>';
 if($cms->us['level'] >= 6){
 
 echo '<small>';

   echo $func->uNick($p['user']).' ('.t($p['time']).')';
   echo ''.$stus['level'].'';

 $pauthor = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($p['user']))->fetch();

  if($thema['status'] != 1) 
  {
  
  if($p['user'] != $cms->us['id'])
  {
  
  if($cms->us['level'] >= 6 && $cms->us['level'] >= $pauthor['level']){
  echo ' [<a href="/forum/thema'.$thema['id'].'/otv'.$p['user'].'">отв</a>] [<a href="/forum/thema'.$thema['id'].'/cit'.$p['id'].'">цит</a>] [<a href="/forum/edit_message'.$p['id'].'">ред</a>]';

  if($cms->us['level'] >= $pauthor['level']) echo ' [<a href="/forum/del_message'.$p['id'].'">уд</a>]';
  
  }
  else
  {
  
  echo ' [<a href="/forum/thema'.$thema['id'].'/otv'.$p['user'].'">отв</a>] [<a href="/forum/thema'.$thema['id'].'/cit'.$p['id'].'">цит</a>]';
  
  }
  
  }
  else 
  {
  
  echo ' [<a href="/forum/edit_message'.$p['id'].'">ред</a>]';
  if($cms->us['level'] >= 6) echo ' [<a href="/forum/del_message'.$p['id'].'">уд</a>]';
  
  }
  
  }
  
  echo '<br>';
  
  if($p['cit'] != NULL)
  {
  
 $cit = DB::$dbs->query("SELECT * FROM `forum_post` where `id` = ? order by `id` limit 1",array($p['cit']))->fetch();

 $cus = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($cit['user']))->fetch();

  echo 'Цитата:<div class="news"><b>'.$cus['nick'].'</b>: '.$func->text($cit['message']).'</div>';

  }
  $stus = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($p['user']))->fetch();
  echo $func->text($p['message']);


  $files = DB::$dbs->querySingle("SELECT count(id) from `forum_file` where `post` = ?",array($p['id']));
if($files!=0)
{

  echo '<br>Прикрепленные файлы:<br>';

 $pfiles = DB::$dbs->query("SELECT * FROM `forum_file` where `post` = ? order by `id`",array($p['id']));
   while($pfs = $pfiles -> fetch()){
   
   echo '<b><a href="/forum/file_load'.$pfs['id'].'">'.$pfs['file'].'</a> ('.round(filesize('files/'.$pfs['file'].'')/1024).' кб) (скачали '.$pfs['loads'].' раз.)</b><br>';
   
   }
   
   }

  $post_edit = DB::$dbs->querySingle("SELECT count(id) from `forum_post_edit` where `post` = ?",array($p['id']));
if($post_edit!=0)
{
 $post_edits = DB::$dbs->query("SELECT * FROM `forum_post_edit` where `post` = ? order by `time` limit 1",array($p['id']));
   while($pe = $post_edits -> fetch()){
   
   echo '<br><small><i>Редактировано '.$post_edit.' раз. Посл. ред. '.$func->uNick($pe['user']).' '.date('d.m.Y в H:i',$pe['time']).'</i></small>';
   
   }
   
   }
 
 echo '</small><br><br>
 <a href="/forum/del_message'.$p['id'].'">Восстановить</a>';
 
 }
   
 }
 else
 {
 
  echo $func->uNick($p['user']).' ('.t($p['time']).')';

 $pauthor = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($p['user']))->fetch();

  if($thema['status'] != 1) 
  {
  
  if($p['user'] != $cms->us['id'])
  {
  
  if($cms->us['level'] >= 6 && $cms->us['level'] >= $pauthor['level']){
  echo ' [<a href="/forum/thema'.$thema['id'].'/otv'.$p['user'].'">отв</a>] [<a href="/forum/thema'.$thema['id'].'/cit'.$p['id'].'">цит</a>] [<a href="/forum/edit_message'.$p['id'].'">ред</a>]';

  if($cms->us['level'] >= $pauthor['level']) echo ' [<a href="/forum/del_message'.$p['id'].'">уд</a>]';
  
  }
  else
  {
  
  echo ' [<a href="/forum/thema'.$thema['id'].'/otv'.$p['user'].'">отв</a>] [<a href="/forum/thema'.$thema['id'].'/cit'.$p['id'].'">цит</a>]';
  
  }
  
  }
  else 
  {
  
  echo ' [<a href="/forum/edit_message'.$p['id'].'">ред</a>]';
  if($cms->us['level'] >= 6) echo ' [<a href="/forum/del_message'.$p['id'].'">уд</a>]';
  
  }
  
  }
  
  echo '<br>';
  
  if($p['cit'] != NULL)
  {
  
 $cit = DB::$dbs->query("SELECT * FROM `forum_post` where `id` = ? order by `id` limit 1",array($p['cit']))->fetch();

 $cus = DB::$dbs->query("SELECT * FROM `us` where `id` = ? order by `id` limit 1",array($cit['user']))->fetch();

  echo 'Цитата:<div class="news"><b>'.$cus['nick'].'</b>: '.$func->text($cit['message']).'</div>';

  }
  
  echo $func->text($p['message']);
  
  


  $files = DB::$dbs->querySingle("SELECT count(id) from `forum_file` where `post` = ?",array($p['id']));
if($files!=0)
{

  echo '<br>Прикрепленные файлы:<br>';

 $pfiles = DB::$dbs->query("SELECT * FROM `forum_file` where `post` = ? order by `id`",array($p['id']));
   while($pfs = $pfiles -> fetch()){
   
   echo '<b><a href="/forum/file_load'.$pfs['id'].'">'.$pfs['file'].'</a> ('.round(filesize('files/'.$pfs['file'].'')/1024).' кб) (скачали '.$pfs['loads'].' раз.)</b><br>';
   
   }
   
   }
echo '<br/><b>'.$func->text($stus['statforum']).'</b>';
  $post_edit = DB::$dbs->querySingle("SELECT count(id) from `forum_post_edit` where `post` = ?",array($p['id']));
if($post_edit!=0)
{
 $post_edits = DB::$dbs->query("SELECT * FROM `forum_post_edit` where `post` = ? order by `time` limit 1",array($p['id']));
   while($pe = $post_edits -> fetch()){
   
   echo '<br><small><i>Редактировано '.$post_edit.' раз. Посл. ред. '.$func->uNick($pe['user']).' '.date('d.m.Y в H:i',$pe['time']).'</i></small>';
   
   }
   
   }
  

   }

  echo '</div>';

 
 }
      
   $func->page('/forum/thema'.$thema['id'].'?');
 

 }

if($thema['status'] != 1)
{
$add = (isset($_GET['add']) ? secure($_GET['add']):NULL);
if(isset($add)){
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
  
		
  DB::$dbs->query("INSERT INTO `forum_post` (`razd`,`podrazd`,`thema`,`user`,`message`,`time`) VALUES (?,?,?,?,?,?)",array($thema['razd'],$thema['podrazd'],$thema['id'],$cms->us['id'],$message,time()));
        $post_id = DB::$dbs->lastInsertId();
        DB::$dbs->query("UPDATE `us` set `balls` = `balls` + '1' where `id` = ? limit 1",array($cms->us['id']));
  header('location:/forum/thema'.$thema['id'].'/page'.$page.'');
    
    

    if(@file_exists($_FILES['filename']['tmp_name'])){
    
    $fgn = time().'_'.rand(1234,5678).'.'.$upfiletype;
  
    move_uploaded_file($_FILES['filename']['tmp_name'], "files/".$fgn."");
	
		DB::$dbs->query("INSERT INTO `forum_file` (`post`,`file`) VALUES (?,?)",array($post_id,$fgn));

    }


				
							 DB::$dbs->query("UPDATE `forum_themes` set `last_time` = ?,`last_user` = ? where `id` = ? limit 1",array(time(),$cms->us['id'],$thema['id']));

    
    
    
 $rss = DB::$dbs->query("SELECT * FROM `forum_rss` where `thema` = ? and `user` != ? order by `id`",array($thema['id'],$cms->us['id']));
   while($_rss = $rss -> fetch()){
   
   $value = $func->uNick($cms->us['id']).' написал в теме <a href="/forum/thema'.$thema['id'].'/page'.$page.'">'.$thema['name'].'</a>!';
            DB::$dbs->query("INSERT INTO `action` set `value` = ?, `t` = ?, `us` = ?, `see` = ?",array($value,time(),$_rss['user'],1));
            
            }


        $_SESSION['flood'] = time();

        $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id'])); 

				header('location:/forum/thema'.$thema['id'].'/page'.ceil(($cp+1)/10));
								
				}else{ echo'<div class="err">'.$cms->error.'</div>'; }}


 echo '<div class="block_menu"><form action="/forum/thema'.$thema['id'].'/page'.$page.'?add" method="post"enctype="multipart/form-data">
      Сообщение:<br><textarea rows="3" name="message"></textarea><br>
      Файл:<br><input type="file" name="filename"/><br>
      <input type="submit" name="submit" value="Написать" name="add" />
	</form></div>';
  
  }
  
  }
   echo '<div class="block_menu">В теме <a href="/forum/thema'.$thema['id'].'/who">'.DB::$dbs->querySingle("SELECT count(id) from `forum_kto` where `thema` = ? and `time` > ?",array($thema['id'],time()-120)).'</a>, заходило <a href="/forum/thema'.$thema['id'].'/visits">'.DB::$dbs->querySingle("SELECT count(id) from `forum_kto` where `thema` = ?",array($thema['id'])).'</a>
   </div><div class="zag"><b><a href="/faq.php?go=smile">Смайлы</a> | <a href="/faq.php?go=bbcodes">ББ коды</a></b></div>';

 echo '</div>';
 niz();
 ?>