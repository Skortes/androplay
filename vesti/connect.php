<?php
/*
/////////////////////////////////////////////////////////////////////////////////
// Модуль: Авто добавление Новостей  V1.0 beta                                //
// Автор:   Abdusamad Dilmurodov (Ulty)                                 //
// icq:     56628086                                                          //
// e-mail: wm.ulty@gmail.com                                                  //
////////////////////////////////////////////////////////////////////////////////
*/
// CONNECT С БАЗОЙ
$user = "skortesr_android";////ПОЛЬЗОВАТЕЛЬ
$base = "skortesr_android";////БАЗА
$pwd = "Lenovo11";////ПАРОЛЬ
$server = "localhost";////ХОСТ (СЕРВЕР)

$sql = mysql_connect($server, $user, $pwd) or die ("Не могу соединиться с базой!");///СОЕДИНЯЕМСЯ
mysql_select_db($base, $sql) or die ("База $base не найдена!");////ВЫБИРАЕМ БАЗУ
//////
?>
