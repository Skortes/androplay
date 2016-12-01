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
echo '<div class="'.$title.'">Последние Новости</div>';
			
			$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `ultynews`"), 0);
			if($total) {
				if ($total > $kmess) 
					echo '<div class="'.$gmenu.'">' . pagination('index.php?', $start, $total, $kmess) . '</div>';
				$req = mysql_query("SELECT * FROM `ultynews` ORDER BY `time` DESC LIMIT "  . $start . "," . $kmess);
				
				while (($row = mysql_fetch_assoc($req)) !== false) {
					echo '<div class="'.$menu.'">';
						echo '<span class="time">' . (date('dmy', $row['time']) == date('dmy', time()) ? date('H:i', $row['time']) : date('d.m.o / H:i', $row['time'])) . '</span> <a href="view.php?id=' . $row['id'] . '">'.$row['name'].'</a>';
						echo '</div>';
					
				}
				echo '<div class="'.$title.'">Всего: ' . $total . '</div>';
				if ($total > $kmess) {
					echo '<div class="'.$gmenu.'">' . pagination('index.php?', $start, $total, $kmess) . '</div>';
					echo '<p><form action="index.php" method="get">
					<input type="text" name="page" size="2"/>
					<input type="submit" value="Перейти &gt;&gt;"/></form></p>';
				}
			} else {
				echo '<div class="'.$menu.'">Новостей нет</div>';
			}
		
include 'foot.php';