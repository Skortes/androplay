<?
//имя базы
$dbn = 'skortesr_android';

//имя сервера
$dbh = 'localhost';

//порт
$dbr = '3306';

//имя пользователя
$dbu = 'skortesr_android';

//пароль
$dbp = 'Lenovo11';


  ob_start();
  session_name('sid');
  @session_start();
  define ('DBHOST', "$dbh");
  define ('DBPORT', "$dbr");
  define ('DBNAME', "$dbn");
  define ('DBUSER', "$dbu");
  define ('DBPASS', "$dbp");
if (!class_exists('PDO'))
                   die('Fatal Error: Для работы нужна поддержка PDO');
class PDO_ extends PDO {
function __construct($dsn, $username, $password) {
parent :: __construct($dsn, $username, $password);
$this -> setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
$this -> setAttribute(PDO :: ATTR_DEFAULT_FETCH_MODE, PDO :: FETCH_ASSOC);
}

function prepare($sql) {
$stmt = parent :: prepare($sql, array(
PDO :: ATTR_STATEMENT_CLASS => array('PDOStatement_')
));
return $stmt;
}
function query($sql, $params = array()) {
$stmt = $this -> prepare($sql);
$stmt -> execute($params);
return $stmt;
}
function querySingle($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
$stmt -> execute($params);
return $stmt -> fetchColumn(0);
}
function queryFetch($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
$stmt -> execute($params);
return $stmt -> fetch();
}
}
class PDOStatement_ extends PDOStatement {
function execute($params = array()) {
if (func_num_args() == 1) {
$params = func_get_arg(0);
} else {
$params = func_get_args();
}
if (!is_array($params)) {
$params = array($params);
}
parent :: execute($params);
return $this;
}

function fetchSingle() {
return $this -> fetchColumn(0);
}

function fetchAssoc() {
$this -> setFetchMode(PDO :: FETCH_NUM);
$data = array();
while ($row = $this -> fetch()) {
$data[$row[0]] = $row[1];
}
return $data;
}
}
class DB {
static $dbs;
public function __construct() {
try {
self :: $dbs = new PDO_('mysql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME, DBUSER, DBPASS);
self :: $dbs -> exec('SET CHARACTER SET utf8');
self :: $dbs -> exec('SET NAMES utf8');
}
catch (PDOException $e) {
die('Connection failed: ' . $e -> getMessage());
}
}
}
$array = explode(" ",microtime());
$gen = $array[1] + $array[0];
$db = new DB();
DB::$dbs->query("SET NAMES utf8");

class cms {
var $us;
}
function links_preg1($arr){
		global $set;

		if(ereg('^http://'.$_SERVER['HTTP_HOST'],$arr[1])){
			return '<a href="'.$arr[1].'">'.$arr[2].'</a>';
			}else{
				return '<a href="'.$arr[1].'">'.$arr[2].'</a>';
				}
		}

