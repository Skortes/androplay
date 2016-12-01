<?php 

$title = 'Регистрация';
include_once 'inc/head.php';
include 'android/conf.php';

if(isset($cms->us['id'])){header('location:/error.php?user');}
if(!isset($_GET['regsave'])){
	echo'<form action="?regsave" method="post">
<div class="main">
<section class="container one">
	<p><label for="user_name">Ваш логин</label>
	<input name="nick" type="text" size="15" maxlength="15" pattern="^[A-Za-z-0-9-_\s]+$"><span></span></p>
	
	<p><label for="password">Пароль</label>
    <input name="pass" type="password" maxlength="12" pattern="^[A-Za-z-0-9-_\s]+$"><span></span></p>
          
    <p><label for="password">Повторите</label>
    <input name="pass2" type="password" maxlength="12" pattern="^[A-Za-z-0-9-_\s]+$" ><span></span></p>

    <p><label for="user_name">Ваш имя</label>
	<input name="yourname" type="text" size="20" maxlength="20" ><span></span></p>

	 <label>Ваш пол</label>
	 <br/>
	 <input type="radio" name="sex" value="Муж" checked="checked" /> Муж</br>
	<input type="radio" name="sex" value="Жен" /> Жен<br/>

	  <p><label for="user_name">E-mail</label>
	<input name="email" type="text" size="30" maxlength="30" ><span></span></p>


	 <input type="submit" class="turquoise-flat-button" value="Зарегистрироваться">
	 </form>
</section>

</div>
';
}else{
$_POST['nick'] = trim($_POST['nick']);
if (DB::$dbs->querySingle("SELECT COUNT(id) FROM `us` WHERE `nick` = ?",array($_POST['nick']))>=1){$cms -> error = 'Логин <b>'.htmlspecialchars($_POST['nick']).'</b> уже зарегистрирован!';}
if(strlen($_POST['nick'])>15 || strlen($_POST['nick'])<2 || empty($_POST['nick'])){$cms -> error = 'Слишком длинный или короткий логин!';}
if(strlen($_POST['pass'])>15 OR strlen($_POST['pass'])<4){$cms -> error = 'Слишком длинный или короткий пароль!';}
if($_POST['pass']!==$_POST['pass2']){$cms -> error = 'Пароли не совпадают!';}
if(!preg_match('!^[a-z0-9]+$!i',$_POST['pass'])){$cms -> error = 'В пароле обнаружены запрешенные знаки!';}
if (!preg_match('!^[a-zа-я0-9]+$!i',$_POST['nick'])){$cms -> error = 'В логине присутствуют запрещенные символы';}
if (!empty($_POST['email']) AND !preg_match("/@/i",$_POST['email'])){$cms -> error = 'Неверный формат E-mail';}
$pass = md5($_POST['pass']);
if(empty($cms->error)){DB::$dbs->query("INSERT INTO `us` SET `nick`= ?,`pass`= ?,`name`= ?,`sex`= ?,`email`= ?,`ip`= ?,`soft`= ?,`reg`= ?,`last`= ?",array($_POST['nick'],$pass,htmlspecialchars($_POST['yourname']),secure($_POST['sex']),htmlspecialchars($_POST['email']),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],time(),time()));
echo '<div class="main">Вы успешно зарегистрировались!</div><div class="main"><a href="/">Перейти на сайт</a></div><div class="main">Автовход: <br/><textarea rows="2" colls="20">http://'.$_SERVER['SERVER_NAME'].'/aut?login&nick='.$_POST['nick'].'&pass='.$pass.'</textarea></div>';
 setcookie('username', DB::$dbs->lastInsertId(), (time()+(60*60*24*365)));
 setcookie('password', $pass, (time()+(60*60*24*365)));
 }else{ echo '<div class="main"><font color="red"><b>'.$cms->error.'</b></font></div>'; }
}
include_once 'inc/foot.php';
?>