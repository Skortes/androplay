<?php
$title = 'Авторизация';
include_once 'inc/head.php';
include 'android/conf.php';



if(isset($cms->us['id'])){header('location:/error.php?user');}
if(!isset($_GET['login'])){
	echo'<form action="?login" method="post">
<div class="main">
<section class="container one">
	<p><label for="user_name">Ваш логин</label>
	<input name="nick" type="text" size="15" maxlength="15" pattern="^[A-Za-z-0-9-_\s]+$"><span></span></p>
	
	<p><label for="password">Пароль</label>
	 <input name="pass"" type="password" size="15" maxlength="15" pattern="^[A-Za-z-0-9\s]+$"><span></span></p>
	 <input type="submit" name="ok"class="turquoise-flat-button" value="Вход">
	 </form>
	 <a href="/reg"><input value="Регистрация" class="turquoise-flat-button" /></a>
</section>

</div>
';

}else{if(isset($_GET['nick']) || isset($_GET['pass'])){$nick = secure($_GET['nick']);
$pass = secure($_GET['pass']);}else{
$nick = secure($_POST['nick']);
$pass = md5(secure($_POST['pass']));}
if(empty($pass) || empty($nick)){echo'<div class="main"><font color="red"><b>Вы не ввели логин или пароль</b></font></div>'; 
include_once 'inc/foot.php';
exit;}
if(DB::$dbs->querySingle("SELECT count(id) FROM `us` where `nick` = ?",array($nick))==0){echo'<div class="main"><font color="red"><b>Юзер с таким логином не существует!</b></font></div>'; include_once 'inc/foot.php';
 exit;
  }else{
$cms->us = DB::$dbs->queryFetch("SELECT id,pass,nick from `us` where `nick` = ? limit 1",array($nick));
if ($pass==$cms->us['pass']){
setcookie('username', $cms->us['id'], (time()+(60*60*24*365)));
setcookie('password', $cms->us['pass'], (time()+(60*60*24*365)));
header('location:/');
}else{
echo'<div class="main"><font color="red"><b>Неверный логин или пароль!</b></font></div>';
}
}
}
include_once 'inc/foot.php';
?>