	function links_preg2($arr){
		global $set;

		if(ereg('^http://'.$_SERVER['HTTP_HOST'],$arr[2])){
			return $arr[1].'<a href="'.$arr[2].'">'.$arr[2].'</a>'.$arr[4];
			}else{
				return $arr[1].'<a href="'.$arr[2].'">'.$arr[2].'</a>'.$arr[4];
				}
		}

function br($msg,$br='<br />')
{
$msg=eregi_replace("((<br( ?/?)>)|\n|\r)+",$br, $msg);
return $msg;
}

function bb($msg)
{
    $bbcode = array(
    '/\[url\](.+)\[\/url\]/isU'=>'<a href="$1">$1</a>',
	'/\[url=(.+)\](.+)\[\/url\]/isU'=>'<a href="$1">$2</a>',
	'/\[i\](.+)\[\/i\]/isU' => '<em>$1</em>',
	'/\[b\](.+)\[\/b\]/isU' => '<strong>$1</strong>',
	'/\[u\](.+)\[\/u\]/isU' => '<span style="text-decoration:underline;">$1</span>',
	'/\[big\](.+)\[\/big\]/isU' => '<span style="font-size:large;">$1</span>',
	'/\[small\](.+)\[\/small\]/isU' => '<span style="font-size:xx-small;">$1</span>',
	'/\[code\](.+)\[\/code\]/isU' => '<code>$1</code>',
	'/\[red\](.+)\[\/red\]/isU' => '<span style="color:#ff0000;">$1</span>',
	'/\[green\](.+)\[\/green\]/isU' => '<span style="color:#00bb00;">$1</span>',
	'/\[blue\](.+)\[\/blue\]/isU' => '<span style="color:#0000bb;">$1</span>',
	'/\[white\](.+)\[\/white\]/isU' => '<span style="color:#ffffff;">$1</span>',
	'/\[img\](.+)\[\/img\]/isU' => '<a href="$1"><img src="$1" alt="" width="250" height="150" /></a>',
	);
    $msg= preg_replace(array_keys($bbcode), array_values($bbcode), $msg);


$msg=preg_replace_callback('#&lt;\?(.*?)\?&gt;#sui', 'bbcodehightlight', $msg);
$msg=preg_replace('#\[code\](.*?)\[/code\]#si', '\1', $msg);

return $msg;
}

// ----------- Смайлы -------------//
# пример добавления: $msg=str_replace(":lol","<img src='/css/smile/lol.gif' alt='lol'/>",$msg);
function sm($msg){
$msg=str_replace(":)","<img src='/css/smile/smile.gif' alt=':)'/>",$msg);
$msg=str_replace(":(","<img src='/css/smile/2.gif' alt=':('/>",$msg);
$msg=str_replace(";)","<img src='/css/smile/3.gif' alt=';)'/>",$msg);
$msg=str_replace(":P","<img src='/css/smile/4.gif' alt=':P)'/>",$msg);
$msg=str_replace(".крут.","<img src='/css/smile/5.gif' alt='крут'/>",$msg);
$msg=str_replace(":D","<img src='/css/smile/6.gif' alt=':D'/>",$msg);
$msg=str_replace(".ахах.","<img src='/css/smile/1.gif' alt=':ахах'/>",$msg);
$msg=str_replace(".покраснел.","<img src='/css/smile/7.gif' alt='покраснел'/>",$msg);
$msg=str_replace("0_о","<img src='/css/smile/8.gif' alt='0_о'/>",$msg);
$msg=str_replace(".фак.","<img src='/css/smile/40.gif' alt='фак'/>",$msg);
return $msg;
}


function links($msg){
		$msg=preg_replace_callback('~\[url=([a-z]+://[^ \r\n\t`\'"]+)\](.*?)\[/url\]~iu', 'links_preg1', $msg);
		$msg=preg_replace_callback('~(^|\s)([a-z]+://([^ \r\n\t`\'"]+))(\s|$)~iu', 'links_preg2', $msg);
		return $msg;
		}
        

function secure($mess){
$mess=htmlspecialchars(trim($mess));
return $mess;
}
error_reporting(0);
if(DB::$dbs->querySingle("SELECT count(id) FROM `us` where `id` = ?",array(intval($_COOKIE['username'])))==1){
$password = secure($_COOKIE['password']);
$cms->us = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ? and `pass` = ? limit 1",array(intval($_COOKIE['username']),$password));
if($cms->us['pass']==$password && $cms->us['id'] == intval($_COOKIE['username'])){
DB::$dbs->query("UPDATE `us` SET `last` = ?, `ip`=?, `soft` = ? WHERE `id` = ? limit 1",array(time(),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$cms->us['id']));
} }
if(!isset($cms->us['nick'])){
if(DB::$dbs->querySingle("SELECT count(id) FROM `guests` where `ip` = ?",array($_SERVER['REMOTE_ADDR']))==1){
DB::$dbs->query("UPDATE `guests` set `last` = ? where `ip` = ? limit 1",array(time(),$_SERVER['REMOTE_ADDR']));
}else{
DB::$dbs->query("INSERT INTO `guests` SET `ip`=?, `soft`=?, `last` = ?",array($_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],time()));
}
}
function slv($str,$msg1,$msg2,$msg3) {
$str = (int)$str;
$str1 = abs($str) % 100;
$str2 = $str % 10;
if ($str1 > 10 && $str1 < 20) return $str .' '. $msg3;
if ($str2 > 1 && $str2 < 5) return $str .' '. $msg2;
if ($str2 == 1) return $str .' '. $msg1;
return $str .' '. $msg3;
}
function t($times=NULL){
global $db;
$time = time();
if(($time-$times)<=60){
$timesp = slv((($time-$times)),'секунду','секунды','секунд').' назад';
return $timesp;
}else if(($time-$times)<=3600){$timesp = slv((($time-$times)/60),'минуту','минуты','минут').' назад';
return $timesp;
}else{
$today = date("j M Y", $time);
$today = date("j M Y", $time);
$yesterday = date("j M Y", strtotime("-1 day"));
$timesp=date("j M Y  в H:i", $times);
$timesp = str_replace($today, 'Сегодня', $timesp);
$timesp = str_replace($yesterday, 'Вчера', $timesp);
$timesp = strtr($timesp, array ("Jan" => "Янв","Feb" => "Фев","Mar" => "Марта","May" => "Мая","Apr" => "Апр","Jun" => "Июня","Jul" => "Июля","Aug" => "Авг","Sep" => "Сент","Oct" => "Окт","Nov" => "Ноября","Dec" => "Дек",));
return $timesp;}

}

