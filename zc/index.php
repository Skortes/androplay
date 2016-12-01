<?
include_once '../system/sys.php';
include '../system/funcs.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['zc']==0){header('location:../');}
// Записываем ID папки в переменную
$dir_id = (int)$_GET['id'];
// Проверяем существование папки по ID
if($func->getCount("id","`zc` where `id` = '$dir_id'") == 0){
     $dir_id = 0;
}

// Создаем массив с данными папки
if ($dir_id != 0) {
     $dir = DB::$dbs->query("select * from `zc` where `id` = '$dir_id' limit 1")->fetch();
     $root_path = $dir['root_path'];
} else {
     $root_path = '/';
}

verh($dir_id != 0?$dir['name']:'Загруз-центр');


if($func->getCount("id","`zc` where `id` = '$dir_id' and `type` = '2'") == 1){
echo "<div class='tabl'><b><span style='color:red'>$dir[name]</span></b> :: <a href='/zc?id=$dir[dir_id]'>Назад</a><br/>
";
if($dir['file_ext'] == 'png' || $dir['file_ext'] == 'JPG' || $dir['file_ext'] == 'gif'){
     echo "<img src='/zc/downloads/$dir[root_path]$dir[root_name]' alt='' width='150' height='150' /><br/>";
} else {
   echo "<b>Скриншот отсутствует....</b><br/>";  
}

echo "
Описание: ".($dir['about'] == NULL ? "<b>Описание отсутствует...</b>" : $func->text($dir['about']))." <br/>
Вес: <b>".round(filesize('downloads/'.$dir[root_path].''.$dir[root_name].'')/1024)." кб</b><br/>
Скачиваний: <b>".$dir['loads']."</b><br/>
Загрузил: ".$func->uNick($dir['user_id'])."<br/>
Добавлен: <b>".t($dir['time'])."</b><br/>";
echo "</div>
<div class='zag'><div class='css'>
<a href='load.php?id=$dir_id'>Скачать $dir[name]</a><br/></div></div>
<div class='zag'><div class='css'>".($dir['user_id'] == $cms->us['id'] ? "<a href='edit_about.php?id=$dir_id'>Сменить описание</a>" : NULL)."<br/></div></div>";
if($cms->us['level']>=10){
echo"<div class='zag'><div class='css'><a href='?id=".$dir['id']."&del'>Удалить</a></div></div>";
}
echo "</div>";
 if(isset($_GET['del'])){
    if($cms->us['level']>=10){
 echo'<div class="news">Вы уверены что хотите удалить этот файл? (<a href="?id='.$dir['id'].'&del&da">Да</a>/<a href="?id='.$dir['id'].'">Нет</a>)</div>';
 if(isset($_GET['da'])){
 unlink('../downloads/'.$dir['root_name']);
 DB::$dbs->query("DELETE FROM `zc` where `id` = ? limit 1",array($dir['id']));
  header('location:/zc');
 }
 }else{echo '<div class="news"><b>Учебники собрал,Хацкер?</b></div>';}
 }
} 

else {


$count_zc1 = $func->getCount("id","`zc` where `dir_id` = '$dir_id'");

if($count_zc1 == 0){
     echo "<div class='menu'>Здесь пусто</div>";
} else {
// Пагинация 
    $num = 10;
$posts = $count_zc1;
$total = intval(($posts - 1) / $num) + 1;
$page = abs(intval($_GET['page']));
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;

# Проверка наличия файлов в папке
if ($func->getCount("id","`zc` where `dir_id` = '$dir_id' and `type` = '2'") > 0) {
     	 $sql = DB::$dbs->query("select * from `zc` where `dir_id` = '$dir_id' order by type asc, time desc, name asc limit $start, $num");
} else {
     $sql = DB::$dbs->query("select * from `zc` where `dir_id` = '$dir_id' order by type asc, name asc limit $start, $num");
}

// вывод данных
while($info = $sql->fetch()){
if($info['type'] == 1){
     $count = "(".$func->getCount("id","`zc` where `root_path` like '%$info[root_path]%' AND `id` != '$info[id]' and `type` = '2'").")";
} else {
     $count = '';
}
echo "<div class='news'>
<img src='/zc/icons/". ($info['file_ext'] != NULL?$info['file_ext']:'file') .".png' alt=''/> <a href='?id=$info[id]'>$info[name]</a> $count
</div>";
}

$func->page("?id=$dir_id&");
}




if($cms->us['id'] != 0 && $dir_id != 0){
    if($cms->us['level'] >= 10){
     echo "<div class='menu'><a href='/zc/add_file.php?id=$dir_id'>Загрузить файл</a></div>";
     }
}
if($cms->us['level'] >= 10){
     echo "<div class='menu'><a href='/zc/add_dir.php?id=$dir_id'>Создать папку</a></div>";
}
}
 niz(); 
  ?>