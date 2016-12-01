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

verh('Форум');

echo '<div class="munus"><div class="zag">Форум</div>';
 include '../system/funcs.php';

 echo '
 <div class="news">
 Темы: <a href="/forum/t_my.php">мои</a> | <a href="/forum/t_new.php">новые</a> | <a href="/forum/t_refs.php">обновленные</a><br>
 Сообщения: <a href="/forum/m_my.php">мои</a> | <a href="/forum/m_new.php">новые</a>
 </div>';
 
 
if($cms->us['level'] >= 8) echo '<div class="zag"><a href="/forum/nr">Новый раздел</a></div>';

 
 if($func->getCount('id','news')==0){ echo '<div class="zag">Разделов пока что нет...</div>'; }else{
															 
 $razd = DB::$dbs->query("SELECT * FROM `forum_razd` order by `pos` desc,`id`");
   while($r = $razd -> fetch()){
 
  echo'<div class="zag"><img src="/css/default/acn.gif"> <a href="/forum/razd'.$r['id'].'"><b>'.$r['name'].'</a> ('.DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `razd` = ?",array($r['id'])).'/'.DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `razd` = ?",array($r['id'])).')</b>';
  
  if($cms->us['level'] >= 8) echo ' [<a href="/forum/razd'.$r['id'].'/delete">уд</a>] [<a href="/forum/razd'.$r['id'].'/edit">ред</a>] [<a href="/forum/razd'.$r['id'].'/up">вверх</a>] [<a href="/forum/razd'.$r['id'].'/down">вниз</a>]';
  
  echo '</div>';
  
  
 $podrazd = DB::$dbs->query("SELECT * FROM `forum_podrazd` where `razd` = ? order by `pos` desc,`id`",array($r['id']));
   while($pr = $podrazd -> fetch()){
   
 echo '<div class="block_menu">- <a href="/forum/podrazd'.$pr['id'].'">'.$pr['name'].'</a> ('.DB::$dbs->querySingle("SELECT count(id) from `forum_themes` where `podrazd` = ?",array($pr['id'])).'/'.DB::$dbs->querySingle("SELECT count(id) from `forum_post` where `podrazd` = ?",array($pr['id'])).')';
 
 if($cms->us['level'] >= 8) echo ' [<a href="/forum/podrazd'.$pr['id'].'/delete">уд</a>] [<a href="/forum/podrazd'.$pr['id'].'/edit">ред</a>] [<a href="/forum/podrazd'.$pr['id'].'/up">вверх</a>] [<a href="/forum/podrazd'.$pr['id'].'/down">вниз</a>]';
 
 echo '</div>';
  
  }
     
   }
   
   echo '<div class="zag"><b><a href="/faq.php?go=smile">Смайлы</a> | <a href="/faq.php?go=bbcodes">ББ коды</a></b></div>';
                                                                                  }

 echo '</div>';
 niz();
 ?>