function ti($times=NULL){
global $db;
$time = time();
if(($times-$time)<=60){
$timesp = slv((($times-$time)),'секундa','секунды','секунд').'';
return $timesp;
}else if(($times-$time)<=3600){$timesp = slv((($times-$time)/60),'минутa','минуты','минут').'';
return $timesp;
}else{
$today = date("j M Y", $time);
$today = date("j M Y", $time);
$yesterday = date("j M Y", strtotime("-1 day"));
$timesp=date("j M Y  в H:i", $times);
$timesp = str_replace($today, 'Сегодня', $timesp);
$timesp = str_replace($yesterday, 'Вчера', $timesp);
$timesp = strtr($timesp, array ("Jan" => "Янв","Feb" => "Фев","Mar" => "Марта","May" => "Мая","Apr" => "Апр","Jun" => "Июня","Jul" => "Июля","Aug" => "Авг","Sep" => "Сент","Oct" => "Окт","Nov" => "Ноября","Dec" => "Дек",));
return $timesp;}

} 


ini_set('magic_quotes_gpc', 0);
ini_set('magic_quotes_runtime', 0);



echo '<!DOCTYPE html><meta name="viewport" content="width=device-width; minimum-scale=1; maximum-scale=1"/>
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="stylesheet" href="/css/css.css" type="text/css"/>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="keywords" content="телефон, планшет, игры, мобильный, android, андроид, iphone, ipad, java, symbian, живые обои, рингтоны, картинки, темы">
	 <meta name="description" content="Лучший мобильный контент на AndroPlay.Ml.Новинки игр на Андроид.Каталог живых обоев, рингтонов, картинок и тем на телефоны и планшеты."> 
   <meta name="yandex-verification" content="d2899b5d530e30f4" />
<meta name="copyright" content="AndroPlay.Ml">
<meta http-equiv="content-language" content="ru">
<meta http-equiv="revisit-after" content="12 month">
<title>'.$title.'</title></head><body>';
?>
    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $("#login-form-btn").on('click', function () {
                var login = $('#login');
                var password = $('#password');
                var result = $("#result");
                if (login.val() != '') {
                    result.html('Вы указали логин: <b>' + login.val() + '</b><br> Пароль: ' + password.val());
                } else {
                    result.html('Вы нихрена не указали...').addClass('blink');
                }
                result.fadeTo("slow", 0.9);
                $('#login-form').slideUp('slow');
                $('.btn-login').removeClass('open-login');
                login.val('');
                password.val('');
                setTimeout(function () {
                    $("#result").animate({
                        opacity: 'hide',
                        display: 'none'
                    }, 2900);

                }, 3500);
            });
            $(".btn-login").on('click', function () {
                event.preventDefault();
                var ss = $('#login-form');
                ss.slideToggle("slow");
                $('.btn-login').toggleClass('open-login');
            });
        });
    </script>
