<?
include_once '../system/sys.php';

include '../system/funcs.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['zc']==0){header('location:../');}
  error_reporting(E_ALL);
  // Записываем ID папки в переменную
$dir_id = (int)$_GET['id'];
// Проверяем существование папки по ID
if($func->getCount("id","`zc` where `id` = '$dir_id'") == 0){
     $dir_id = 0;
}
  verh('Создание папки');
if($cms->us['level'] >= 8){


// Создаем массив с данными папки
if ($dir_id != 0) {
     $dir = DB::$dbs->query("select * from `zc` where `id` = '$dir_id' limit 1")->fetch();
     $root_path = $dir['root_path'];
} else {
     $root_path = '/';
}


if(isset($_POST['add'])){
$name = secure($_POST['name']);
$root_name = secure($_POST['root_name']);
     if(empty($name) || empty($root_name)){
	     echo "<div class='news'>Пустые поля</div>";
	 } elseif(!preg_match("#^([A-z0-9\-\_])+$#ui", $root_name)) {
	     echo "Запрещенные символы в имени на сервере. Разрешены символы A-z0-9-_";
	 } elseif(!is_dir($_SERVER['DOCUMENT_ROOT'].'/zc/downloads/'. $root_path . $root_name)) {
	     $root_path1 = $_SERVER['DOCUMENT_ROOT'].'/zc/downloads/'. $root_path . $root_name;
         $root_name1 = $root_path . $root_name .'/';
		 if(DB::$dbs->query("INSERT INTO `zc` (`id`, `dir_id`, `root_path`, `type`, `name`, `root_name`, `time`, `user_id`, `file_ext`) VALUES (NULL, '$dir_id', '$root_name1', '1', '$name', '$root_name', '". time() ."', '".$cms->us['id']."', 'dir')")){
		    
			 mkdir($root_path1, 0777);
			 header("location: /zc/?id=$dir_id");
		 } else {
		     echo "Произошла ошибка при создании папки";
		 }
    
	 } else {
	     echo "Папка с серверным именем существует";
	 }
}



  	echo "<div class='news'><a href='/zc?id=$dir_id'>Назад</a> </div>
	<form action=''  method='post'>
	<div class='menu'>
	Отображаемое имя:<br />
	<input type='text' name='name'/><br />
	Имя на сервере:<br />
	<input type='text' name='root_name'/><br />
	<input type='submit' name='add' value='Создать'/>
	</div>
	</form>";
  
  
} else {
  echo "Access Denied!";
} 
niz();
?>