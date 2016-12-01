<?
class funcs {
 function getCount($w,$tab){
                     return DB::$dbs->querySingle("SELECT count(".$w.") from ".$tab."");
					      }
	function text($text){
	 $text = sm(bb(br(links($text))));
	  return $text;
	                    }
                        

                        

		function uNick($id){
		  $online = DB::$dbs->queryFetch("SELECT `on` FROM `set`");
		  $nick = DB::$dbs->queryFetch("SELECT `nick`,`sex`,`last`,`color`,`level` from `us` where `id` = ? limit 1",array($id));
 if($nick['level']==6){$nick['level']='<small><font color="blue">[Модер]</font></small>';
}elseif($nick['level']==7){$nick['level']='<small><font color="blue">[Ст.модер]</font></small>';}
elseif($nick['level']==8){$nick['level']='<small><font color="red">[Админ]</font></small>';}
elseif($nick['level']==9){$nick['level']='<small><font color="red">[Ст.админ]</font></small>';}
elseif($nick['level']==10){$nick['level']='<small><font color="red">[Соз]</font></small>';}
else {$nick['level']='';}
		   return '<img src="/css/img/'.($nick['last']<time()-$online['on']?''.($nick['sex']=='Муж'?'mof.png"':'jof.png"').'':''.($nick['sex']=='Муж'?'mon.png"':'jon.png"').'').' alt="*"/> <a href="/us'.$id.'"><b><span style="color:'.$nick['color'].';">'.$nick['nick'].'</span>  </b></a>'.$nick['level'].'';
		                   }
                           
                           function uBick($id){
		  $nick = DB::$dbs->queryFetch("SELECT `nick`, `color`, `last` from `us` where `id` = ? limit 1",array($id));
                  
		   return '<a href="/us'.$id.'"><b><span style="color:'.$nick['color'].';">'.$nick['nick'].'</span></b></a>';
		                   }
                           function NickI($id){
		  $nick = DB::$dbs->queryFetch("SELECT `nick`,`sex`,`last` from `us` where `id` = ? limit 1",array($id));
		   return '<img src="/css/img/'.($nick['last']<time()-3600?''.($nick['sex']=='Муж'?'mof.png"':'jof.png"').'':''.($nick['sex']=='Муж'?'mon.png"':'jon.png"').'').' alt="*"/>';
		                   }

function makestime($time)
{
    $day = floor($time / 86400);
    $hours = floor(($time / 3600) - $day * 24);
    $min = floor(($time - $hours * 3600 - $day * 86400) / 60);
    $sec = $time - ($min * 60 + $hours * 3600 + $day * 86400);

    return sprintf('%01d дн %02d час %02d мин %02d сек', $day, $hours, $min, $sec);
} 
                           
						   
						function page($param){
						global $page,$total;
						if ($page != 1) $pervpage = '<a href="'.$param.'page=1"><<</a>  
                               <a href="'.$param.'page='.($page-1).'"><</a> ';  
if ($page != $total) $nextpage = ' <a href="'.$param.'page='.($page+1).'">></a>  
                                   <a href="'.$param.'page='.$total.'">>></a>';  
if($page - 2 > 0) $page2left = ' <a href="'.$param.'page='. ($page - 2) .'">'. ($page - 2) .'</a> | ';  
if($page - 1 > 0) $page1left = '<a href="'.$param.'page='. ($page - 1) .'">'. ($page - 1) .'</a> | ';  
if($page + 2 <= $total) $page2right = ' | <a href="'.$param.'page='. ($page + 2) .'">'. ($page + 2) .'</a>';  
if($page + 1 <= $total) $page1right = ' | <a href="'.$param.'page='. ($page + 1) .'">'. ($page + 1) .'</a>'; 
echo '<div class="main">Стр. '.$pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage.'</div>'; 
						
						}
						function num($num){
						return abs(intval($num));
						}
						
				function flood($how,$sec,$what){
				   switch($how) {
    case 'sec':
    return $sec-(time()-intval($what)).' секунд';
    break; 
    case 'min':
    return substr((floatval((1-1)-(time()-intval($what))/60)+($sec/60)),0,3).' минут';
    break; 
	default: return $sec; break;
				
				}
		      }
			      }
$func = new funcs;
?>