<?php 
$title = 'Бесплатные загрузки';
  
include_once 'inc/head.php';
include 'android/conf.php';

	
  include 'inc/funcs.php';
include_once 'new_rel.php';

echo'<div class="menu1">AndroPlay.Pw - лучший контент для телефонов и планшетов.<br/> Новинки игр на Android</div>';
  $ln = DB::$dbs->queryFetch("SELECT * FROM `news` order by `id` desc limit 1");

echo'<div class="n"><a href="/news"><img src="/img/news.png" alt=""><font color ="#fff">Новости('.t($ln['t']).') </font></a></div>';

$apps = array('Новинки'=>''.$papka.'cat/arcade_action/',
	'Популярные'=>''.$papka.'cat/7_2015/',
	'Лучшее'=>''.$papka.'cat/best/',
	'Интернет и связь'=>''.$papka.'cat/internet_network/',
	'Социальные'=>''.$papka.'cat/social/',
	'Развлечения'=>''.$papka.'cat/fun/',
	'Системные'=>''.$papka.'cat/system/',
	'Навигация'=>''.$papka.'cat/navi_maps/',
	'Мультимедиа'=>''.$papka.'cat/multimedia/',
	'Полезные'=>''.$papka.'cat/useful/',
	'Безопасность'=>''.$papka.'cat/security/',
	'Обои, заставки'=>''.$papka.'cat/themes/',
	'Электронная коммерция'=>''.$papka.'cat/shopping/'
	);

echo'<div class ="razd"><img src="/img/zag.png" alt=""><font color ="#fff">Игры и приложения</font></div>';
foreach ($apps as $links =>$href ) {
	echo'<a href ="'.$href.'"> <div class="menu">'.$links.'</div></a>';
}

echo'<div class ="razd"><font color ="#fff"><img src="/img/raz.png" alt="">Online-Игры</font></div>';
echo '<a href="http://godlands.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/welcome.jpg" width="50px" height="50px" class="links"/>Godlands</div></a>';

echo '<a href="http://mdragons.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50.jpg" class="links"/>Мир драконов</div></a>';
echo '<a href="http://nebo.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50.png" class="links"/> Небоскребы </div></a>';
echo '<a href="http://elem.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50-dragon-2.png" class="links"/> Повелители стихий</div></a>';
echo '<a href="http://wartank.ru/?channelId=35382" class="links"><div class="menu"><img src="css/games/logo.jpg" width="50px" height="50px" class="links"/> Танки</div></a>';
echo '<a href="http://mpets.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/game8.png" class="links"/>Удивительные питомцы</div></a>';
echo '<a href="http://ahero.ru?channelId=35382" class="links"><div class="menu"><img src="css/games/ahero.jpg" width="50px" height="50px" class="links"/> Эра Героев</div></a>';
echo '<a href="http://naemniki.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/riot-logo-png8.png" width="50px" height="50px" class="links"/> Наемники</div></a>';
echo '<a href="http://tiwar.ru/?channelId=35382" class="links"><div class="menu"><img src="css/games/logo.png" width="50px" height="50px" class="links"/> Битва титанов</div></a>';
echo'<div class ="razd"><font color ="#fff">Игра дня</font></div>';
$rand=rand(1000,9999);
$date_time_array = getdate( time() );

if($date_time_array['weekday'] == 'Monday' ) {
    $skortes = '<a href="http://tiwar.ru/?channelId=35382" class="links"><div class="menu"><img src="css/games/logo.png" width="50px" height="50px" class="links"/> Битва титанов</div></a>';
}elseif($date_time_array['weekday'] == 'Tuesday'){
    $skortes = '<a href="http://godlands.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/welcome.jpg" width="50px" height="50px" class="links"/>Godlands</div></a>';
}elseif ($date_time_array['weekday'] == 'Wednesday'){
    $skortes = '<a href="http://nebo.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50.png" class="links"/> Небоскребы </div></a>';
}elseif ($date_time_array['weekday']== 'Thursday'){
    $skortes = '<a href="http://mpets.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/game8.png" class="links"/>Удивительные питомцы</div></a>';
}elseif ($date_time_array['weekday']== 'Friday'){
    $skortes = '<a href="http://elem.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50-dragon-2.png" class="links"/> Повелители стихий</div></a>';
}elseif ($date_time_array['weekday']== 'Saturday'){
    $skortes = '<a href="http://ahero.ru?channelId=35382" class="links"><div class="menu"><img src="css/games/ahero.jpg" width="50px" height="50px" class="links"/> Эра Героев</div></a>';
}elseif ($date_time_array['weekday']== 'Sunday'){
    $skortes = '<a href="http://mdragons.mobi/?channelId=35382" class="links"><div class="menu"><img src="css/games/50x50.jpg" class="links"/>Мир драконов</div></a>';
}
echo''.$skortes.'';

