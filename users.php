<?php     
$title = 'Пользователи';
include_once 'inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['user']==0){header('location:../');}

include 'inc/funcs.php';
echo'<div class="menu1">Сортировать по: ';
echo'<a href=\'?sort\'>ID</a> | ';
echo'<a href=\'?sort=nick\'>Ник</a> | <a href="?sort=level">Уровень</a> | <a href="?sort=balls">Баллам</a>';
echo'</div>';
$num = 10;
$posts = $func->getCount('id','us');
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
switch($_GET['sort']){
    case 'balls': $sort = 'balls desc';
		break;
	case 'level': $sort = 'level desc';
		break;
	case 'nick': $sort = nick;
		break;
	default: $sort = id;
		break;
	}
	$users = DB::$dbs->query("SELECT `id`,`nick`,`reg`,`last` FROM `us` ORDER BY $sort limit $start,$num");
while($user = $users -> fetch()){
	echo '<div class="menu">'.$func->uNick($user['id']).' (ID:'.$user['id'].')<br>Зарегистрирован: '.t($user['reg']).'</div>';
	}$func->page('?sort='.$sort.'&');

include_once 'inc/foot.php';
?>