<?php
$title = 'Бесплатные мобильные закачки |AndroPlay.PW ';
include '../inc/head.php';
include 'conf.php';
ini_set('display_errors',0); ini_set ('register_globals', 0); 
session_name('SID'); session_start(); 
$host= "tegos.ua"; $path="/android/".$_SERVER ['QUERY_STRING']; 
$fp=fsockopen($host,80,$errno, $errstr,10); 
if(!$fp) { echo "$errstr ($errno)<br/>\n"; }else{ 
$data = "";$post=0; foreach($_POST as $key=>$value){ 
$post=1; $data.="&$key=$value";} if($data)$data=substr ($data,1); 
if($post) $headers = "POST $path HTTP/1.0\r\n";else 
$headers = "GET $path HTTP/1.0\r\n"; $headers.= "Host: $host\r\n"; 
$headers.= "Accept: text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/jpeg, image/gif,image/x-bitmap, */*;q=0.1\r\n"; 
$headers.= "Accept-Charset: utf-8;q=0.6 windows-1251;q=0.1*;q=0.1\r\n"; 
$headers.= "Accept-Encoding: utf-8\r\n"; 
$headers.= "Accept-Language: ru, en;q=0.9\r\n"; 
$headers.= "User-Agent: ".$_SERVER ['HTTP_USER_AGENT']."\r\n"; 
if($post){ $headers.= "Content-type: application/x-www-form-urlencoded\r\n"; 
$headers.= "Content-Length: ".strlen ($data)."\r\n"; 
$headers.= "\r\n"; $headers.= $data;}else $headers.="\r\n"; 
@fwrite($fp, $headers); while($file != "\r\n") $file = @fgets($fp, 128); 
$file = ''; while(!feof($fp)) $file.= @fgets($fp, 4096); @fclose($fp); } 
$page = htmlspecialchars($_GET['page']);
$file=str_replace('<a href="/android/best/?f=UC_Browser.apk', '999max', $file);
$file=preg_replace('|999max(.*?)>|is', '',$file);
$file=str_replace('?f=', '', $file);
$file=str_replace('от Tegos', '', $file);
$file=str_replace('<a href="/android/exclusiv/"><div class="i c1 ">Игры с кэшем</div></a>', '', $file);
$file=str_replace('TEGOS Free', '', $file);
$file=str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $file);
$file=str_replace('&amp;page=0&amp;sort=mysort', '', $file);
preg_match_all('#<a href="/android/(.*)">(.*)">(.*)<#sU',$file,$nav);
if($nav[1]){
//echo '<div class="title">Игры и приложения (Android)</div>';
for($i=0; $i<count($nav[1]); $i++){
//echo ''.$div2.'<div class="forlink"><a href="'.$papka.'android/cat/'.$nav[1][$i].'" class="links"><img src="/img/ico.png"> '.$nav[3][$i].'</a></div>';
}
}else{
}
preg_match_all('#<div class="i"><a href="(.*)"><img style="width: 48px; height: 48px;" src="../(.*)"(.*)<div class="g">(.*)<#sU',$file,$cat);
if($cat[1]){
echo '<div class="razd">Игры и приложения (Android)</div>';
for($i=0; $i<count($cat[1]); $i++){
echo ''.$div2.'<div class="menu"><a href="'.$cat[1][$i].'" class="links"><img src="'.$papka.'down/'.$cat[2][$i].'" class="links"/> '.$cat[4][$i].'</a></div>';
}
}else{
}
preg_match_all('#<img src="../next.png"(.*)">#sU',$file,$pages);
if($pages[1]){
for($i=0; $i<count($pages[1]); $i++){
}

if($page==0){
    $page = '<div class="main"><div class="navi"><center> <a href="?page='.($page + 1).'">Далее &rarr;</a><br> </center></div></div>';
}else{

$page = '<div class="main"><div class="navi"><center><a class="button" href="?page='.($page - 1).'">&larr; Назад</a> <span>'.($page + 0).'</span> <a class="button" href="?page='.($page + 1).'">Далее &rarr;</a><br/> </center></div></div>';
} 
echo ''.$navi.'<div class="menu44">'.$page.'</div>';
}else{

preg_match('#B1CC47;">(.*)<#sU',$file,$fail);
if($fail[1]){
echo ''.$title.'<div class="razd">'.$fail[1].'</div>';
}else{
}
?>
<style type="text/css">
   .zoom:hover { zoom: 2; }
</style>
<?
preg_match('#<img class="screen" src="../(.*)"#sU',$file,$screen);
if($screen[1]){
echo ''.$div2.'<div class="main"><img width="260px" src="'.$papka.'down/'.$screen[1].'"class ="zoom" "
/></div></div>';
?><div class="main">
   <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?130"></script>

<script type="text/javascript">
  VK.init({apiId: 5646262, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "mini", height: 18});
</script>


    </div>
    <?

}else{
}
preg_match('#<div style="padding: 5px;">(.*)<#sU',$file,$text);
if($text[1]){
echo ''.$div2.'<div class="main">'.$text[1].'</div></div>';
    echo'
<div class="main"><script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,linkedin,viber,whatsapp,skype,telegram"></div></div>';
}else{
}
preg_match('#<div class="starrate"(.*)</small>(.*)href="(.*)"(.*)</a>(.*)<#sU',$file,$loads);
$loads[3]=str_replace('amp;', '', $loads[3]);
$array = explode('/', $_SERVER['REQUEST_URI']);
$fff='/?f=';
if($loads[1]){

echo ''.$div2.'<div class="menu"><a href="'.$papka.'down/'.$array[3].''.$fff.''.$loads[3].'">Загрузить ('.$loads[5].')</a></div></div>';
    ?><div class="main">
   <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?130"></script>

<script type="text/javascript">
  VK.init({apiId: 5646262, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 15, width: "370", attach: "*"});
</script>
    </div>
    <?

}else{
}
}
$file=preg_replace('|<!DOCTYPE(.*?)</html>|is', '',$file);
echo $file;
include '../inc/foot.php';
?>