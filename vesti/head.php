<?php
error_reporting(0);
include 'config.php';
include 'func.php';
if (!$title2) $title2 = $site;

echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<title>'.$title2.'</title>
<link rel="stylesheet" href="ulty.css" type="text/css" />
</head>
<body>
<div class="'.$header.'" style="text-align:center; >
<a href="/">
<center><h3>'.$site.'</h3></center>
</a> </div>';
?>