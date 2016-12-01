<?php
define('_IN_JOHNCMS', 1);
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');

function data($path,$host) 
{  
 $fp = fsockopen($host, 80); 
 if (!$fp) 
 { 
 die('ошибка'); 
 } 
 else 
 { 
 $out = "GET $path HTTP/1.0\r\n"; 
 $out .= "Accept: image/gif, application/xhtml+xml, */*\r\n"; 
 $out .= "Accept-Language: ru\r\n"; 
 $out .= "Host: $host\r\n"; 
 $out .= "User-Agent: Opera/8.01 (J2ME/MIDP; Opera Mini/2.0.4509/1716; ru; U; ssr)\r\n"; 
 $out .= "Cache-Control: no-cache\r\n"; 
 $out .= "Connection: Close\r\n\r\n"; 

 fwrite($fp, $out); 
 $headers = "http://service.mobik.ru/humor/anekdot/?"; 

 while ($str = trim(fgets($fp))) 
 $headers .= "$str\n"; 
 $body = ""; 

 while (!feof($fp)) 
 $body .= fgets($fp); 
 fclose($fp); 
 } 
 return $body; 
} 


/* 
function process($s) 
{ 

return $s; 
} 
*/ 

$host='service.mobik.ru'; 

if (empty($_SERVER['QUERY_STRING'])) 
{ 
 $path='/humor/anekdot/'; 
} 
else 
{ 
 $path='/humor/anekdot/?'.$_SERVER['QUERY_STRING']; 
} 

$s=data($path,$host); 

$s=process($s); 

header('Content-type:text/html;charset=utf-8'); 
echo $s; 

function process($s) 
{ 
 $s=str_replace('<a href="/humor/anekdot/','<a href="'.$_SERVER['SCRIPT_NAME'],$s); 
$s=preg_replace('|<div class="menu_blue">(.*?)</html>|is','',$s);
$s=preg_replace('|<div class="blue_line">|is','<div class="phdr">',$s);
$s=preg_replace('|<div class="menu_blue_a">|is','<div class="menu">',$s);
$s=preg_replace('|{literal}(.*?){/literal}|is','',$s);

 return $s; 
} 

echo $file;
require_once ('../incfiles/end.php');
?>