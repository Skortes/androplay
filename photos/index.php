<?
$title = 'Галлерея';
  
include_once '../inc/head.php';

$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['galer']==0){header('location:../');}

  include '../inc/funcs.php';
  if($cms->us['id']){
  echo'<div class="menu"><a href="add.php">Добавить фотографию</a></div>';
  }
  if($func->getCount('id','photos')==0){
  echo'<div class="menu1">Фотографий нет...</div>';
  }else{
  $num = 10;
$posts = $func->getCount('id','photos');
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
   $photos = DB::$dbs->query("SELECT id,path,us,opis,date from `photos` order by `id` desc limit $start,$num");
   while($photo=$photos->fetch()){
  echo '<div class="menu"><a href="photo.php?id='.$photo['id'].'"><img src="/photos/'.$photo['path'].'" alt="*" width="150" height="150"/></a><br/>Загрузил: '.$func->uNick($photo['us']).' ['.t($photo['date']).'] '.(!$photo['opis']?NULL:'<br/><b>'.$func->text($photo['opis']).'</b>').'</div>';
  }
  $func->page('?');
  }
include_once '../inc/foot.php';
?>