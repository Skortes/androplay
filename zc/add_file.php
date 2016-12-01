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
  verh('Новый файл');
if($cms->us['id'] != 0 && $dir_id != 0){
    if($cms->us['level'] >= 10){


// Создаем массив с данными папки
     $dir = DB::$dbs->query("select * from `zc` where `id` = '$dir_id' limit 1")->fetch();
     $root_path = $dir['root_path'];


if(isset($_POST['upl'])){
   
     $name = secure($_POST['name']);
	 $file = basename($_FILES['file']['name']);
	 if(empty($name) || empty($file)){
	     echo "<div class='news'>Пустые поля</div>";
	 } else {
	  
       
	 $ext = explode(".",$file);
if(!in_array($ext,$filetype)) $cms->error = 'Вы пытаетесь загрузить недопустимый формат файла...';
	  $ext = end($ext);
       $about = secure($_POST['about']);
	     $new_name = "".$_SERVER['SERVER_NAME']."_".$file."";
	 $root_path1 = $_SERVER['DOCUMENT_ROOT'].'/zc/downloads/'. $root_path. $new_name;
		 if(copy($_FILES['file']['tmp_name'],$root_path1)){
		     DB::$dbs->query("INSERT INTO `zc` SET
			 `dir_id`  = '$dir_id',
			 `root_path` = '$root_path',
			 `type` = '2',
			 `name` = '$name',
			 `root_name` = '$new_name',
			 `time` = '".time()."',
             `about` = '$about',
			 `user_id` = '".$cms->us['id']."',
			 `file_ext` = '$ext'");
			 header("location: /zc/?id=$dir_id");
		 } else {
		     echo "<div class='news'>Ошибка загрузки файла на сервер</div>";
		 }
	 }
}


  	echo "<div class='news'><a href='/zc?id=$dir_id'>Назад</a> </div>
	<form action='' enctype='multipart/form-data' method='post'>
	<div class='menu'>
	Имя файла:<br />
	<input type='text' name='name'/><br />
    Описание:<br/>
    <textarea type='text' name='about'>$dir[about]</textarea><br/>
	Файл:<br />
	<input type='file' name='file'/><br />
	<input type='submit' name='upl' value='Загрузить'/>
	</div>
	</form>";
  

} else {
  echo "Access Denied!";
} 
} else {
  echo "Access Denied!";
} 
niz();
?>