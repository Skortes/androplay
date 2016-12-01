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

 $podrazd = DB::$dbs->queryFetch("SELECT * FROM `forum_podrazd` where `id` = ? limit 1",array(abs(intval($_GET['id']))));
  if($podrazd == 0){header('location:/forum');}

 $razd = DB::$dbs->queryFetch("SELECT * FROM `forum_razd` where `id` = ? limit 1",array(abs(intval($podrazd['razd']))));

verh('Подраздел '.$podrazd['name'].'');


echo '<div class="munus"><div class="zag"><a href="/forum">Форум</a> | <a href="/forum/razd'.$razd['id'].'">'.$razd['name'].'</a> | '.$podrazd['name'].'</div>';
 include '../system/funcs.php';

 echo '<div class="zag"><a href="/forum/nt'.$podrazd['id'].'">Новая тема</a></div>';

 if(DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `podrazd` = ?",array($podrazd['id']))==0){ echo '<div class="zag">Тем пока что нет...</div>'; }else{
 
   
 $themes = DB::$dbs->query("SELECT * FROM `forum_themes` where `podrazd` = ? and `status` < ? order by `zak` desc,`last_time` desc",array($podrazd['id'],3));
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
  
 
 echo '<div class="zag"><b><a href="/forum/rules'.$podrazd['id'].'">Правила подраздела</a></b></div></div>';
 niz();
 ?>