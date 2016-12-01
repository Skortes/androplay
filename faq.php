<?php 
$title = 'FAQ';
include_once 'inc/head.php';

$go=htmlspecialchars(trim($_GET['go']));
switch ($go){
    default:
   
    echo'<div class="main"><a href="?go=smile"><b>Смайлы</b></a></div>';
     echo'<div class="main"><a href="?go=bbcodes"><b>ББ коды</b></a></div>';
    echo'<div class="main"><a href="?go=prаvila"><b>Правила</b></a></div>';
    
    break;
    case "smile":

    echo '<div class="main">:) - <img src="/css/smile/smile.gif" alt=":)"/></div>
    <div class="main">:( - <img src="/css/smile/2.gif" alt=":("/></div>
    <div class="main">;) - <img src="/css/smile/3.gif" alt=";)"/></div>
    <div class="main">:P - <img src="/css/smile/4.gif" alt=":P"/></div>
    <div class="main">.крут. - <img src="/css/smile/5.gif" alt=".крут."/></div>
    <div class="main">:D - <img src="/css/smile/6.gif" alt=":D"/></div>
    <div class="main">.ахах. - <img src="/css/smile/1.gif" alt=".ахах."/></div>
    <div class="main">.покраснел. - <img src="/css/smile/7.gif" alt=".покраснел."/></div>
    <div class="main">0_о - <img src="/css/smile/8.gif" alt="0_о"/></div>
    <div class="main">.фак. - <img src="/css/smile/40.gif" alt=".фак."/></div>
    <div class="menu">&laquo; <a href="faq.php">Обратно</a></div>
    ';
    break;
    case "bbcodes":
    
    echo '<div class="main">1.[url=Ссылка]Название[/url]</div>
    <div class="main">2.[i]Курсив[/i]</div>
    <div class="main">3.[b]Жирность[/b]</div>
    <div class="main">4.[u]Подчеркивание[/u]</div>
    <div class="main">5.Красный шрифт: [red]Текст[/red</div>
    <div class="main">6.Белый шрифт: [white]Текст[/white]</div>
    <div class="main">7.Синий шрифт: [blue]Текст[/blue] </div>
    <div class="main">8.Зелёный шрифт: [green]Текст[/green]</div>
    <div class="main">9.Изображение: [img]Путь_к_картинке[/img] </div>
    <div class="main">10.Большой шрифт: [big]Текст[/big] </div>
    <div class="menu">&laquo; <a href="faq.php">Обратно</a></div>
    ';
    break;
    case "prаvila":
    echo '
    <div class="main"><b>1.0</b> Запрещена нецензурная лексика.<br/>
<b>1.1</b> Запрещён флуд.<br/>
<b>1.2</b> Сообщения, состоящие только из смайликов, приравниваются к флуду.<br/>
<b>1.3</b> Запрещён флейм ВО ВСЕХ РАЗДЕЛАХ форума, кроме раздела общение.<br/>
<b>1.4</b> Запрещены призывы к нарушению законодательства РФ, а также сообщения, сами по себе нарушающие законодательство РФ.</div>
    
    
    ';
    echo'<div class="menu">&laquo; <a href="faq.php">Обратно</a></div>';
    break;

break;
};
  include_once 'inc/foot.php';
?>