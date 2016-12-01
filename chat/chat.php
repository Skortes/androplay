<?
$title = 'Комната';
include_once '../inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['chat']==1){
 $room = abs(intval($_GET['room']));
  $r = DB::$dbs->queryFetch("SELECT name,topic from `chat_rooms` where `id` = ? limit 1",array($room));
   if(empty($r['name']) or empty($cms->us['id'])){header('location:/chat'); exit;}

  header('refresh:120; url=/chat/chat.php?room='.$room);
   if(DB::$dbs->querySingle("SELECT count(id) from `chat_kto` where `room` = ? and `us` = ?",array($room,$cms->us['id']))==0){
   DB::$dbs->query("INSERT INTO `chat_kto` set `us` = ?, `room` = ?, `last` = ?",array($cms->us['id'],$room,time()));
   }else{ DB::$dbs->query("UPDATE `chat_kto` set `last` = ? where `us` = ? and `room` = ? limit 1",array(time(),$cms->us['id'],$room)); }
  
  echo'<div class="menu1">Топик: <b>'.$r['topic'].'</b>'.($cms->us['level']>=8?'<a href="?room='.$room.'&topic"><img src="/css/img/pencil.png" alt="*" align="middle"/></a>':NULL).' <a href="/chat/chat.php/room.php?room='.$room.'&viz"><img src="/css/img/kcall.png" alt="*" align="middle"/></a> <a href="/chat/chat.php?room='.$room.'"><img src="/css/img/refresh.png" alt="*" align="middle"/></a></div>';
      include '../inc/funcs.php';
  if(isset($_GET['viz'])){
   if($_SESSION['viz']<time()-60){
  $vall = $func->uNick($cms->us['id']).' вызвал'.($cms->us['sex']=='Муж'?NULL:'а').' вас в комнату [url=/chat/chat.php?room='.$room.']'.$r['name'].'[/url]';
    $komu = DB::$dbs->queryFetch("SELECT id from `us` where `level` > 5 order by `last` desc limit 1");
  DB::$dbs->query("INSERT INTO `action` set `value` = ?, `t` = ?, `us` = ?, `see` = ?",array($vall,time(),$komu['id'],1));
  echo'<div class="main">'.$func->uNick($komu['id']).' вызван в комнату.</div>';
  $_SESSION['viz'] = time();
  }else{
  echo'<div class="main">Вы не можете так часто вызывать админа... Попробуйте через '.$func->flood('sec',60,$_SESSION['viz']).'.</div>';
  }
  }
  if(isset($_GET['topic']) && $cms->us['level'] >= 8){
  echo'<div class="main"><form action="?room='.$room.'&topic&ok" method="post"><input type="text" name="topic" value="'.$r['topic'].'"/>
</br>
  <input type="submit" value="Сохранить"/></form></div>';
     if(isset($_GET['ok'])){
	 $topic = secure($_POST['topic']);
	 if(empty($topic)){echo'<div class="main">Вы не ввели текст топика...</div>'; }else{ DB::$dbs->query("UPDATE `chat_rooms` set `topic` = ? where `id` = ? limit 1",array($topic,$room)); header('location:/chat/chat.php?room='.$room.''); }
	 }
  }
  if(!isset($_GET['who'])){
  
   if(isset($_GET['otv'])){
   $u = DB::$dbs->queryFetch("SELECT nick from us where id=? limit 1",array($func->num($_GET['otv'])));
   $u['nick'] = '[b]'.$u['nick'].'[/b], ';
   }
  echo'<div class="main">
<div class = "menu"><a href="/faq.php?go=smile">Смайлики</a> / <a href="/faq.php?go=bbcodes">BB-code</a></div>
  <form action="?room='.$room.'&add" method="post" accept-charset="utf-8">	
	<input type="text" name="message" value="'.($u['nick']?$u['nick']:NULL).'" />
  </br><input type="submit" name="submit" value="Ok" />	 
	</form></div>';
	if(isset($_GET['add'])){
	$message = secure($_POST['message']);
	 if(empty($message)){ $cms->error = 'Вы не ввели текст сообщения!'; }
	 if(DB::$dbs->querySingle("SELECT count(id) from `chat_msg` where `us` = ? and `room` = ? and `text` = ?",array($cms->us['id'],$room,$message))>=1){$cms->error='Вы уже писали подобное...';}
	 if(!isset($cms->error)){DB::$dbs->query("INSERT INTO `chat_msg` set `text` = ?, `room` = ?, `us` = ?, `date` = ?",array($message,$room,$cms->us['id'],time())); DB::$dbs->query("UPDATE `us` set `balls` = `balls` + '1' where `id` = ? limit 1",array($cms->us['id'])); header('location:/chat/chat.php?room='.$room.''); }else{ echo '<div class="err">'.$cms->error.'</div>';}
	}
	if(isset($_GET['del']) and $cms->us['level']>=6){DB::$dbs->query("DELETE FROM `chat_msg` where `id` = ? limit 1",array(abs(intval($_GET['del']))));}
	$num = 10;
$posts = DB::$dbs->querySingle("SELECT count(id) FROM `chat_msg` where `room` = ?",array($room));
if($posts==0){echo'<div class="main">Сообщений нет...</div>';}else{
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
  $post = DB::$dbs->query("SELECT * FROM `chat_msg` where `room` = ? order by `id` desc limit $start,$num",array($room));
  if(isset($_GET['jal'])){
  $po = DB::$dbs->queryFetch("SELECT us,text from `chat_msg` where `id` = ? limit 1",array($func->num($_GET['jal'])));
  if(!$po['us'] or $po['us']==$cms->us['id']){echo'<div class="err">Ошибка.</div>';}else{
   $vall = $func->uNick($cms->us['id']).' пожаловал'.($cms->us['sex']=='Муж'?'ся':'ась').' на сообщение '.$func->uNick($po['us']).':
   "'.$po['text'].'". [url=/chat/chat.php?room='.$room.']Перейти в комнату[/url]';
    $komu = DB::$dbs->queryFetch("SELECT id from `us` where `level` > 5 order by `last` desc limit 1");
  DB::$dbs->query("INSERT INTO `action` set `value` = ?, `t` = ?, `us` = ?, `see` = ?",array($vall,time(),$komu['id'],1));
  }
  }
  while($p = $post -> fetch()){
  echo '<div class="menu">'.$func->uNick($p['us']).' ['.t($p['date']).']'.($cms->us['level']>=6?'[<a href="?room='.$room.'&del='.$p['id'].'">x</a>]':NULL).'<br/> <span style="font-size:small;color:#666666">'.$func->text($p['text']).'</span>'.($cms->us['id']!==$p['us']?'<br/>[<a href="?room='.$room.'&otv='.$p['us'].'">отв</a>][<a href="?room='.$room.'&jal='.$p['id'].'">спам</a>]':NULL).'</div>';
  }
  $func->page('?room='.$room.'&'); }
  echo'<div class="menu1"><img src="/css/img/us.png"> <a href="?room='.$room.'&who">Кто тут?</a> ('.DB::$dbs->querySingle("SELECT count(id) from `chat_kto` where `room` = ? and `last` > ?",array($room,time()-120)).') <br /><img src="/css/img/wizard.png"> <a href="">Модераторы</a><br /><img src="/css/img/062.png"> <a href="index.php">Комнаты</a></div>';
   }else{
   $peop = DB::$dbs->query("SELECT us,last from `chat_kto` where `room` = ? and `last` > ? order by `last` desc",array($room,time()-120));
   echo'<div class="main">Кто тут?</div>';
   while($pe = $peop -> fetch()){
   echo'<div class="main">'.$func->uNick($pe['us']).' ('.t($pe['last']).')</div>';
   }
   echo'<div class="menu"><a href="?room='.$room.'">Обратно в комнату</a></div>';
   }
}else{header('location:/');}
  include '../inc/foot.php';
?>