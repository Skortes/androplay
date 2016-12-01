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

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($razd == 0){header('location:/forum');}

verh('Раздел '.$razd['name']);

echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | '.$razd['name'].'</div>';

if($cms->us['level'] >= 8) echo '<div class="zag"><a href="/forum/razd'.$razd['id'].'/npr">Новый подраздел</a></div>';

 include '../system/funcs.php';

 if(DB::$dbs->querySingle("SELECT count(id) from `forum_podrazd` where `razd` = ?",array($razd['id']))==0){ echo '<div class="zag">Подразделов пока что нет...</div>'; }else{
 
 
 $podrazd = DB::$dbs->query("SELECT * FROM `forum_podrazd` where `razd` = ? order by `id`",array($razd['id']));
   while($pr = $podrazd -> fetch()){
   
 echo '<div class="zag"><a href="/forum/podrazd'.$pr['id'].'">'.$pr['name'].'</a> ('.DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `podrazd` = ?",array($pr['id'])).'/'.DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `podrazd` = ?",array($pr['id'])).')</div>';
  
 $themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `podrazd` = ? and `status` < ? order by `last_time` desc limit 1",array($pr['id'],3));
   while($thema = $themes -> fetch()){
 
   echo '<div class="block_menu"><img src="/forum/images/';
   
  switch($thema['status'])
  {
  case '0': echo 'open'; break;
  case '1': echo 'closed'; break;
  case '2': echo 'top'; break;
  } 
   
     $cp = DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `thema` = ?",array($thema['id']));
   
   echo '.png" alt="*"/> <a href="/forum/thema'.$thema['id'].'">'.$thema['name'].'</a> ('.$cp.') <a href="/forum/thema'.$thema['id'].'/page'.ceil($cp/10).'">>></a><br>
   '.$func->uNick($thema['author']).'/'.$func->uNick($thema['last_user']).' ('.t($thema['last_time']).')</div>';
   
  }
    
  }
  
  
   
 }

 echo '</div>';
 niz();
 ?>