echo'<div class ="razd1"><img src="/img/raz.png" alt=""><font color ="#fff">Общение</font></div>';
?>
<style type="text/css">
  .black {background: rgba(0,0,0,.27);border: 1px solid #949494;}
.black {color: #fff;padding: 0px 3px;margin: 0 1px;border-radius: 4px;display: inline-block;}
span.black {padding: 2px 5px;margin: -2px 1px;}
</style>
<a href="guest"><div class="menu">Гостевая<span class="black"><?echo ''.$func->getCount('id','guest').'';?></span></div></a> 
<a href="chat"><div class="menu">Чат<span class="black"><? echo $func->getCount('id','chat_kto where last > '.(time()-120)).'/'.$func->getCount('id','chat_msg');?></span></div></a>
<a href="photos"><div class="menu">Галлерея<span class="black"><?echo $func->getCount('id','photos');?></span></div></a> 
<a href="users"><div class="menu">Пользователи<span class="black"><?echo ''.$func->getCount('id','us').'';?></span></div></a>


<?

echo'<div class ="razd"><img src="/img/raz.png" alt=""><font color ="#fff">Это полезно</font></div>';
echo'<a href="/newsln"><div class="menu">Лента новостей</div></a>';


/*
if($set['guest']==0 && $set['chat']==0 ){}else{
?>
<div class="zag"><div class="css"><b>Общение</b></div></div>

<?
}
if($set['guest']==1){
    ?>
<div class="block_menu"><img src="/css/default/acn.gif"> <a href="guest.php">Гостевая</a> <?echo '('.$func->getCount('id','guest').')';?></div>
<?
}else{}

if($set['chat']==1){
    ?>
<div class="block_menu"><img src="/css/default/acn.gif"> <a href="chat">Чат</a> (<? echo $func->getCount('id','chat_kto where last > '.(time()-120)).'/'.$func->getCount('id','chat_msg');?>)</div>
<?
}else{};
if($set['forum']==1){
?>
<div class="zag"><div class="css"><img src="/css/default/acn.gif"> <a href="/forum"><b>Форум</a> (<? echo DB::$dbs->querySingle("SELECT count(id) from `forum_themes`"); ?>/<? echo DB::$dbs->querySingle("SELECT count(id) from `forum_post`"); ?>)</b></div></div>

<?


 $themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `status` < '3' order by `last_time` desc limit 3");
   while($thema = $themes -> fetch()){
  echo '<div class="block_menu"><img src="/forum/images/';
  switch($thema['status'])
  {
  case '0': echo 'open'; break;
  case '1': echo 'closed'; break;
  case '2': echo 'top'; break;
  } 
  

  $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id']));
 echo '.png" alt="*"/> <a href="/forum/thema'.$thema['id'].'">'.$thema['name'].'</a> ('.$cp.') <a href="/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'">>></a></div>';
  
  }
}else{}
if($set['zc']==0 && $set['galer']==0 && $set['library']==0 && $set['user']==0){}else{
?>


<div class="zag"><div class="css"><b>Разное</b></div></div>
<?
}
if($set['zc']==1){
?>
<div class="block_menu"> <img src="/css/default/acn.gif"> <a href="zc">Загруз-центр</a> (<?echo $func->getCount('id','zc where `type`=2');?>)</div>
<?


 $zcc = DB::$dbs->query("SELECT * FROM `zc` where `type` = '2' order by `id` desc limit 3");
   while($zs = $zcc -> fetch()){

  
 echo ' <div class="news">
<img src="/zc/icons/'. ($zs["file_ext"] != NULL?$zs["file_ext"]:"file") .'.png" alt=""/> <a href="/zc/?id='.$zs["id"].'">'.$zs["name"].'</a></div>';
  
  }

}else{}

if($set['galer']==1){
    ?>
<div class="block_menu"> <img src="/css/default/acn.gif"> <a href="photos">Галлерея</a> (<?echo $func->getCount('id','photos');?>)</div>
<?
}else{}
if($set['library']==1){
    ?>
<div class="block_menu"> <img src="/css/default/acn.gif"> <a href="/library/">Библиотека</a> (<?echo $func->getCount('id','library_r').'/'.$func->getCount('id','library_k where `mod` = 0');?>)</div>
<?
}else{}
if($set['user']==1){
    ?>
<div class="block_menu"> <img src="/css/default/acn.gif"> <a href="users.php">Пользователи</a> <?echo '('.$func->getCount('id','us').')';?></div>
<?
}else{}
?>
</div>
</div>
<?
  
*/
   if(isset($_GET['exit']) && isset($cms->us['id'])){
  setcookie('username', NULL);
  setcookie('password', NULL);
header('location:/');
     }
		 

include_once 'inc/foot.php';

echo'<h1></h1>';
?>