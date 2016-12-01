<?php       
$title = 'Профиль';
include_once 'inc/head.php';

 $us = DB::$dbs->queryFetch("SELECT * FROM `us` where `id` = ? limit 1",array(abs(intval($_GET['id']))));

if(empty($us['nick']) or !isset($cms->us['id'])){header('location:/');}

 if($us['open'] == 0){ 
  if($us['level'] == 0){ $us['level'] = 'Пользователь';}elseif($us['level']==1){$us['level']='Пользователь';}elseif($us['level']==2){$us['level']='Пользователь';}elseif($us['level']==3){
  $us['level'] = 'Узнаваемый';}elseif($us['level']==4){$us['level']='Местный';}elseif($us['level']==5){$us['level']='Наш человек';}elseif($us['level']==6){$us['level']='<b><font color="blue">Модератор</font></b>';}elseif($us['level']==7){$us['level']='<b><font color="blue">Старший модератор</font></b>';}elseif($us['level']==8){$us['level']='<b><font color="red">Админ</font></b>';}elseif($us['level']==9){$us['level']='<b><font color="red">Ст. админ</font></b>';}else{$us['level']='<b><font color="red">Создатель</font></b>';}
  include 'inc/funcs.php';
    if($us['bantime'] > time()){
    echo '<div class="menu">Пользыватель забанен за <b>'.$us['whyban'].'</b>!Дaта оканчания блокировки: <b>' . ti($us['bantime']) . '</b></div>';   
    if($cms->us['level']==10){
        echo '<div class="menu">[<a href ="/adm/us.php?id='.$us['id'].'&adm=razban">Разбанить!</a>]</div>';
        }
    }

     echo '<div class="main">';
echo ''.$func->NickI($us['id']).' ';
if ($us['name']!=NULL) echo '<b>'.$us['name'].'</b>';
echo ' '.$func->uBick($us['id']).' ';
if ($us['familia']!=NULL) echo '<b>'.$us['familia'].'</b>' ;
echo '<br/>';

  echo'<b>»</b> Зарегистрирован: '.t($us ['reg']).'</br>
<b>»</b> Последняя активность: '.t($us['last']).'<br/>
<b>»</b> Уровень: '.$us['level'].'<br />';
  $photo = DB::$dbs->queryFetch("SELECT id,path from `photos` where `us` = ? and `osn` = ? limit 1",array($us['id'],1));
  echo'<a href="/photos/photo.php?id='.$photo['id'].'"><img src="'.($photo['path']?'/photos/'.$photo['path']:'/css/img/noavatar.png').'" alt="*" width="150" height="150" /></a></div>
       <div class="menu"><div class="css">Информация</div></div>';
      
  echo '<a href="info_'.$us['id'].'"><div class="menu">Анкета</div></a>';
    echo '<div class="main"><div class="css">Виртуальный счет</div></div>
    <div class="menu1">Баллы: '.$us['balls'].' </div>
    ';
        echo '<div class="main">Активность</div>';
        $l = DB::$dbs->querySingle("SELECT count(id) from `library_k` where `user_id` = ?",array($us['id']));
        $n = DB::$dbs->querySingle("SELECT count(id) from `news_komm` where `us` = ?",array($us['id']));
        $photo = DB::$dbs->querySingle("SELECT count(id) from `photo_komm` where `us` = ?",array($us['id']));
        $laik = DB::$dbs->querySingle("SELECT count(id_us) from `news_vote` where `id_us` = ?",array($us['id']));
        $forum_post = DB::$dbs->querySingle("SELECT count(user) from `forum_post` where `user` = ?",array($us['id']));
        $forum_them = DB::$dbs->querySingle("SELECT count(author) from `forum_themes` where `author` = ?",array($us['id']));
     $all=$n+$photo;
$chat = DB::$dbs->querySingle("SELECT count(id) from `chat_msg` where `us` = ?",array($us['id']));
echo'<div class="menu1">';
        echo ' Комментариев: '.$all.'<br/>';
                   echo 'Постов в чате: '.$chat.'<br/>';
                  /*  echo '<img src="/css/ic/balloon.gif"> Постов в форуме: '.$forum_post.'<br/>';
                   echo '<img src="/css/ic/balloon.gif"> Тем в форуме: '.$forum_them.'<br/>';        
                   echo 'Написано книг: '.$l.' <br/>';
                   echo 'Поставил лайков : '.$laik.' <br/>';
                   */
if($_SESSION['se']<time()-10){
    DB::$dbs->query("UPDATE `us` set `see` = `see` + '1' where `id` = ? limit 1",array($us['id']));
    $_SESSION['se'] = time();
    }
               echo 'Посмотрели анкету '.$us['see'].' раз(a)<br/>';
     
echo'</div>';
  if($cms->us['id']!==$us['id']){

  echo'<div class="menu"><img src="/css/img/mail_alt.png"> <a href="/cabinet/msg.php?u='.$us['id'].'">Отправить сообщение</a><//div>';
  }
  
  echo '</div></div>';

}else {echo '<div class="menu"><font color="red"><b>Пользователь закрыл свою анкету от посторонних глаз!</b></font></div><br/>';}
  include_once 'inc/foot.php';
?>