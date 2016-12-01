<?

$title = 'Чат';
include '../inc/head.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['chat']==1){
 
   include '../inc/funcs.php';
   echo'<div class="menu1"><img src="/css/img/js_l1.png" alt="*"/> <b>Комнаты ('.$func->getCount('id','chat_rooms').')</b> </div>';
    if($func->getCount('id','chat_rooms')==0){echo'<div class="main">Комнат пока нет...</div>';}else{
	 $rooms = DB::$dbs->query("SELECT id,name,opis from `chat_rooms` order by `pos` desc");
	  while($room = $rooms -> fetch()){
	    echo '<div class="menu"><img src="/css/img/balloon.gif" alt="*"/> <a href="chat.php?room='.$room['id'].'">'.$room['name'].'</a> (<a href="chat.php?room='.$room['id'].'&who">'.DB::$dbs->querySingle("SELECT count(id) from `chat_kto` where `room` = ? and `last` > ?",array($room['id'],time()-120)).'</a>/'.DB::$dbs->querySingle("SELECT count(id) from `chat_msg` where `room` = ?",array($room['id'])).') <br/><span style="font-size:small;color:#666666">'.$func->text($room['opis']).'</span>';
		if(isset($_GET['who'])){ echo'<br/>';
		    $peop = DB::$dbs->query("SELECT us from `chat_kto` where `last` > ? and `room` = ? order by `last` desc",array(time()-120,$room['id']));
  while($pe = $peop -> fetch()){
   echo $func->uNick($pe['us']).', ';
   }
		}
		echo'</div>';
	  
	                                  }
echo'<div class="menu"><img src="/css/img/newsp.png" alt="*"/> <a href="rules.php"><span style="color:#336633">Правила чата</span></a><br /></div>';
                                                                                         }
     }else{header('location:/');}                                                                                      
  include '../inc/foot.php';
?>