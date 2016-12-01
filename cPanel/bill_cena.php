<?
/**
 * Made by MaXina
 * http://kingcms.ru
 */

include_once '../system/sys.php';
verh('Настройка цен');
if($cms->us['level']>=10){
$set = DB::$dbs->queryFetch("SELECT * FROM `set_bill`");
switch ($_GET['w']){
default:
echo '<div class="tabl">Настройка цен</div>';
echo '<div class="news"><form method="post" action="?w=save">';
echo 'Стоимость статуса на форуме:<br/><input name="status" type="text" maxlength="4" value="' . $set['statforum'] . '" /><br/></div>';
echo '<div class="news"><input value="Изменить" type="submit"/></form></div>';
break;

case 'save':

echo '<div class="news">Успешно!</div>';header('refresh:2; url=/adm/');
DB::$dbs->query("UPDATE `set_bill` set `statforum`= ?;",array(secure ($_POST['status'])));
}
}else{echo '<div class="news"><b>Учебники собрал,Хацкер?</b></div>';}


niz();
?>