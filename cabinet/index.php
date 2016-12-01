<?
$title = 'Личный кабинет';
  
include_once '../inc/head.php';


	$my = secure($_GET['my']);
switch($my){

default: 
echo'<div class ="razd">Кабинет</div>';
echo'<a href="mail.php"><div class="menu">Сообщения</div></a>
<a href="new.php"><div class="menu">Оповещения</div></a>
<a href="../faq.php"><div class="menu">FAQ</div></a>';

//<a href="?my=bill"><div class="menu">Биллинг панель</div></a>
echo'<a href="?my=personal"><div class="menu">Анкетные данные</div></a>';
if($cms->us['level']>=8){echo '<a href="/cPanel/"><div class="menu"><font color = "red">Админка</font></div></a>';}
break;
case "bill":
$bill = DB::$dbs->queryFetch("SELECT * FROM `set_bill`");
echo '<div class="tabl">У Вас '.$cms->us['balls'].' Баллов сайта!</div>';
echo '<div class="main"><a href="?my=bill_status">Статус на форуме</a>('.$bill['statforum'].' баллов)</div>';
break;
case "bill_status": 
$bill = DB::$dbs->queryFetch("SELECT * FROM `set_bill`");
if($cms->us['balls']>=$bill['statforum']){
echo '<div class="tabl">У Вас '.$cms->us['balls'].' Баллов сайта!</div>';
echo '<div class="main"><form method="post" action="?my=bill_save">';
echo 'Статус:<br/><input name="status" type="text" maxlength="1000" value="' . $cms->us['statforum'] . '" /><br/></div>';
echo '<div class="main"><input value="Изменить" type="submit"/></form></div>';
}else{echo'<div class="main">Упссссс...Баллов то не хватает :(</div>';}


break;
case "bill_save":
$bill = DB::$dbs->queryFetch("SELECT * FROM `set_bill`");
$status=htmlspecialchars(trim($_POST['status']));
$balls=$cms->us['balls'] - $bill['statforum'] ;
DB::$dbs->query("UPDATE `us` set `statforum`= ?, `balls`= ? WHERE `id`= ?;",array(secure($status),secure($balls),$cms->us['id']));  
		echo '<div class="main">Вы успешно Статус в форуме!</div><div class="main"><a href="../index.php">Перейти на сайт</a></div>';

break;

case "personal":
echo '<div class="menu1">Анкетные данные | <a href="?my=color">Цвет ника</a> | <a href="?my=settings">Настройки</a></div>';
echo '<div class="main"><form method="post" action="?my=save">';
echo 'Ваше имя:<br/><input name="yourname" type="text" maxlength="20" value="' . $cms->us['name'] . '" /><br/>';
echo 'Ваша фамилия:<br/><input name="yourfam" type="text" maxlength="20" value="' . $cms->us['familia'] . '" /><br/>';
echo'<select name="sex"><option value="Муж" ' . ($cms->us['sex'] == Муж ? 'selected' : '') . '>Мужской</option><option value="Жен"' . ($cms->us['sex'] == Жен ? 'selected' : '') . '>Женский</option></select><br/>';
echo 'E-mail:<br/><input name="email" type="text" maxlength="30" value="' . $cms->us['email'] . '" /><br/>';
echo 'ICQ:<br/><input name="icq" type="text" maxlength="9" value="' . $cms->us['icq'] . '" /><br/>';
echo 'Skype:<br/><input name="skype" type="text" maxlength="20" value="' . $cms->us['skype'] . '" /><br/>';
echo 'О себе:<br/><input name="sebe" type="text" maxlength="100" value="' . $cms->us['sebe'] . '" /></div>';
echo '<div class="main"><input value="Изменить" type="submit"/></form></div>';


break;
case "save":
$yourname=htmlspecialchars(trim($_POST['yourname']));
$yourfam=htmlspecialchars(trim($_POST['yourfam']));
$sebe=htmlspecialchars(trim($_POST['sebe']));





			DB::$dbs->query("UPDATE `us` set `name`= ?,`familia`= ?,`sebe`= ?,`skype`= ?,`sex`= ?,`email`= ?,`icq`= ? WHERE `id`= ?;",array(secure($_POST['yourname']),secure($_POST['yourfam']),secure($_POST['sebe']),secure($_POST['skype']),secure($_POST['sex']),secure($_POST['email']),secure($_POST['icq']),$cms->us['id']));  
		echo '<div class="main">Вы успешно изменили анкету!</div><div class="main"><a href="../index.php">Перейти на сайт</a></div>';

break;
case "color":
echo '<div class="menu1"><a href="?my=personal">Анкетные данные</a> | Цвет ника | <a href="?my=settings">Настройки</a></div>';
echo '<div class="main"><form method="post" action="?my=add_color">';
	 echo '<select name="color">
          <option value="black" ' . ($cms->us['color'] == black  ? 'selected' : '') . '>Обычный</option>
     <option value="red" ' . ($cms->us['color'] == red ? 'selected' : '') . '>Красный</option>
        <option value="green" ' . ($cms->us['color'] == green ? 'selected' : '') . '>Зеленый</option>
     <option value="white" ' . ($cms->us['color'] == white ? 'selected' : '') . '>Белый</option>
     <option value="lime" ' . ($cms->us['color'] == lime ? 'selected' : '') . '>Лайм</option>
          <option value="yellow" ' . ($cms->us['color'] == yellow ? 'selected' : '') . '>Жёлтый</option>
                    <option value="#FFA500" ' . ($cms->us['color'] == '#FFA500' ? 'selected' : '') . '>Оранжевый</option>
                    <option value="#00FFFF" ' . ($cms->us['color'] == '#00FFFF' ? 'selected' : '') . '>Аква</option>
                    <option value="#FFFAFA" ' . ($cms->us['color'] == '#FFFAFA' ? 'selected' : '') . '>Снег</option>
                    <option value="#F0E68C" ' . ($cms->us['color'] == '#F0E68C' ? 'selected' : '') . '>Хаки</option>
                   <option value="gold" ' . ($cms->us['color'] == gold ? 'selected' : '') . '>Золотой</option>
     <option value="blue" ' . ($cms->us['color'] == blue ? 'selected' : '') . '>Синий</option>';

echo '<div class="main"><br/><input value="Изменить" type="submit"/></form></div>';

break;
case "add_color":
DB::$dbs->query("UPDATE `us` set `color`= ? WHERE `id`= ?;",array(secure($_POST['color']),$cms->us['id']));  
echo '<div class="main">Вы успешно изменили цвет ника!</div><div class="main"><a href="../index.php">Перейти на сайт</a></div>';

break;
case "settings":
echo '<div class="menu1"><a href="?my=personal">Анкетные данные</a> | <a href="?my=color">Цвет ника</a> | Настройки</div>';
if ($cms->us['open'] == 0) $s = 'checked="checked"';
if ($cms->us['open'] == 1) $sl = 'checked="checked"';
echo '<div class="main">';
echo '<form method="post" action="?my=set_save">';

echo'Скрыть анкету?<br/>';
echo'<select name="open"><option value="0" ' . ($cms->us['open'] == 0 ? 'selected' : '') . '>Нет</option><option value="1"' . ($cms->us['open'] ==  1 ? 'selected' : '') . '>Да</option></select><br/>';




echo '<div class="main"><input value="Изменить" type="submit"/></form></div>';
echo '</div>';
break;
case "set_save":
DB::$dbs->query("UPDATE `us` set `nav`= ?, `open`= ?, `style`= ? WHERE `id`= ?;",array(secure($_POST['nav']),secure($_POST['open']),secure($_POST['style']),$cms->us['id']));  
echo '<div class="main">Вы успешно изменили настройки!</div><div class="main"><a href="../index.php">Перейти на сайт</a></div>';
break;
}
include_once '../inc/foot.php';
?>