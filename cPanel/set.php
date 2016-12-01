<?
/**
 * Made by MaXina
 * http://php-lib.ru
 */
$title = 'Настройки сайта';
  
include_once '../inc/head.php';


if($cms->us['level']>=10){
$set = DB::$dbs->queryFetch("SELECT * FROM `set`");
switch ($_GET['w']){
default:
echo '<div class="menu">Настройка сайта ';
if ($set['nav'] == 1) $s = 'checked="checked"';
if ($set['nav'] == 0) $sl = 'checked="checked"';
if ($set['vid'] == 1) $sv = 'checked="checked"';
if ($set['vid'] == 0) $svv = 'checked="checked"';
echo '<div class="menu1">';
echo '<form method="post" action="?w=save">';

echo 'Задержка онлайна:<br/><input name="omline"type="text" maxlength="8" value="' . $set['on'] . '" /><br/>';
echo 'Кол-во выводимых юзеров в онлайне:<br/><input name="user"type="text" maxlength="2" value="' . $set['who'] . '" /><br/>';
echo '</br><input value="Изменить" type="submit"/></form>';
echo '</div>';
break;

case 'save':
$name=htmlspecialchars(trim($_POST['name']));
$description=htmlspecialchars(trim($_POST['description']));
$kslova=htmlspecialchars(trim($_POST['kslova']));

 if(empty($name) or empty($kslova)){ echo'<div class="menu1">Заполните все поля!</div>';} else {
echo '<div class="menu1">Успешно!</div>';header('refresh:2; url=/adm/');
DB::$dbs->query("UPDATE `set` set `name`= ?,`description`= ?,`keywords`= ?,`vid`= ?,`nav`= ?,`on`= ?,`who`= ?,`style`= ? ;",array(secure($_POST['name']),secure ($_POST['description']),secure ($_POST['kslova']),secure ($_POST['vid']),secure ($_POST['nav']),secure ($_POST['omline']),secure ($_POST['user']),secure ($_POST['style'])));
}
}
}else{echo '<div class="menu1"><b>Учебники собрал,Хацкер?</b></div>';}


include_once '../inc/foot.php';
?>