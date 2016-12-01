<?php

/*
/////////////////////////////////////////////////////////////////////////////////
// Модуль: Авто добавление Новостей  V1.0 beta                                //
// Автор:   Abdusamad Dilmurodov (Ulty)                                 //
// icq:     56628086                                                          //
// e-mail: wm.ulty@gmail.com                                                  //
////////////////////////////////////////////////////////////////////////////////
*/

include 'connect.php';
include 'head.php';
echo '<div class="'.$menu.'">';

function curl_get($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.2.15 Version/10.10');
    curl_setopt($curl, CURLOPT_REFERER, "http://google.com");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    $cnt = curl_exec($curl);
    curl_close($curl);
    return $cnt;
}

$url = 'http://wap.vesti.ru';
$page = curl_get($url);

preg_match_all("|<a href=\"/doc.wml\?id=(.*)\">(.*)</a></small>|Uis", $page, $out);
unset($out[0]);
$i = 0;
foreach ($out[1] as $key => $ids) {
    if ($i == 20) break;
               $totalfile = mysql_result(mysql_query("SELECT COUNT(*) FROM `ultynews` WHERE `ulty` = '".$out[1][$key]."'"), 0);
if ($totalfile == 0) {
     $name[1] = $out[2][$key];
     $id = $ids;
     echo '(' . $ids . ') <a href="view.php?id='.$id.'"><b>' . $name[1] . '</b></a><br />';
}
    $i++;
}
if (!empty($id)) {
$urls = 'http://wap.vesti.ru/doc.wml?id=' . $id;
$pages = curl_get($urls);
preg_match_all("|<small>(.*)</small>|Uis", $pages, $outs);

unset($outs[0]);
if (strlen($outs[1][1])) {
    echo $outs[1][1] . ''; 
        echo $outs[1][1] . ''; 
        $time = time()-rand(60, 249);
  					mysql_query("INSERT INTO `ultynews` SET
					`name` = '" . mysql_real_escape_string($name[1]) . "',
					`text` = '" .$outs[1][1] . "',
					`ulty` = '" . $id . "',
					`time` = '" . time() . "'");
 echo '<font color="red">OK</font>';
}
}
echo '</div>';
include 'foot.php';
?>