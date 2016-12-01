<?php
$title = 'Анкета ';
include_once 'inc/head.php';

$us = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
if(empty($us['nick']) or !isset($cms->us['id'])){header('location:/');}

 if($us['open'] == 0){ 
if($us['level'] == 0){ $us['level'] = 'Пользователь';}elseif($us['level']==1){$us['level']='Пользователь';}elseif($us['level']==2){$us['level']='Пользователь';}elseif($us['level']==3){
  $us['level'] = 'Узнаваемый';}elseif($us['level']==4){$us['level']='Местный';}elseif($us['level']==5){$us['level']='Наш человек';}elseif($us['level']==6){$us['level']='<b><font color="blue">Модератор</font></b>';}elseif($us['level']==7){$us['level']='<b><font color="blue">Старший модератор</font></b>';}elseif($us['level']==8){$us['level']='<b><font color="red">Админ</font></b>';}elseif($us['level']==9){$us['level']='<b><font color="red">Ст. админ</font></b>';}else{$us['level']='<b><font color="red">Создатель</font></b>';}
	include 'inc/funcs.php';
     echo '<div class="menu">'.$func->uNick($us['id']).'<br/>';
	echo'<b>»</b> Зарегистрирован: '.t($us ['reg']).'</br>
<b>»</b> Последняя активность: '.t($us['last']).'<br/>
<b>»</b> Уровень: '.$us['level'].'<br />';
$photo = DB::$dbs->queryFetch("SELECT id,path from `photos` where `us` = ? and `osn` = ? limit 1",array($us['id'],1));
echo'<a href="/photos/photo.php?id='.$photo['id'].'"><img src="'.($photo['path']?'/photos/'.$photo['path']:'/css/img/noavatar.png').'" alt="*" width="150" height="150" /></a></div>
<div class="main">';
if ($us['name']!=NULL) echo '<b>Имя:</b> ' . $us['name'] . '<br/></div>';
if ($us['familia']!=NULL) echo '<div class="main"><b>Фамилия:</b> ' . $us['familia'] . '<br/></div>';
echo '<div class="main"><b>Пол:</b> ' . $us['sex'] . '<br/></div>';
if ($us['icq']!=0) echo '<div class="main"><img  border="0" src="http://wwp.icq.com/scripts/online.dll?icq=' . $us['icq'] . '&img=27" /> ' . $us['icq'] . '<br/></div>';
if ($us['skype']!=NULL) echo '<div class="main"><img src="http://mystatus.skype.com/smallicon/' . $us['skype'] . '" style="border: none;" width="16" height="16" alt="My status" /> ' . $us['skype'] . '<br/></div>';
if ($us['email']!=NULL) echo '<div class="main"><b>Email:</b> ' . $us['email'] . '<br/></div>';
if ($us['sebe']!=NULL) echo '<div class="main"><b>О себе:</b> ' . $us['sebe'] . '<br/></div>';
if($cms->us['level']>=8){echo'<div class="main"><hr/><b><font color="blue">Данные для администрации</font></b></br></div>';}
if($cms->us['level']>=8){echo'<div class="main"><b>IP:</b> ' . $us['ip'] . '<br/></div>';}
if($cms->us['level']>=8){echo'<div class="main"><b>Soft:</b> ' . $us['soft'] . '<br/></div>';}
if($cms->us['level']>=8){echo'<div class="main"><a href="/cPanel/us.php?id='.$us['id'].'">Редактировать пользователя</a><br /></div>
';}
echo '</div>';

}else {echo '<font color="red"><b>Пользователь закрыл свою анкету от посторонних глаз!</b></font><br/>';}
 include_once 'inc/foot.php';
?>