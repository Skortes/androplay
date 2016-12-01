<?php

/*
/////////////////////////////////////////////////////////////////////////////////
// Модуль: Авто добавление Новостей  V1.0 beta                                //
// Автор:   Abdusamad Dilmurodov (Ulty)                                 //
// icq:     56628086                                                          //
// e-mail: wm.ulty@gmail.com                                                  //
////////////////////////////////////////////////////////////////////////////////
*/
include 'connect.php';
$id = abs(intval($_GET['id']));
if($id) {
	$query = mysql_query("SELECT * FROM `ultynews` WHERE `id` = '".$id."' LIMIT 1;");
	if (mysql_num_rows($query)) {
		//Показываем новость
		$res1 = mysql_fetch_assoc($query);
		$title2 = $res1['name'];
		include 'head.php';
		echo '<div class="'.$title.'">' . $res1['name'] . '</div>';
		echo '<div class="'.$menu.'">';
		echo $res1['text'];
		echo '<div style="clear:both;"></div></div>';
		echo '<div class="'.$gmenu.'">
				Добавлено: ' . (date('dmy', $res1['time']) == date('dmy', time()) ? date('H:i', $res1['time']) : date('d.m.o / H:i', $res1['time'])) . '		</div>
		
		<div class="'.$menu.'">Поделится:<br /><script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script> <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"/>
</script> </div> </div> ';
include 'foot.php';
	} else {
header('Location: index.php');
	}
} else {
	header('Location: index.php');
}
?>