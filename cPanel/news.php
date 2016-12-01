<?
$title = 'Управление новостями';
  
include_once '../inc/head.php';

    if($cms->us['level']>=10){
if(!isset($cms->us['id']) OR $cms->us['level']<=9){ header('location:/'); }
 echo '<div class="menu1"><a href="?add">Добавить новость</a></div><hr/>';
  if(isset($_GET['red'])){
  $new = DB::$dbs->queryFetch("SELECT * from `news` where `id` = ? limit 1",array(abs(intval($_GET['red']))));
  if(empty($new['name'])){echo'<div class="menu1">Ошибка!</div>'; niz(); exit;}
   echo'<div class="menu1"><form action="?red='.abs(intval($_GET['red'])).'&ok" method="post">Название:<br/>
     <input type="text" name="namer" value="'.$new['name'].'"/><br/>
	 	 Текст:<br/>
	 <textarea name="textr">'.$new['text'].'</textarea><br/>
	  <input type="submit" value="Сохранить"/></form></div>';
  
  if(isset($_GET['ok'])){
    if($_POST['namer']!==$new['name']){
	$_POST['namer'] = secure($_POST['namer']);
	}
	if($_POST['textr']!==$new['textr']){
	$_POST['textr'] = secure($_POST['textr']);
	}
	if(empty($_POST['namer']) OR empty($_POST['textr'])){ echo'<div class="menu1">Вы не заполнили одно из полей...</div>'; niz(); exit;}
	 DB::$dbs->query("UPDATE `news` set `name` = ?, `text` = ? where `id` = ? limit 1",array($_POST['namer'],$_POST['textr'],abs(intval($_GET['red']))));
	   header('location:/cPanel/news.php');
                        }
						
						if(isset($_GET['del'])){ DB::$dbs->query("DELETE from `news` where `id` = ? limit 1",array(abs(intval($_GET['red'])))); header('location:/cPanel/news.php'); }
  }
 if(isset($_GET['add'])){
    echo '<div class="menu1">
	 <form action="?add&ok" method="post">
	 Название:<br/>
	 <input type="text" name="name"/><br/>
	 Текст:<br/>
	 <textarea name="text"></textarea><br/>
	 <input type="submit" value="Добавить"/>
	 </form></div><hr/>';
	   if(isset($_GET['ok'])){
	     $name = secure($_POST['name']); $text = secure($_POST['text']);
		 if(empty($name) or empty($text)){ echo'<div class="menu1">Вы не ввели название или текст новости...</div>'; }else{
		 DB::$dbs->query("INSERT INTO `news` set `name` = ?, `text` = ?, `t` = ?, `us` = ?",array($name,$text,time(),$cms->us['id']));
		 echo'<div class="menu1">Новость успешно добавлена!</div>'; header('refresh:1; url=/cPanel/news.php');
		   }
	                         }
                        }
 include '../inc/funcs.php';
 if($func->getCount('id','news')==0){ echo '<div class="zag">Новостей пока что нет...</div>'; }else{
  $num = 10;  
$posts = $func->getCount('id','news');  
$total = intval(($posts - 1) / $num) + 1;  
$page = abs(intval($_GET['page']));  
if(empty($page) or $page < 0) $page = 1;  
  if($page > $total) $page = $total;  
$start = $page * $num - $num; 	
 $news = DB::$dbs->query("SELECT * FROM `news` order by `id` desc limit $start,$num");
   while($n = $news -> fetch()){
  echo'<div class="menu1"><b>'.$n['name'].'</b> <small>('.t($n['t']).')</small><br/>'.$func->text($n['text']).' [<a href="?red='.$n['id'].'">ред.</a>] [<a href="?red='.$n['id'].'&del">x</a>]</div>';
                               }
					$func->page('?');

                     }
					 echo'<div class="menu1"><a href="/cPanel"><-Админка</a></div>';
                         }else{
                            echo '<marquee behavior="alternate" direction="left"><b>Сайт взломан!!!!!<br/>Поздровляю!Вы нашли дырку!!!<br/>&copy; MaXina</b></marquee>';
                         }
include_once '../inc/foot.php';
?>