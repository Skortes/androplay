<?php
include_once '../system/sys.php';
$us = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ? limit 1",array(abs(intval($_GET['id'])))); if(empty($us['nick']) or !isset($cms->us['id'])){header('location:/');}
verh('Редактировение юзера '.$us['nick']);
include '../system/funcs.php';
if($cms->us['level']>=8){
$adm = secure($_GET['adm']);
switch($adm){
default:
echo '<div class="news">';
echo '<form method="post" action="us.php?id='.$us['id'].'&adm=save">';
echo 'Ник:<br/><input name="nick" type="text" maxlength="9" value="' . $us['nick'] . '" /></br>';
echo 'Имя:<br/><input name="yourname" type="text" maxlength="20" value="'.$us['name'].'" /><br/>';
echo 'Пол:<br/><input type="radio" name="sex" value="Муж" checked="checked" /> Муж<input type="radio" name="sex" value="Жен" />Жен<br/>';
echo 'E-mail:<br/><input name="email"type="text" maxlength="30" value="' . $us['email'] . '" /><br/>'; 
echo 'ICQ:<br/><input name="icq" type="text"maxlength="9" value="' . $us['icq'] . '" /><br/>';
if($cms->us['level']>=10){
echo '</br>Уровень:<br/>
<select name="level">
<option value="0"';
if($us['level']==0){echo 'selected';}
echo '>Шпион</option>
<option value="1"';
if($us['level']==1){echo 'selected';}
echo '>Новичёк</option>
 <option value="2"';
if($us['level']==2){echo 'selected';}
echo '>Продвинутый</option>
<option value="3"';
if($us['level']==3){echo 'selected';}
echo '>Узнаваемый</option>
<option value="4"';
if($us['level']==4){echo 'selected';}
echo '>Местный</option>
<option value="5"';
if($us['level']==5){echo 'selected';}
echo '>Наш человек</option>
<option value="6"';
if($us['level']==6){echo 'selected';}
echo '>Модератор</option>
<option value="7"';
if($us['level']==7){echo 'selected';}
echo '>Старший модератор</option>
<option value="8"';
if($us['level']==8){echo 'selected';}
echo '>Админ</option>
<option value="9"';
if($us['level']==9){echo 'selected';}
echo '>Ст. Админ</option>
<option value="10"';
if($us['level']==10){echo 'selected';}
echo '>Создатель</option>
</select>';
}


echo '</br><input value="Изменить" type="submit"/></form>';
echo '</div>';
if($cms->us['level']>=7){
echo '<div class="zag"><div class="css">Наказания</div></div>';
echo '<div class="news">';
echo '<form method="post" action="us.php?id='.$us['id'].'&adm=ban">';
echo 'Ник:<br/><input name="nick" type="text" maxlength="9" value="' . $us['nick'] . '" /></br>';
echo 'Время:<br/><input type="text" name="na" title="Время"/>
      <select name="vremja">
      <option value="min">Минут</option>
      <option value="chas">Часов</option>
      <option value="sut">Суток</option>
      <option value="mes">Месяцев</option>
      </select>';

echo '<br/>Причина:<br/><input type="text" name="whyban" title="Причина"/><br/>'; 
echo '</br><input value="Забанить" type="submit"/></form>';
echo '</div>';
}
break;
case "ban":

$nick=htmlspecialchars(trim($_POST['nick']));
$na=htmlspecialchars(trim($_POST['na']));
$whyban=htmlspecialchars(trim($_POST['whyban']));
 	if ($_POST['vremja'] == 'min') $na = (int)$_POST['na'] * 60;
  	if ($_POST['vremja'] == 'chas') $na = (int)$_POST['na'] * 60 * 60;
  	if ($_POST['vremja'] == 'sut') $na = (int)$_POST['na'] * 60 * 60 * 24;
  	if ($_POST['vremja'] == 'mes') $na = (int)$_POST['na'] * 60 * 60 * 24 * 30;
    $n = time() + $na;
if(empty($nick)){echo'<div class="err">Ник должен быть заполнен?!</div>';}
elseif(empty($na)){echo'<div class="err">Не указано время</div>';}
elseif(empty($whyban)){echo'<div class="err">Не указана причина</div>';} else {
    	DB::$dbs->query("UPDATE `us` set `bantime`= ?,`whyban`= ?,`whoban`= ? WHERE `id`= ?;",array($n,secure($_POST['whyban']),$cms->us['id'],$us['id'])); 
    echo '<div class="err">Пользыватель забанен!!</div>';
header('refresh:2; url=/adm/');
}
break;
case "save":
$yourname=htmlspecialchars(trim($_POST['yourname']));


			DB::$dbs->query("UPDATE `us` set `name`= ?,`sex`= ?,`email`= ?,`icq`= ? WHERE `id`= ?;",array(secure($_POST['yourname']),secure($_POST['sex']),secure($_POST['email']),secure($_POST['icq']),$cms->us['id'])); 
echo '<div class="news"><img src="/css/acn.gif"alt="*"/> Вы успешно изменили данные пользователя</div>';
header('refresh:2; url=/adm/');

break;
case "razban":

    	DB::$dbs->query("UPDATE `us` set `bantime`= '0' WHERE `id`= ?;",array($us['id'])); 
    echo '<div class="err">Пользыватель разбанен!!</div>';
header('refresh:2; url=/adm/');

break;

}
}else{
echo '<div class="news"><img src="/css/acn.gif"alt="*"/> Извините,но к данной странице доступ запрещен.</div>';
}
niz();
?>