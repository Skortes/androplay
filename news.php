<?php

/**

 * Created by PhpStorm.

 * User: wlaedua

 * Date: 07.09.2016

 * Time: 18:01

 */

header("Content-Type: text/html; charset=utf-8"); // кодировка

$url = 'http://lenta.ru/rss/news'; // откуда парсим

$title = 'Лента новостей';

include_once 'inc/head.php';

$maxItems = 15;

$rss = simplexml_load_file($url);

$i=0;

  if($rss){

      $items = $rss->channel->item;

      $num = (int)$rss->count;



      foreach($items as $item){



          if($i==$maxItems) return $out;



          else

            echo '<div class="main">';

              echo '<b>'.$item->title.'</b> <small>'.$item->pubDate.'</small><br/>

						  <img src="'.(string)$item->enclosure->attributes()->url .'" width="350px" ><br/>'.

                  $item->description.' </div>';





          $i++;

          

      }

   

  }

   include 'inc/foot.php';



?><?

?>

