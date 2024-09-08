<?php

//-----Создаем титл страницы-----//
$title = 'Чат';
//-----Подключаем функции-----//
require_once ('../CGcore/core.php');
//-----Подключаем вверх-----//
require_once ('../CGcore/head.php');

//-----Если гость,то...-----//
if(!$user['id']) {
header('Location: '.$HOME.'');
exit();
}

switch($_GET['act']) {
default:
echo '<div class="menu">'.$title.' <span class=c> '.mysql_result(mysql_query('select count(`id`) from `users` where `gde` LIKE "%'.$links.'%" and `viz` > "'.(time()-60).'"'),0).' <i class="fas fa-user"></i></div>';

if($user['level'] >= 3) {

/* Если нажали создать комнату */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$about = strong($_POST['about']);

if(empty($name) or empty($about)) {
echo '<div class="mess"><center><b><big>Введите название и описание комнаты!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(mb_strlen($name) < 3 or mb_strlen($about) < 3) {
echo '<div class="mess"><center><b><big>Минимум для ввода 3 символа!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}


/* Делаем запрос */
mysql_query("INSERT INTO `chat_room` SET `name` = '".$name."',`about` = '".$about."'");
echo '<div class="mess"><center><b>Комната успешно создана!</b></center></div>';
}

echo '<div class="spoiler-block" style="margin: 0px;">';
echo '<a href="#" class="spoiler-title" style="color :#d6d6d6; padding: 6px 6px 7px; background: #303030; margin: 5px;"><center>Создать комнату</center></a>';
echo '<div class="spoiler-content" style="padding: 3px; background: #272727; border-radius: 10px; margin-top: 10px;">';

echo '<center><div class="mess"><form action="" method="POST"> 
<br /><center><input type="text" name="name" placeholder="Название комнаты" style="margin: 0px;"/></center><br />
<center><textarea name="about" placeholder="Название комнаты"></textarea></center><br />
<center style="padding: 10px 12px 10px 10px;"><input type="submit" name="submit" value="Создать" style="width: auto; padding: 10px 20px;"/></center>
</form></div></center>';

echo '</div>';
echo '</div>';
}

if(empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `chat_room` "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$chat = mysql_query("SELECT * FROM `chat_room` ORDER BY `id` DESC LIMIT $start, $max");

/* Кто в чате */
$links = '/chat';
/* Кто в чате */

echo '<div class="menu_j" style="border-bottom: 0px;"><a href="'.$HOME.'/chat/rulez" class="k_menu"><center>Правила чата</center></a></div>
<div class="menu_j" style="border-bottom: 0px;"><a href="'.$HOME.'/chat/who" class="k_menu"><center>Кто в чате?</center></a></div>';

while($a = mysql_fetch_assoc($chat))
{

/* Кто в комнате */
$gde = '/chat/room'.$a['id'].'';
/* Кто в комнате */

echo '<div class="nav"> 
<a class="link" href="/chat/room'.$a['id'].'"><img src="/images/chat_room.png">'.$a['name'].' <span class="schet_user_chat">('.mysql_result(mysql_query('select count(`id`) from `users` where `gde` LIKE "%'.$gde.'%" and `viz` > "'.(time()-60).'"'),0).' чел.)</span><br /><span class="mess1">'.smile(bb($a['about'])).'</span></a>';

/*** Действия над комнатой ***/
if($user['level'] >= 3) echo ' [<a href="/chat/del_razdel'.$a['id'].'">уд</a>|<a href="/chat/red_razdel'.$a['id'].'">ред</a>]';
/*** Действия над комнатой ***/

echo '</div>';
}

if($k_post < 1) echo '<div class="mess"><center><big><b>Комнаты пока не созданы!</big></b></center></div>';

break;
case 'red_razdel':

$id = abs(intval($_GET['id']));
$room = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_room` WHERE `id` = '".$id."'"));

if($room == 0) {
echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Ошибка</div><div class="mess"><center><b><big>Такой комнаты не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Ошибка</div><div class="mess"><center><b><big>У вас недостаточно прав для просмотра данной страницы!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/chat/">'.$title.'</a> | Редактирование комнаты</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$about = strong($_POST['about']);

if(empty($name) or empty($about)) {
echo '<div class="mess"><center><b><big>Введите название и описание комнаты!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(mb_strlen($name) < 3 or mb_strlen($about) < 3) {
echo '<div class="mess"><center><b><big>Минимум для ввода 3 символа!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

/* Делаем запрос */
mysql_query("UPDATE `chat_room` SET `name` = '".$name."', `about` = '".$about."' WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/chat/');
exit();
}

echo '<div class="mess"><form action="" method="POST"> 
*Название комнаты:<br /> <input type="text" name="name" value="'.$room['name'].'"/><br />
*Описание:<br /><textarea name="about">'.$room['about'].'</textarea><br />
<input type="submit" name="submit" value="Редактировать" />
</form></div>';

echo '<div class="menu_j"><a href="'.$HOME.'/chat/" class="k_menu">Назад в чат</a></div>';

break;
case 'del_razdel':

$id = abs(intval($_GET['id']));
$room = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_room` WHERE `id` = '".$id."'"));

if($room == 0) {
echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Ошибка</div><div class="mess"><center><b><big>Такой комнаты не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if($user['level'] != 3){
echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Ошибка</div><div class="mess"><center><b><big>У вас недостаточно прав для просмотра данной страницы!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['okda'])) {
mysql_query("DELETE FROM `chat_room` where `id` = '".$id."'");
mysql_query("DELETE FROM `chat_post` where `room` = '".$id."'");
header('Location: '.$HOME.'/chat');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Удалить комнату</div>
<div class="mess">Вы действительно хотите удалить эту комнату?<br /><a href="'.$HOME.'/chat/del_razdel'.$room['id'].'?okda">Да</a></div>
<div class="menu_j"><a href="'.$HOME.'/chat/" class="k_menu">Назад в чат</a></div>';

break;
case 'delmsg':

$id = abs(intval($_GET['id']));
$chat = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_post` WHERE `id` = '".$id."'"));

if($user['level'] < 1) {
echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Ошибка</div><div class="mess"><center><b><big>У вас недостаточно прав для просмотра данной страницы!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if($chat == 0) {
echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Ошибка</div><div class="mess"><center><b><big>Такого сообщения не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['okda'])) {
mysql_query("DELETE FROM `chat_post` where `id` = '".$id."'");
header('Location: '.$HOME.'/chat/room'.$chat['room'].'');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Удалить сообщение</div>
<div class="mess">Вы действительно хотите удалить это сообщение?<br /><a href="'.$HOME.'/chat/room_delmsg'.$chat['id'].'?okda">Да</a></div>
<div class="menu_j"><a href="'.$HOME.'/chat/room'.$chat['room'].'" class="k_menu">Назад в комнату</a></div>';

break;
case 'room_who':

$id = abs(intval($_GET['id']));
$chat = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_room` WHERE `id` = '".$id."'"));

echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Кто в чате?</div>';

if($chat == 0) {
echo '<div class="mess"><center><b><big>Такой комнаты не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

/* Кто в чате */
$gde = '/chat/room'.$id.'';
/* Кто в чате */

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `gde` LIKE '%".$gde."%' and `viz` > '".(time()-60)."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$who = mysql_query("SELECT * FROM `users` WHERE `gde` LIKE '%".$gde."%' and `viz` > '".(time()-60)."' ORDER BY `viz` DESC LIMIT $start, $max");
while($who2 = mysql_fetch_assoc($who))
{
echo '<div class="mess">'.nick($who2['id']).' ('.vremja($who2['viz']).')</div>';
}

if($k_post < 1) echo '<div class="nav"><center><b><big>В этой комнате никого нету!</big></b></center></div>';
if($k_page>1) echo str(''.$HOME.'/chat/who/?',$k_page,$page); // Вывод страниц

echo '<div class="menu_j"><a href="'.$HOME.'/chat/room'.$id.'" class="k_menu">Назад в '.$chat['name'].'</a></div>';

break;
case 'room':

$id = abs(intval($_GET['id']));
$room = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_room` WHERE `id` = '".$id."'"));

if($room == 0) {
echo '<div class="menu"><a href="'.$HOME.'/chat">Чат</a> | Ошибка</div><div class="mess"><center><b><big>Такой комнаты не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

/* Кто в чате */
$gde = '/chat/room'.$id.'';
/* Кто в чате */

echo '<div class="menu"><a href="'.$HOME.'/chat">'.$title.'</a> | '.$room['name'].'</div>';

//-----Если жмут кнопку-----//
if(isset($_REQUEST['submit'])) {

$msg = strong($_POST['msg']);
$color = strong($_POST['color']);
$emotion = strong($_POST['emotion']);

if(empty($msg)) {
echo '<div class="mess"><center><b><big>Введите сообщение!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(mb_strlen($msg) < 3) {
echo '<div class="mess"><center><b><big>Минимум для ввода 3 символа!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

$ttte = mysql_fetch_array(mysql_query('select * from `chat_post` where `room` = "'.$id.'" and `avtor` = "'.$user['id'].'" and `msg` = "'.$msg.'"'));
if($ttte != 0) {
echo '<div class="mess"><center><b><big>Вы такое сообщение уже писали!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

$tim = mysql_query("SELECT * FROM `chat_post` WHERE `avtor` = '".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `chat` "));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['chat']) {
echo '<div class="mess"><center><b><big>Пишите не чаще чем раз в '.$news_antispam['chat'].' секунд!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}
}

mysql_query("INSERT INTO `chat_post` SET `room` = '".$id."',`msg` = '".$msg."', `avtor` = '".$user['id']."',`color` = '".$color."', `avtorlogin` = '".$user['login']."',`emotion` = '".$emotion."',`time` = '".time()."'");
header('Location: '.$HOME.'/chat/room'.$id.'');
exit();
}

echo '<div class="menu_j"><a href="'.$HOME.'/chat/room'.$id.'/who" class="k_menu">'.mysql_result(mysql_query('select count(`id`) from `users` where `gde` LIKE "%'.$gde.'%" and `viz` > "'.(time()-60).'"'),0).' <i class="fas fa-user"></i></span></a></div>
<div class="menu_j"><a href="'.$HOME.'/chat/room'.$id.'" class="k_menu">Обновить</a></div>';

echo '<div class="mess">
<form action="" method="POST">
*Сообщение:
<br />
<textarea name="msg"></textarea><br />
Чувства:<br />
<select name="emotion">
<option value="Нейтрально">Нейтрально</option>
<option value="Задумчиво">Задумчиво</option>
<option value="С недоумением">С недоумением</option>
<option value="Интересуясь">Интересуясь</option>
<option value="С интригой">С интригой</option>
<option value="Обиженно">Обиженно</option>
<option value="Ласково">Ласково</option>
<option value="Подмигнув">Подмигнув</option>
<option value="Со злостью">Со злостью</option>
<option value="Нервничая">Нервничая</option>
<option value="Смеясь">Смеясь</option>
<option value="Улыбаясь">Улыбаясь</option>
<option value="Радостно">Радостно</option>
</select>
<br />
Цвет:
<br />
<select name="color">
<option value="darkred" style="background-color: darkred; color: white;">Тёмно-красный</option>
<option value="maroon" style="background-color: maroon; color: white;">Тёмно-бордовый</option>
<option value="brown" style="background-color: brown; color: white;">Коричневый</option>
<option value="pink" style="background-color: pink; color: white;">Розовый</option>
<option value="green" style="background-color: green; color: white;">Зеленый</option>
<option value="lime" style="background-color: lime; color: white;">Лайм</option>
<option value="lightgreen" style="background-color: lightgreen; color: white;">Светло-зеленый</option>
<option value="olive" style="background-color: olive; color: white;">Оливковый</option>
<option value="#669999" style="background-color: #669999; color: white;">Морская волна</option>
<option value="aquamarine" style="background-color: aquamarine; color: white;">Аквамарин</option>
<option value="blue" style="background-color: blue; color: white;">Синий</option>
<option value="navy" style="background-color: navy; color: white;">Тёмно-синий</option>
<option value="deepskyblue" style="background-color: deepskyblue; color: white;">Небесно-голубой</option>
<option value="blueviolet" style="background-color: blueviolet; color: white;">Фиолетовый</option>
<option value="purple" style="background-color: purple; color: white;">Пурпурный</option>
<option value="indigo" style="background-color: indigo; color: white;">Индиго</option>
<option value="yellow" style="background-color: yellow; color: black;">Жёлтый</option>
<option value="orange" style="background-color: orange; color: black;">Оранжевый</option>
<option value="goldenrod" style="background-color: goldenrod; color: black;">Золотой</option>
<option value="gray" style="background-color: gray; color: black;">Темно-серый</option>
<option value="#CCCCCC" style="background-color: #CCCCCC; color: black;">Светло-серый</option>
<option value="silver" style="background-color: silver; color: black;">Серебрянный</option>
<option value="black" style="background-color: black; color: white;">Чёрный</option>
</select><br />
<input type="submit" name="submit" value="Написать" />
</form></div>';

if(empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `chat_post` WHERE `room` = '".$id."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$chat = mysql_query("SELECT * FROM `chat_post` WHERE `room` = '".$id."' ORDER BY `id` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($chat))
{
echo '<div class="nav">'.nick($a['avtor']).' ('.vremja($a['time']).') | <font color="maroon">'.$a['emotion'].'</font>';

if($user['level'] >= 1) echo ' [<a href="'.$HOME.'/chat/room_delmsg'.$a['id'].'">уд</a>]';
if($user['id'] != $a['avtor']) echo ' [<a href="'.$HOME.'/chat/room_otvet'.$a['id'].'">отв</a>]';

echo '</div>
<div class="menu"><font color="'.$a['color'].'">'.smile(bb($a['msg'])).'</font></div>';
}

if($k_post < 1) echo '<div class="mess"><center><b><big>В комнате сообщений пока нету!</big></b></center></div>';
if($k_page>1) echo str(''.$HOME.'/chat/room'.$id.'?',$k_page,$page); // Вывод страниц

echo '<div class="menu_j"><a href="'.$HOME.'/chat" class="k_menu"> В чат</a></div>';

break;
case 'otvet':

echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Ответ</div>';

$id = abs(intval($_GET['id']));
$chat = mysql_fetch_assoc(mysql_query("SELECT * FROM `chat_post` WHERE `id` = '".$id."'"));

if($chat == 0) {
echo '<div class="mess"><center><b><big>Такого поста не существует!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(isset($chat['id']) && $user['id'] != $chat['avtor']) {
header('Location: '.$HOME.'/chat/room'.$chat['room'].'');
exit();
}

//-----Если жмут кнопку-----//
if(isset($_REQUEST['submit'])) {

$msg = strong($_POST['msg']);
$color = strong($_POST['color']);
$emotion = strong($_POST['emotion']);

if(empty($msg)) {
echo '<div class="mess"><center><b><big>Введите сообщение!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

if(mb_strlen($msg) < 3) {
echo '<div class="mess"><center><b><big>Минимум для ввода 3 символа!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

$ttte = mysql_fetch_array(mysql_query('select * from `chat_post` where `avtor` = "'.$user['id'].'" and `msg` = "'.$msg.'"'));
if($ttte != 0) {
echo '<div class="mess"><center><b><big>Вы такое сообщение уже писали!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}

$tim = mysql_query("SELECT * FROM `chat_post` WHERE `avtor` = '".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `chat` "));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['chat']) {
echo '<div class="mess"><center><b><big>Пишите не чаще чем раз в '.$news_antispam['chat'].' секунд!</big></b></center></div>';
require_once ('../CGcore/footer.php');
exit();
}
}

mysql_query("INSERT INTO `chat_post` SET  `room` = '".$chat['room']."',`msg` = '[black][b]".$chat['avtorlogin'].",[/black][/b] ".$msg."', `avtor` = '".$user['id']."', `avtorlogin` = '".$user['login']."', `time` = '".time()."', `color` = '".$color."', `emotion` = '".$emotion."'");
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `text` = 'ответил Вам в [url=".$HOME."/chat/room".$chat['room']."]чате[/url]', `time` = '".time()."', `kto` = '".$user['id']."', `komy` = '".$chat['avtor']."'");
header('Location: '.$HOME.'/chat/room'.$chat['room'].'');
exit();
}

echo '<div class="mess">
<b>Ответ: '.nick($chat['avtor']).'</b></div><div class="podmenu">
<form action="" method="POST">
*Сообщение:<br /><textarea name="msg"></textarea><br />
<select name="emotion">
<option value="Нейтрально">Нейтрально</option>
<option value="Задумчиво">Задумчиво</option>
<option value="С недоумением">С недоумением</option>
<option value="Интересуясь">Интересуясь</option>
<option value="С интригой">С интригой</option>
<option value="Обиженно">Обиженно</option>
<option value="Ласково">Ласково</option>
<option value="Подмигнув">Подмигнув</option>
<option value="Со злостью">Со злостью</option>
<option value="Нервничая">Нервничая</option>
<option value="Смеясь">Смеясь</option>
<option value="Улыбаясь">Улыбаясь</option>
<option value="Радостно">Радостно</option>
</select>
<br />
Цвет:
<br />
<select name="color">
<option value="darkred" style="background-color: darkred; color: white;">Тёмно-красный</option>
<option value="maroon" style="background-color: maroon; color: white;">Тёмно-бордовый</option>
<option value="brown" style="background-color: brown; color: white;">Коричневый</option>
<option value="pink" style="background-color: pink; color: white;">Розовый</option>
<option value="green" style="background-color: green; color: white;">Зеленый</option>
<option value="lime" style="background-color: lime; color: white;">Лайм</option>
<option value="lightgreen" style="background-color: lightgreen; color: white;">Светло-зеленый</option>
<option value="olive" style="background-color: olive; color: white;">Оливковый</option>
<option value="#669999" style="background-color: #669999; color: white;">Морская волна</option>
<option value="aquamarine" style="background-color: aquamarine; color: white;">Аквамарин</option>
<option value="blue" style="background-color: blue; color: white;">Синий</option>
<option value="navy" style="background-color: navy; color: white;">Тёмно-синий</option>
<option value="deepskyblue" style="background-color: deepskyblue; color: white;">Небесно-голубой</option>
<option value="blueviolet" style="background-color: blueviolet; color: white;">Фиолетовый</option>
<option value="purple" style="background-color: purple; color: white;">Пурпурный</option>
<option value="indigo" style="background-color: indigo; color: white;">Индиго</option>
<option value="yellow" style="background-color: yellow; color: black;">Жёлтый</option>
<option value="orange" style="background-color: orange; color: black;">Оранжевый</option>
<option value="goldenrod" style="background-color: goldenrod; color: black;">Золотой</option>
<option value="gray" style="background-color: gray; color: black;">Темно-серый</option>
<option value="#CCCCCC" style="background-color: #CCCCCC; color: black;">Светло-серый</option>
<option value="silver" style="background-color: silver; color: black;">Серебрянный</option>
<option value="black" style="background-color: black; color: white;">Чёрный</option>
</select><br />
<input type="submit" name="submit" value="Ответить" />
</form></div>';

echo '<div class="menu_j"><a href="'.$HOME.'/chat/room'.$chat['room'].'" class="k_menu">Назад в комнату</a></div>';

break;
case 'who':

echo '<div class="menu"><a href="'.$HOME.'/chat/">Чат</a> | Кто в чате?</div>';

/* Кто в чате */
$gde = '/chat';
/* Кто в чате */

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `gde` LIKE '%".$gde."%' and `viz` > '".(time()-60)."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$who = mysql_query("SELECT * FROM `users` WHERE `gde` LIKE '%".$gde."%' and `viz` > '".(time()-60)."' ORDER BY `viz` DESC LIMIT $start, $max");
while($who2 = mysql_fetch_assoc($who))
{
echo '<div class="nav">'.nick($who2['id']).' ('.vremja($who2['viz']).')</div>';
}

if($k_post < 1) echo '<div class="mess"><center><b><big>В чате никого нету!</big></b></center></div>';
if($k_page>1) echo str(''.$HOME.'/chat/who/?',$k_page,$page); // Вывод страниц

echo '<div class="menu_j"><a href="'.$HOME.'/chat/" class="k_menu">Назад в чат</a></div>';

break;
case 'rulez':

echo '<div class="menu"><a href="'.$HOME.'/chat/">'.$title.'</a> | Правила чата</div>';

$rule = mysql_fetch_assoc(mysql_query("SELECT `chat` FROM `rules`"));

echo '<div class="mess">'.bb($rule['chat']).'</div>
<div class="menu_j"><a href="'.$HOME.'/chat/" class="k_menu">Назад в чат</a></div>';

break;
}

//-----Подключаем низ-----//
require_once ('../CGcore/footer.php');
?>