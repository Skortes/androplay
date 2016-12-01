<?
/**
 * Made by MaXina
 * http://php-lib.ru
 */

include_once '../system/sys.php';
verh('Добовление цвета');
if($cms->us['level']>=10){
$set = DB::$dbs->queryFetch("SELECT * FROM `colorus`");
switch ($_GET['go']){
default:
echo '<div class="news"><b>Добавление цвета</b></div>';
echo '<div class="news"><form method="post" action="?go=add_color">';
echo 'Цвет [Таблица цветов]:<br/>';
echo '<form><input name="color" type="text" maxlength="9" value="" /></br>';
echo 'Название: <br/>';
echo '<form><input name="name" type="text" maxlength="9" value="" /></br>';
echo '<div class="news"><input value="Изменить" type="submit"/></form></div>';
 



break;

case "add_color":
$color=htmlspecialchars(trim($_POST['color']));
$name=htmlspecialchars(trim($_POST['name']));
DB::$dbs->query("INSERT INTO `colorus` (`color`,`name`) VALUES (?,?)",array($color,$name));
echo '<div class="news">Вы успешно добавили цвет ника!</div><div class="news"><a href="../index.php">Перейти на сайт</a></div>';

break;
}
}else{echo '<div class="news"><b>Учебники собрал,Хацкер?</b></div>';}


niz();
?>