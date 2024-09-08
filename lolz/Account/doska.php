<?php

$title = 'Список мошенников';

include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!isset($user['id'])) {
echo err($title, '
Уважаемый посетитель, Вы зашли на сайт как незарегистрированный пользователь.<br/>
Мы рекомендуем Вам зарегистрироваться либо войти на сайт под своим именем.
');
include ('../CGcore/footer.php'); exit;
}

$kid = mysql_query("SELECT * FROM `users` WHERE `verified` = '1' ORDER BY `id` DESC limit 15");
echo"<div class='title'><center>Список мошенников</center></div>";

if (mysql_num_rows($kid) > 1){

while($kid = mysql_fetch_assoc($kid)){
echo (empty($kid['avatar'])?'<div class="menudiv"> <img src="files/ava/net.png" alt="*" style="max-width: 50px; max-height: 50px;">':'<div class="menudiv"><img src="files/ava/'.$kid['avatar'].'" alt="*" style="max-width: 50px; max-height: 50px;">');
echo ''.nick($kid['id']).' <a href="/user_'.$kid['id'].'"></a> ';
}

echo'</center></div>';
}
else {
echo"<center>Список мошенников пуст</center>";
}
include ('../CGcore/footer.php');

?>