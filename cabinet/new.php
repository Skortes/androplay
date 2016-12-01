<?
$title = 'Оповещения';
  
include_once '../inc/head.php';
 if(!$cms->us['id']){header('location:/');}
 	$num = 10;
$posts = DB::$dbs->querySingle("SELECT count(id) FROM `action` where `us` = ?",array($cms->us['id']));
if($posts==0){echo'<div class="menu1">Оповещений нет...</div>';}else{
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
 include '../inc/funcs.php';
$ops = DB::$dbs->query("SELECT * FROM `action` where `us` = ? order by `id` desc limit $start,$num",array($cms->us['id']));
   while($op = $ops -> fetch()){
    if($op['see']==1){DB::$dbs->query("UPDATE `action` set `see` = ? where `id` = ? limit 1",array(0,$op['id']));}
     echo'<div class="main"><b>Система:</b> '.$func->text($op['value']).' ['.t($op['t']).']'.($op['see']==1?'<font color="red"><b>[new!]</b></font>':NULL).'</div>';
   }
   $func->page('?');
}
include_once '../inc/foot.php';
?>