<?
 $na = DB::$dbs->querySingle("SELECT count(id) from `action` where `us` = ? and `see` = ?",array($cms->us['id'],1));
     $ma = DB::$dbs->querySingle("SELECT count(id) from `msg` where `us` = ? and `see` = ?",array($cms->us['id'],1));
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
$logo1 = '<img src="/img/logo.png" alt="AndroPlay.Ml" />';
$logo2 = '<img src="/img/logo2.png" alt="AndroPlay.Ml" />';
srand((float) microtime() * 10000000);
$input = array($logo2, $logo1, $logo2, $logo1, $logo2);
$rand_keys = array_rand($input, 2);


echo'<div class="head"><a href="/">';
echo rand($logo1, $logo2);
echo $input[$rand_keys[0]] . "\n";
echo'
</a>';
$uv=$na+$ma;
if($na>=1||$ma>=1){
echo'<span style="float:right;"><button type="button" class="btn-login"><span class="badge">'.$uv.'</span></button></span></div>';  
}else{
echo'<span style="float:right;"><button type="button" class="btn-login"></button></span>';
}

  if (!empty($cms->us['bantime']) && $cms->us['bantime'] > time()) {
    $admin = DB::$dbs->queryFetch("SELECT `nick` FROM `us` where `id`=?",array($cms->us['whoban']));
     echo '<div class="err">Вы были заблокированы Администратором  <b><span style="color:green">'.$admin['nick']. '</span></b> за: <b>' . $cms->us['whyban'] . '</b><br/>
          Дaта оканчания блокировки: <b>' . ti($cms->us['bantime']) . '</b></div>';
  
  exit();
  }


 
echo ''.(empty($cms->us['id'])?'
	<div id="login-form" style="overflow: hidden; display: none;">
	<div class = "menu"><a class="menu_j" href="/aut">Авторизация</a> </div>
	<div class = "menu"><a class="menu_j" href="/reg">Регистрация</a></div>
    <div class = "menu"><a class="menu_j" href="/sog">Соглашение</a></div>
  <div class = "menu"><a class="menu_j" href="/kont">Контакты</a></div>
  <div class = "menu"><a class="menu_j" href="/faq.php">FAQ</a></div>
	</div>' 
	: '<div id="login-form" style="overflow: hidden; display: none;">
	<div class = "menu"><a class="menu_j" href="/cabinet">Личный кабинет</a> </div>
   <div class = "menu"><a class="menu_j" href="/sog">Соглашение</a></div>
   <div class = "menu"><a class="menu_j" href="/kont">Контакты</a></div>
	<div class = "menu"><a class="menu_j" href="/exit">Выход</a> </div>'.($na>=1?'<div class = "menu"><a class="menu_j" href="/cabinet/new.php">Оповещение<span class="badge">'.$na.'</span></a></div>':NULL).' '.($ma>=1?'<div class = "menu"><a class="menu_j"  href="/cabinet/mail.php">Почта<span class="badge">'.$ma.'</span></a></div>':NULL).'').'</div>
';
echo'</div>';

echo'
<div class="menu1">
<center><div id="linkslot_127201" style="margin: 10px 0;"><script src="https://linkslot.ru/lincode.php?id=127201" async></script></div><a href="http://linkslot.ru/link.php?id=127201" target="_blank">Купить ссылку здесь за <span id="linprice_127201"></span> руб.</a></center>
</div>';
?>
<div class ="menu">
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'ru', includedLanguages: 'be,de,en,ky,pl,ru,uk', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>
<?
echo'
<div class ="menu"><a href="/apk.apk"> <img src = "/img/drive_go.png">Скачать наш клиент</a></div>';


?>