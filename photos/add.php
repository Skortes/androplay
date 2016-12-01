<?
$title = 'Добавление фотографии';
  
include_once '../inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['galer']==0){header('location:../');}

 if(!$cms->us['id']){header('location:/');}
 echo'<div class="main"><form action="?add" method="POST" ENCTYPE="multipart/form-data">
 Фото: <input type="file" name="photo"><br/>
 Описание: <input type="text" name="opis"/><br/>
 <input type="radio" name="osn" value="1"/> анкетная<br/>
 <input type="submit" value="Добавить">
 </form></div>';
 if(isset($_GET['add'])){
 $name = 'files/'.time().rand(100,999).'.jpg';
 $opis = secure($_POST['opis']);
 $osn = abs(intval($_POST['osn']));
 if($_FILES['photo']['size'] != 0 and $_FILES['photo']['size']<=1024000) {
 if (move_uploaded_file($_FILES['photo']['tmp_name'], $name)) {
 $size = getimagesize($uploadfile);
 if ($size[0] < 601 && $size[1]<2001) {
  if(DB::$dbs->querySingle("SELECT count(id) from `photos` where `us` = ? and `osn` = ?",array($cms->us['id'],1))==1 and $osn == 1){ DB::$dbs->query("UPDATE `photos` set `osn` = ? where `us` = ? and `osn` = ? limit 1",array(0,$cms->us['id'],1));}
 DB::$dbs->query("INSERT INTO `photos` set `us` = ?, `path` = ?, `date` = ?, `osn` = ?, `opis` = ?",array($cms->us['id'],$name,time(),$osn,$opis)); echo'<div class="main">Фотография добавлена!</div>'; header('refresh:1; url=/photos');
 }else{ echo'<div class="main">Выбранное изображение слишком большое...</div>';
 unlink($name);}
 }else{ echo'<div class="main">Не удалось загрузить изображение...</div>'; }
 }else{echo'<div class="main">Вы не выбрали файл, или выбранный вами файл весит больше 1мб.</div>';}
 
 }
include_once '../inc/foot.php';
 ?>