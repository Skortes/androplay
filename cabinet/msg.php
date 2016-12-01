<?
$title = 'Почта';
  
include_once '../inc/head.php';
 $u = abs(intval($_GET['u']));
   if(!$cms->us['id'] or $u==$cms->us['id'] or DB::$dbs->querySingle("SELECT count(id) from `us` where `id` = ? limit 1",array($u))==0){header('location:/'); exit;}
     	
         
         $num = 10;
	
		      if(DB::$dbs->querySingle("SELECT count(id) from `poch` where `us` = ? and `kem` = ?",array($cms->us['id'],$u))==0){
			  DB::$dbs->query("INSERT INTO `poch` set `us` = ?, `kem` = ?, `last` = ?",array($cms->us['id'],$u,time()));
			  echo'<div class="menu">Контакт успешно добавлен...</div>';
			  }
			  		      if(DB::$dbs->querySingle("SELECT count(id) from `poch` where `kem` = ? and `us` = ?",array($cms->us['id'],$u))==0){
			  DB::$dbs->query("INSERT INTO `poch` set `kem` = ?, `us` = ?, `last` = ?",array($cms->us['id'],$u,time()));
			  }
              
			  echo'<div class="menu"><form action="?u='.$u.'&send" method="post">
			  Сообщение: (<a href="?u='.$u.'">обн<a>)<br/><textarea name="text"></textarea><br/><input type="submit" value="Отправить"/></form></div>';
			if(isset($_GET['send'])){
			$text = secure($_POST['text']);
			if(empty($text)){echo'<div class="menu">Вы не ввели текст сообщения...</div>';}else{
			 $poch = DB::$dbs->queryFetch("SELECT id from `poch` where `us` = ? and `kem` = ? limit 1",array($cms->us['id'],$u));
			DB::$dbs->query("INSERT INTO `msg` set `us` = ?, `kem` = ?, `text` = ?, `time` = ?, `poch` = ?",array($u,$cms->us['id'],$text,time(),$poch['id']));
			 DB::$dbs->query("UPDATE `poch` set `last` = ? where `kem` = ? and `us` = ? limit 1",array(time(),$cms->us['id'],$u));
			 DB::$dbs->query("UPDATE `poch` set `last` = ? where `us` = ? and `kem` = ? limit 1",array(time(),$cms->us['id'],$u));
			  header('location:/cabinet/msg.php?u='.$u.'');
			}
			}
           
            $posts = DB::$dbs->querySingle("SELECT count(id) FROM `msg` where `us` = ? and `kem` = ? or `kem` = ? and `us` = ?",array($cms->us['id'],$u,$cms->us['id'],$u));
if($posts==0){echo'<div class="menu1">Сообщений нет...</div>';}else{
 include '../inc/funcs.php';
$total = intval(($posts - 1) / $num) + 1;
$page = $func->num($_GET['page']);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
 $mails = DB::$dbs->query("SELECT * from `msg` where `us` = ? and `kem` = ? or `kem` = ? and `us` = ? order by `time` desc limit $start,$num",array($cms->us['id'],$u,$cms->us['id'],$u));
 while($mail = $mails -> fetch()){
 echo'<div class="menu">'.$func->uNick($mail['kem']).' '.($mail['see']==1?'[<font color="red"><b>Непрочитанное</b></font>]':NULL).' ['.t($mail['time']).']<br/>'.$func->text($mail['text']).'</div>';
 }
 DB::$dbs->query("UPDATE `msg` set `see` = ? where `us` = ? and `see` = ? limit 10",array(0,$cms->us['id'],1));
 $func->page('?u='.$u.'&');
 }
  echo'<div class="menu"><a href="?u='.$u.'&oc">Очистить переписку</a></div>';
   if(isset($_GET['oc'])){
   DB::$dbs->query("DELETE FROM `msg` where `us` = ? and `kem` = ? or `kem` = ? and `us` = ?",array($cms->us['id'],$u,$cms->us['id'],$u));
   echo'<div class="menu1">Переписка очищена...</div>';
   }
include_once '../inc/foot.php';
?>