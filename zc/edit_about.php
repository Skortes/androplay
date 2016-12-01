<?
include_once '../system/sys.php';
include '../system/funcs.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['zc']==0){header('location:../');}
// Записываем ID папки в переменную
$dir_id = (int)$_GET['id'];
$dir = DB::$dbs->query("select * from `zc` where `id` = '$dir_id' limit 1")->fetch();

verh('Описание');


if($func->getCount("id","`zc` where `id` = '$dir_id' and `type` = '2' and `user_id` = '".$cms->us['id']."'") == 1){

if(isset($_POST['set'])){
     $about = secure($_POST['about']);
 DB::$dbs->query("update `zc` set `about` = '$about' where `id` = '$dir_id' and `type` = '2'");
 header("location: /zc/?id=$dir_id");
}

echo "<div class='news'><a href='?id=$dir_id'>Назад</a></div>
<div class='menu'>
<form action='' method='post'>
Описание:<br/>
<textarea type='text' name='about'>$dir[about]</textarea><br/>
<input type='submit' name='set' value='Сохранить'/>
</form>
</div>";
} else {
echo "access denied";
}
niz();
?>