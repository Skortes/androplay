<?
$title = 'Админка';
  
include_once '../inc/head.php';

if(!isset($cms->us['id']) OR $cms->us['level']<=7){ header('location:/'); }
if($cms->us['level']==10){
    echo '<div class="razd">Настройки</a></div>';
echo'
<div class="main"><a href="set.php">Настройки сайта</a></div>


';
echo '<div class="razd">Управление модулями</a></div>';
?>
<div class="main"><a href="chat.php">Управление чатом</a></div>
<div class="main"><a href="news.php">Управление новостями</a></div>
<?
}

include_once '../inc/foot.php';
?>