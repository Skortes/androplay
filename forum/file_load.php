<?
/* Разработчики KingCMS: MrDeath, PaRaDoX
   Офф. дизайнер: МАНЬЯК_ЧИКАТИЛО
   Офф. сайт: http://profiwm.ru 
   Офф. пример: http://kingcms.ru
   ICQ: 1503915
  Кидаем на развитие сюда R218687575965 */

include_once '../system/sys.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['forum']==0){header('location:../');}
if(!isset($cms->us['id'])){header('location:/error.php?user');}

 $file = DB::$dbs->queryFetch("SELECT * FROM `forum_file` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($file == 0){header('location:/forum');}

 $post = DB::$dbs->queryFetch("SELECT * FROM `forum_post` where `id` = ? limit 1",array(abs(intval($file['post']))));

 $thema = DB::$dbs->queryFetch("SELECT * FROM `forum_themes` where `id` = ? limit 1",array(abs(intval($post['thema']))));

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($thema['podrazd']))));

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($thema['razd']))));


verh($thema['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | <a href="/forum/podrazd'.$podrazd['id'].'">'.$podrazd['name'].'</a> | '.$thema['name'].'</div>';

 include '../system/funcs.php';

 echo '<div class="block_menu">Файл: <b>'.$file['file'].'</b></div>
 <div class="news">';

  $imgtype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' );
 
  $filetype = substr($file['file'],  strrpos( $file['file'], "." )+1);  
   
  if(in_array($filetype,$imgtype))
  {
  
  echo '<a href="/forum/files/'.$file['file'].'"><img src="/forum/files/'.$file['file'].'" alt="'.$file['file'].'" width="150px" height="150px"/></a>
  <br><b>Вес: '.round(filesize('files/'.$file['file'].'')/1024).' кб | Просмотров: '.$file['loads'].'</b>';


  DB::$dbs->query("UPDATE `forum_file` set `loads` = `loads`+1 where `id` = ?",array($file['id']));


  }elseif(in_array($upfiletype,$txttype))
  {
  
  
  }else
  {
  
  echo 'Формат файла не поддерживается данной версией форума.
 
  <br><b><a href="/forum/files/'.$file['file'].'">Скачать</a> ('.round(filesize('files/'.$file['file'].'')/1024).' кб) (скачали '.$file['loads'].' раз.)</b>';
 
  }
   
 if(isset($_GET['download']))
 {
 
  DB::$dbs->query("UPDATE `forum_file` set `loads` = `loads`+1 where `id` = ?",array($file['id']));
  header('location:files/'.$file['file']);
 
 }
 
 echo '</div><div class="block_menu">
 
 <a href="/forum/thema'.$thema['id'].'">Вернуться</a>
 
 </div>';

 echo '</div>';
 niz();
 ?>