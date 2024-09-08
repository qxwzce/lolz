<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<style>
@media all and (min-width: 800px){ 
.side_st {
	display: none;
  }
.side_at {
	border-radius: 10px 10px 10px 10px;
  }
}
</style>';

if(!$user['id'] or $user['level'] < 1) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act)
{
default:

echo '<div class="menu"><a href="'.$HOME.'/user/cab.php">Личный кабинет</a> | Админ панель</div>';



echo '<div class="panel__block">';	

echo '<a class="link" href="'.$HOME.'/panel/users/"><span class="icon"><i class="fas fa-angle-right"></i></span>Управление пользователями</a>
<a class="link" href="'.$HOME.'/panel/ras.php"><span class="icon"><i class="fas fa-angle-right"></i></span>Рассылка пользователям</a>
<a class="link" href="'.$HOME.'/panel/load_mod/"><span class="icon"><i class="fas fa-angle-right"></i></span>Модерация файлов</a>
<a class="link" href="?act=bonus"><span class="icon"><i class="fas fa-angle-right"></i></span>Бонусы</a>
<a class="link" href="'.$HOME.'/panel/aspam/"><span class="icon"><i class="fas fa-angle-right"></i></span>Антиспам</a>
<a class="link" href="'.$HOME.'/panel/ip_fs/"><span class="icon"><i class="fas fa-angle-right"></i></span>Поиск по IP</a>
<a class="link" href="'.$HOME.'/panel/ban/"><span class="icon"><i class="fas fa-angle-right"></i></span>Бан лист</a>
<a class="link" href="'.$HOME.'/panel/style.php"><span class="icon"><i class="fas fa-angle-right"></i></span>Стиль сайта</a>
<a class="link" href="'.$HOME.'/forum/"><span class="icon"><i class="fas fa-angle-right"></i></span>Управление разделами</a>
<a class="link" href="?act=set"><span class="icon"><i class="fas fa-angle-right"></i></span>Настройки сайта</a>
<a class="link" href="'.$HOME.'/panel/rek.php"><span class="icon"><i class="fas fa-angle-right"></i></span>Реклама</a>
<a class="link" href="?act=count"><span class="icon"><i class="fas fa-angle-right"></i></span>Счетчики</a>
<a class="link" href="'.$HOME.'/smile.php"><span class="icon"><i class="fas fa-angle-right"></i></span> Смайлы</a>
<a class="link" href="'.$HOME.'/panel/home-banner.php"><span class="icon"><i class="fas fa-angle-right"></i></span>Баннер на главной</a>
<a class="link" href="'.$HOME.'/panel/?act=prefix-them"><span class="icon"><i class="fas fa-angle-right"></i></span>Префиксы тем</a>';

echo '</div>';



break;
case 'ban':

echo '<div class="menu" style="border-bottom: 0px;"><a href="'.$HOME.'/panel/">Админ панель</a> | Бан лист
<a class="link" href="'.$HOME.'/panel/ban/list">Список забаненых</a>';

if($user['id'] == 1) echo '<a class="link" href="'.$HOME.'/panel/ban/jalob">Жалобы на бан</a>';

break;
case 'ban_list':

echo '<div class="menu" style="border-bottom: 1px;"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/ban/">Бан лист</a> | Список забаненых';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `ban_list`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$ban = mysql_query("SELECT * FROM `ban_list` ORDER BY `time_play` DESC LIMIT $start,$max");
while($b = mysql_fetch_assoc($ban))
{
echo '<div class="menu" style="border-bottom: 0px; background-color: #2d2d2d; border-radius: 9px; margin-top: 14px;">'.nick($b['kto']).'<br />(Дата бана: '.vremja($b['time_play']).')

<div class="menu" style="border-bottom: 0px; background-color: #2d2d2d; padding-bottom: 15px; padding-left: 0px;">'.smile(bb($b['about'])).'
<br />
<b>Дата освобождения: '.date('d.m.Y в H:i',$b['time_end']).'</b></div>
<a href="'.$HOME.'/panel/ban/list/updateban'.$b['kto'].'" style="background-color: #228e5d; padding-top: 2px; padding-bottom: 2px; padding-left: 7px; padding-right: 7px; border-radius: 6px;">разбанить</a></div><br />';
}

if($k_post < 1) {
echo '<div class="menu"><center><b>Бан лист пуст!</b></center></div>';
}

if ($k_page > 1) {
echo str(''.$HOME.'/panel/ban/list/',$k_page,$page); // Вывод страниц
}

echo '<div class="menu" style="border-bottom: 0px;"><a href="'.$HOME.'/panel/ban" style="background-color: #228e5d; padding-top: 7px; padding-bottom: 7px; padding-left: 15px; padding-right: 15px; border-radius: 7px;">Назад в бан лист</a></div>';

break;
case 'addban':

$id = abs(intval($_GET['id']));
$adban = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

if($adban['id'] == 0 or $user['id'] == $id or $id == 1 or $adban['level'] >= $user['level']) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/ban/">Бан лист</a> | <a href="'.$HOME.'/panel/ban/list">Список забаненых</a> | Бан</div>';

if(isset($_REQUEST['ok'])) {

$about = strong($_POST['about']);
$time_end = strong($_POST['time_end']);

if(empty($about) or mb_strlen($about) < 3) {
echo '<div class="menu"><center><b>Ошибка ввода ,минимум 3 символа!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("INSERT INTO `ban_list` SET `about` = '".$about."', `time_end` = '".(time()+($time_end*(60*60)))."', `add_ban` = '".$user['id']."', `kto` = '".$id."', `time_play` = '".time()."'");
header('Location: '.$HOME.'/panel/ban/list');
exit();
}

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$id."'"));

if($sql == 0) {
echo '<div class="menu">Вы желаете дать бан '.nick($id).' ?</div>
<div class="menu"><form action="" method="POST">
*Причина:<br /><textarea name="about"></textarea><br />
*Срок:<br/><select name="time_end"><option value="3">3 часа</option><option value="24">Сутки</option><option value="72">3 дня</option><option value="168">Неделя</option><option value="720">Месяц</option><option value="8640">Год</option><option value="99999999999">Навсегда</option></select><br/>
<input type="submit" name="ok" value="Банить" />
</form></div>';
} else {
echo '<div class="menu"><center><b>Этот пользователь уже забанен!!</b></center></div>';
}

break;
case 'updateban':

$id = abs(intval($_GET['id']));
$upban = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$id."'"));

echo '<div class="title"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/ban/">Бан лист</a> | <a href="'.$HOME.'/panel/ban/list">Список забаненых</a> | Разбан</div>';

if($upban['id'] == 0) {
echo '<div class="menu"><center><b>Этот пользователь не в бане!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['okda'])) {
mysql_query("DELETE FROM `ban_list` WHERE `kto` = '".$id."'");
header('Location: '.$HOME.'/panel/ban/list');
exit();
}

echo '<div class="menu" style="border-bottom: 0px;">Вы действительно хотите разбанить '.nick($upban['kto']).'?
<br />
<br />
<a href="'.$HOME.'/panel/ban/list/updateban'.$id.'?okda" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin-top: 5px;">Да</a> <a href="'.$HOME.'/panel/ban/list" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin: 5px;">Нет</a></div>';

break;
case 'jalob_ban':

if($user['id'] != 1) {
echo '<div class="menu" style="color: #d6d6d6; font-size: 15px;">Ошибка</div>
<div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/ban/">Бан лист</a> | Жалобы на бан</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `jalob_ba`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$jal = mysql_query("SELECT * FROM `jalob_ba` ORDER BY `time` DESC LIMIT $start,$max");
while($j = mysql_fetch_assoc($jal))
{
echo '<div class="menu">'.smile(bb($j['about'])).' ('.nick($j['avtor']).')</div>';
}

if($k_post < 1) {
echo '<div class="menu"><center><b>Жалоб не поступало!</b></center></div>';
}

if ($k_page > 1) {
echo str(''.$HOME.'/panel/ban/jalob/',$k_page,$page); // Вывод страниц
}

echo '<div class="menu">» <a href="'.$HOME.'/panel/ban">Назад в бан лист</a></div>';

break;
case 'ip_fs':

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Поиск по IP</div>';

echo '<div class="menu"><form action="" method="POST">
Введите IP: <br />
<input type="text" name="text" value="" maxlength="30" /><br />
<input type="submit" name="submit" value="Искать" />
</form></div>';

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['text']);

if(strlen($text) <1) {
echo '<div class="menu"><center><b>Минимальная длина запроса 1 символ!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><img src="/design/gradient/lol.png" alt="*" /> Результаты поиска:</div>';

$s = mysql_query("SELECT * FROM `users` where `ip` LIKE '%".$text."%' ORDER BY `id` DESC ");
$sql = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` where `ip` LIKE '%".$text."%' "),0);

while($ip_fs = mysql_fetch_assoc($s)){
echo '<div class="menu">'.nick($ip_fs['id']).'</div>
<div class="menu">
<b>IP:</b> '.$ip_fs['ip'].' <br />
<b>UA:</b> '.$ip_fs['browser'].'</a>
</div>';
}
}

if($sql == 0) echo '<div class="menu"><center><b>По вашему запросу ничего не найдено!</b></center></div>';

break;
case 'aspam':
if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}
echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Антиспам</div>';

if(isset($_REQUEST['ok'])) {

$down = strong($_POST['down']);
$mes = strong($_POST['mes']);
$blog = strong($_POST['blog']);
$news = strong($_POST['news']);
$stena = strong($_POST['stena']);
$gust = strong($_POST['gust']);
$chat = strong($_POST['chat']);
$forum_tema = strong($_POST['forum_tema']);
$forum_post = strong($_POST['forum_post']);
$repa = strong($_POST['repa']);
$friends = strong($_POST['friends']);

/* Друзья */
if(empty($friends)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама в друзьях!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($friends)) {
echo '<div class="menu"><center><b>Вводить можно только цифра!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Репутация */
if(empty($repa)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама в репутациях!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($repa)) {
echo '<div class="menu"><center><b>Вводить можно только цифра!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Репутация */

/* Сообщения */
if(empty($mes)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама в сообщениях!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($mes)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Сообщения */

/* Загрузки комментарии */
if(empty($down)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама в загрузках!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($down)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Загрузки комментарии */

/* Новости комментарии */
if(empty($news)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама в новостях!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($news)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Новости комментарии */

/* Стена пользователя */
if(empty($stena)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама сообщений на стене!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($stena)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Стена пользователя */

/* Сообщения в чате */
if(empty($chat)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама сообщений в мини чате!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($chat)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Сообщения в чате */

/* Форум создание темы */
if(empty($forum_tema)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама созданий темы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($forum_tema)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Форум создание темы */

/* Форум написание поста */
if(empty($forum_post)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама написания сообщений в теме!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($forum_post)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Форум написание поста */

/* Блоги(комментарии) */
if(empty($blog)) {
echo '<div class="menu"><center><b>Вы не ввели время антиспама написания комментарий в блогах!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(!is_numeric($blog)) {
echo '<div class="menu"><center><b>Вводить можно только цифры!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}
/* Блоги(комментарии) */

mysql_query("UPDATE `antispam` SET 
          `repa` = '".$repa."',
          `mes` = '".$mes."',
          `down` = '".$down."',
          `guest` = '".$gust."',
          `blog` = '".$blog."',
          `chat` = '".$chat."', 
          `news` = '".$news."', 
          `stena` = '".$stena."', 
          `forum_tema` = '".$forum_tema."', 
          `forum_post` = '".$forum_post."',
          `friends` = '".$friends."' WHERE `id` = '1'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<div class="menu">» <a href="?act=aspam">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}
/* Переменная вывода настроек сайта */
$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` "));
echo '<div class="menu"><form action="" method="POST">
Писать в новостях комментарии можно раз в:<br />
<input type="text" name="news" value="'.$sql['news'].'"/> сек.<br />
Оставлять в чате сообщения можно раз в:<br />
<input type="text" name="chat" value="'.$sql['chat'].'"/> сек.<br />
Оставлять сообщения на стенах можно раз в:<br />
<input type="text" name="stena" value="'.$sql['stena'].'"/> сек.<br />
Создавать темы в форуме можно раз в:<br />
<input type="text" name="forum_tema" value="'.$sql['forum_tema'].'"/> сек.<br />
Писать сообщения в теме можно раз в:<br />
<input type="text" name="forum_post" value="'.$sql['forum_post'].'"/> сек.<br />
Писать комментарии в блогах можно раз в:<br />
<input type="text" name="blog" value="'.$sql['blog'].'"/> сек.<br />
Писать сообщения в гостевой можно раз в:<br />
<input type="text" name="gust" value="'.$sql['guest'].'"/> сек.<br />
Писать комментарии в загрузках можно раз в:<br />
<input type="text" name="down" value="'.$sql['down'].'"/> сек.<br />
Писать сообщения можно раз в:<br />
<input type="text" name="mes" value="'.$sql['mes'].'"/> сек.<br />
Добавлять друзей можно раз в:<br />
<input type="text" name="friends" value="'.$sql['friends'].'"/> сек.<br />
Изменять репутацию можно раз в:<br />
<input type="text" name="repa" value="'.$sql['repa'].'"/> дн.<br />
<input type="submit" name="ok" value="Установить" />
</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';

break;
case 'us':

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Управление пользователями</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$k_post = $start+1;

$us = mysql_query("SELECT * FROM `users` ORDER BY `id` LIMIT $start, $max");
while($u = mysql_fetch_assoc($us))
{
echo '<div class="menu">'.$k_post++.') '.nick($u['id']).' ID: '.$u['id'].'<br />[<a href="'.$HOME.'/panel/delete_us_'.$u['id'].'">удал</a>] [<a href="'.$HOME.'/panel/up_us_'.$u['id'].'">ред</a>] ';

$ban = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$u['id']."'"));
if($u['id'] != 1) {

if(empty($ban)) {
echo '[<a href="'.$HOME.'/panel/ban/list/addban'.$u['id'].'">забанить</a>]';
} else { 
echo '[<a href="'.$HOME.'/panel/ban/list/updateban'.$u['id'].'">разбанить</a>]';
}

}

echo '</div>
<div class="menu">Дата реги.: '.vremja($u['datareg']).'<br />
Браузер: '.$u['browser'].'<br />
IP: '.$u['ip'].'<br />
Обновлялся: '.vremja($u['viz']).'
</div>';
}

if ($k_page > 1) {
echo str(''.$HOME.'/panel/users?',$k_page,$page); // Вывод страниц
}

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';


break;
case 'deleteus':
if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}
$id = abs(intval($_GET['id']));
$del_us = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}


echo '<div class="menu"><a href="'.$HOME.'/user/cab.php">Личный кабинет</a> | <a href="'.$HOME.'/panel/">Админ панель</a> | Удалить пользователя</div>';

if($del_us == 0 or $id == 1) {
echo '<div class="menu"><center><b>Ошибка!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['okda'])) {
mysql_query("DELETE FROM `users` where `id` = '".$id."'");
header('Location: /panel/users');
exit();
}

echo '<div class="menu">Вы действительно хотите удалить данного пользователя?<br /><a href="'.$HOME.'/panel/delete_us_'.$id.'?okda">Да</a></div>';

break;
case 'set':

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Настройки сайта</div>';

if(isset($_REQUEST['ok'])) {

$key = strong($_POST['key']);
$des = strong($_POST['des']);
$cop = strong($_POST['cop']); 
$reg_on = abs(intval($_POST['reg_on'])); 
$load_mod = abs(intval($_POST['load_mod'])); 
if(empty($key)) {
echo '<div class="menu"><center><b>Вы не ввели Keywords!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($key) < 3 or mb_strlen($key) > 500) {
echo '<div class="menu"><center><b>Введите Keywords от 3 до 500 символов!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($des)) {
echo '<div class="menu"><center><b>Вы не ввели Description!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($des) < 3 or mb_strlen($des) > 500) {
echo '<div class="menu"><center><b>Введите Description от 3 до 500 символов!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($cop)) {
echo '<div class="menu"><center><b>Вы не ввели Копирайт!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($cop) < 2 or mb_strlen($cop) > 50) {
echo '<div class="menu"><center><b>Введите Копирайт от 2 до 50 символов!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("UPDATE `settings` SET `key` = '".$key."', `des` = '".$des."', `cop` = '".$cop."', `reg_on` = '".$reg_on."', `load_mod` = '".$load_mod."' WHERE `id` = '1'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<div class="menu">» <a href="?act=set">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

echo '<div class="menu">';
echo '<form action="" method="POST">
Keywords:<br /><input type="text" name="key" value="'.$sql['key'].'" maxlength="500" /><br />
Description:<br /><input type="text" name="des" value="'.$sql['des'].'" maxlength="500" /><br />
Копирайт:<br /><input type="text" name="cop" value="'.$sql['cop'].'" maxlength="50" /><br />';

echo 'Настройки регистрации:<br/><select name="reg_on">';
$dat = array('Включена' => '0', 'Выключена' => '1');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $sql['reg_on'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><br/>';

echo 'Модерация файлов:<br/><select name="load_mod">';
$dat = array('Включена' => '0', 'Отключена' => '1');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $sql['load_mod'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><br/>';



echo '<input type="submit" name="ok" value="Сохранить" />';
echo '</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';

break;
case 'rules':

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Настройки правил</div>';

if(isset($_REQUEST['ok'])) {

$site = strong($_POST['site']);
$forum = strong($_POST['forum']);
$chat = strong($_POST['chat']);

if(empty($site)) {
echo '<div class="menu"><center><b>Введите правила сайта</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($forum)) {
echo '<div class="menu"><center><b>Введите правила форума</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($chat)) {
echo '<div class="menu"><center><b>Введите правила чата</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("UPDATE `rules` SET `site` = '".$site."', `forum` = '".$forum."', `chat` = '".$chat."'");
echo '<div class="menu"><center><b>Правила успешно изменены!</b></center></div>';
echo '<div class="menu">» <a href="?act=rules">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

$db = mysql_fetch_assoc(mysql_query("SELECT * FROM `rules`"));

echo '<div class="menu">
<form action="" method="POST">
*Правила сайта:<br /><textarea name="site">'.$db['site'].'</textarea><br />
*Правила в форуме:<br /><textarea name="forum">'.$db['forum'].'</textarea><br />
*Правила в чате:<br /><textarea name="chat">'.$db['chat'].'</textarea><br />
<input type="submit" name="ok" value="Сохранить" />
</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';

break;
case 'upus':

if (isset($_POST['verified']) && ($_POST['verified']==1 || $_POST['verified']==0)){
$ank['verified']=$_POST['verified'];
mysql_query("UPDATE `user` SET `verified` = '$ank[verified]' WHERE `id` = '$ank[id]' LIMIT 1");
}

else $err='Ошибка режима пользователя';

$id = abs(intval($_GET['id']));
$up_us = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

if($up_us == 0 or $id == 1 || $up_us['id'] == $user['id']) {
if($id != $user['id']){
echo err($title, 'Доступ закрыт!');
include ('../CGcore/footer.php'); exit;
}
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Редактировать пользователя</div>';

if(isset($_REQUEST['ok'])) {

$login = strong($_POST['login']);
$name = strong($_POST['name']);
$strana = strong($_POST['strana']);
$gorod = strong($_POST['gorod']);
$osebe = strong($_POST['osebe']);
$level = abs(intval($_POST['level']));
$email = strong($_POST['email']);
$money = abs(intval($_POST['money']));
$url = strong($_POST['url']);
$verified = abs(intval($_POST['verified']));
$sex = abs(intval($_POST['sex']));


if (!preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $email)) {
echo '<div class="menu"><center><b>Формат e-mail введён не верно!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("UPDATE `users` SET `login` = '".$login."', `name` = '".$name."', `strana` = '".$strana."', `gorod` = '".$gorod."', `osebe` = '".$osebe."', `level` = '".$level."', `verified` = '".$verified."', `email` = '".$email."', `money` = '".$money."', `url` = '".$url."', `sex` = '".$sex."'WHERE `id` = '".$id."'");
echo '<div class="ok">Пользователь отредактирован</div>';
}

echo '<div class="menu">Редактирование пользователя:  '.nick($up_us['id']).'</div><div class="menu">
<form action="" method="POST">
Ник:<br /><input type="text" name="login" maxlength="25" value="'.$up_us['login'].'" /><br />
Имя:<br /><input type="text" name="name" maxlength="45" value="'.$up_us['name'].'" /><br />
Страна:<br /><input type="text" name="strana" maxlength="40" value="'.$up_us['strana'].'" /><br />
Город:<br /><input type="text" name="gorod" maxlength="40" value="'.$up_us['gorod'].'" /><br />
О себе:<br /><input type="text" name="osebe" maxlength="100" value="'.$up_us['osebe'].'" /><br />
Сайт:<br /><input type="text" name="url" maxlength="20" value="'.$up_us['url'].'" /><br />
Coins:<br /><input type="text" name="money" maxlength="1000" value="'.$up_us['money'].'" /><br />';

echo '<select name="sex">';
$dat = array('Мужской' => '1', 'Женский' => '2');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $up_us['sex'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><br/>';

echo '<select name="verified">';
$dat = array('Мошенническая' => '1', 'Пользовательская' => '0');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $up_us['verified'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><br/>';

echo '<select name="level">';
$dat = array('Юзер' => '0', 'Модератор' => '1', 'Админ' => '2', 'Директор' => '3');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $up_us['level'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><br/>';

echo 'E-MAIL:<br /><input type="text" name="email" value="'.$up_us['email'].'" maxlength="50" /><br />
<input type="submit" name="ok" value="Сохранить" />
</form></div>';


echo '<div class="menu" style="color: #d6d6d6; font-size: 15px;">Сменить пароль</div>';



if(isset($_REQUEST['retpass'])) {

$np = strong($_POST['np']);

if(empty($np)) {
echo err($title, 'Введите новый пароль!');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($np) < 3) {
echo err($title, 'Минимум 3 символа');
include ('../CGcore/footer.php'); exit;
}

if (!preg_match('|^[A-Za-z0-9@._-]+$|i', $np)) {
echo err($title, 'Кириллица запрещена в новом пароле!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("UPDATE `users` SET `pass` = '".md5(md5(md5($np)))."' WHERE `id` = '".$id."'");
echo '<div class="menu"><center>Пароль успешно изменен на: <b>'.$np.' </b></center></div>';

}

echo '
<div class="menu"><form action="" method="POST">
*Новый пароль:<br /><input type="text" name="np" maxlength="25" /><br />
<input type="submit" name="retpass" value="Сменить" />
</form></div>';

break;

case 'load_mod':

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Файлы на модерации</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `load_file` WHERE `mod` = '0'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

if (isset($_GET['mod'])){
   mysql_query("UPDATE `load_file` SET `mod` = '1' WHERE `id` = '".abs(intval($_GET['mod']))."'");
}


$mod = mysql_query("SELECT * FROM `load_file` WHERE `mod` = '0' ORDER BY `time` DESC LIMIT $start,$max");

while($m = mysql_fetch_assoc($mod)){  
echo '<div class="menu">'.nick($m['avtor']).' '.vremja($m['time']).'<br />
Файл: <a href="'.$HOME.'/down/file'.$m['id'].'">'.$m['name'].'</a> <br/>
<a href="'.$HOME.'/panel/load_mod?mod='.$m['id'].'"><b>Одобрить</b></a> | <a href="'.$HOME.'/down/ban'.$m['id'].'"><font color="red">Заблокировать</font></a>
</div>';
}

if($k_post < 1) {
echo '<div class="menu"><center><b>Файлов на модерации нет!</b></center></div>';
}

if ($k_page > 1) {
echo str(''.$HOME.'/panel/load_mod/',$k_page,$page); // Вывод страниц
}


break;

case 'count':

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Счётчики</div>';

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

if(isset($_POST['counter'])){	
mysql_query("UPDATE `settings` SET `counter` = '".mysql_real_escape_string($_POST['counter'])."' WHERE `id` = '1'");
echo '<div class="menu"><b>Счётчики на главной успешно обновлены!</b></div>';
echo '<div class="menu">» <a href="?act=count">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><form action="?act=count" method="POST">
Счётчики на главной: <br/>
<textarea name="counter" cols="44" rows="10">'.$sql['counter'].'</textarea><br/>
<input type="submit" value="Обновить"></form></div>';


if(isset($_POST['counter_all'])){	
mysql_query("UPDATE `settings` SET `counter_all` = '".mysql_real_escape_string($_POST['counter_all'])."' WHERE `id` = '1'");
echo '<div class="menu"><b>Счётчики на остальных страницах успешно обновлены!</b></div>';
echo '<div class="menu">» <a href="?act=count">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}


echo '<div class="menu"><form action="?act=count" method="POST">
Счётчики на остальных страницах: <br/>
<textarea name="counter_all" cols="44" rows="10">'.$sql['counter_all'].'</textarea><br/>
<input type="submit" value="Обновить"></form></div>';
break;

case 'bonus':

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Бонусы</div>';

if(isset($_REQUEST['ok'])) {

$forum_post_m = abs(intval($_POST['forum_post_m']));
$forum_tem_m = abs(intval($_POST['forum_tem_m']));
$down_file_m = abs(intval($_POST['down_file_m'])); 
$guest_post_m = abs(intval($_POST['guest_post_m'])); 


mysql_query("UPDATE `settings` SET `forum_post_m` = '".$forum_post_m."', `forum_tem_m` = '".$forum_tem_m."', `down_file_m` = '".$down_file_m."', `guest_post_m` = '".$guest_post_m."' WHERE `id` = '1'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<div class="menu">» <a href="?act=bonus">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

echo '<div class="menu"><form action="" method="POST">
За тему на форуме начислять:<br /><input type="text" name="forum_post_m" value="'.$sql['forum_post_m'].'" maxlength="5" />стронг.<br />
За пост на форуме начислять:<br /><input type="text" name="forum_tem_m" value="'.$sql['forum_tem_m'].'" maxlength="5" />стронг.<br />
За пост в гостевой начислять:<br /><input type="text" name="guest_post_m" value="'.$sql['guest_post_m'].'" maxlength="5" />стронг.<br />
За загруженый файл в ЗЦ начилять:<br /><input type="text" name="down_file_m" value="'.$sql['down_file_m'].'" maxlength="5" />стронг.<br />';
echo '<input type="submit" name="ok" value="Сохранить" />';
echo '</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';

break;

case 'prefix-them':

$id = abs(intval($_GET['id']));

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

$pref = mysql_query("SELECT * FROM `forum_prefix` ORDER BY `id` LIMIT 999");
echo '<div class="menu"><b style="font-size: 14px;">Префиксы 1:</b></div>';
while($p1 = mysql_fetch_assoc($pref)) {
echo '<div class="menu"><span class="prefix_for_them" style="'.$p1['style'].'">'.$p1['name'].'</span><a href="'.$HOME.'/panel/?act=edit_prefix&id='.$p1['id'].'" style="float: right">Редактировать</a></div>';
}
$pref2 = mysql_query("SELECT * FROM `forum_prefix2` ORDER BY `id` LIMIT 999");
echo '<div class="menu"><b style="font-size: 14px;">Префиксы 2:</b></div>';
while($p2 = mysql_fetch_assoc($pref2)) {
echo '<div class="menu"><span class="prefix_for_them" style="'.$p2['style'].'">'.$p2['name'].'</span><a href="'.$HOME.'/panel/?act=edit_prefix2&id='.$p2['id'].'" style="float: right">Редактировать</a></div>';
}
echo '<a class="link" href="?act=new_prefix"><i class="fas fa-plus"> </i> Создать префикс</a>';
break;


case 'edit_prefix':

$id = abs(intval($_GET['id']));
$forum_pref = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix` WHERE `id` = '".$id."'"));


if(isset($_REQUEST['ok_pref'])) {

$forum_pref_name = strong($_POST['forum_pref_name']);
$forum_pref_style = strong($_POST['forum_pref_style']);

mysql_query("UPDATE `forum_prefix` SET `name` = '".$forum_pref_name."', `style` = '".$forum_pref_style."' WHERE `id` = '".$forum_pref['id']."'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<div class="menu">» <a href="?act=edit_prefix&id='.$id.'">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

if(isset($_REQUEST['pref_del'])) {
mysql_query("DELETE FROM `forum_prefix` WHERE `id` = '".$forum_pref['id']."'");
header('Location: '.$HOME.'/panel/?act=edit_prefix');
exit();
}


echo '<div id="pref_del" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Подтверждение удаления</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Вы действительно хотите удалить префикс '.$forum_pref['name'].'?</div>
		<br />
	 <br />
  <br />
  <form name="form" action="" method="post">
		<center><input type="submit" name="pref_del" value="Удалить" style="margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
       </form>
	   <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';


echo'<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<span class="prefix_t" style="'.$forum_pref['style'].'; margin-bottom: 15px">'.$forum_pref['name'].'</span><a href="#pref_del" style="float: right; margin-top: 3px;">Удалить</a>';

echo '<form action="" method="POST">
Префикс:<br /><input type="text" name="forum_pref_name" value="'.$forum_pref['name'].'" /><br />
Цвет префикса:<br /><input type="text" name="forum_pref_style" value="'.$forum_pref['style'].'" />';
echo '<input type="submit" name="ok_pref" value="Сохранить" />';

echo '</form>';
echo '</div>';
break;





case 'edit_prefix2':

$id = abs(intval($_GET['id']));
$forum_pref2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix2` WHERE `id` = '".$id."'"));


if(isset($_REQUEST['ok_pref2'])) {

$forum_pref2_name = strong($_POST['forum_pref2_name']);
$forum_pref2_style = strong($_POST['forum_pref2_style']);

mysql_query("UPDATE `forum_prefix2` SET `name` = '".$forum_pref2_name."', `style` = '".$forum_pref2_style."' WHERE `id` = '".$forum_pref2['id']."'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<div class="menu">» <a href="?act=edit_prefix2&id='.$id.'">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}

if(isset($_REQUEST['pref_del2'])) {
mysql_query("DELETE FROM `forum_prefix2` WHERE `id` = '".$forum_pref2['id']."'");
header('Location: '.$HOME.'/panel/?act=edit_prefix2');
exit();
}


echo '<div id="pref_del2" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Подтверждение удаления</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Вы действительно хотите удалить префикс '.$forum_pref2['name'].'?</div>
		<br />
	 <br />
  <br />
  <form name="form" action="" method="post">
		<center><input type="submit" name="pref_del2" value="Удалить" style="margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
       </form>
	   <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';


echo'<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<span class="prefix_t" style="'.$forum_pref2['style'].'; margin-bottom: 15px">'.$forum_pref2['name'].'</span><a href="#pref_del" style="float: right; margin-top: 3px;">Удалить</a>';

echo '<form action="" method="POST">
Префикс:<br /><input type="text" name="forum_pref2_name" value="'.$forum_pref2['name'].'" /><br />
Цвет префикса:<br /><input type="text" name="forum_pref2_style" value="'.$forum_pref2['style'].'" />';
echo '<input type="submit" name="ok_pref2" value="Сохранить" />';

echo '</form>';
echo '</div>';
break;




case 'new_prefix':

if(isset($_REQUEST['set_prefix'])) {

$new_pref_name = strong($_POST['new_pref_name']);
$new_pref_style = strong($_POST['new_pref_style']);
$new_pref_name2 = strong($_POST['new_pref_name2']);
$new_pref_style2 = strong($_POST['new_pref_style2']);

mysql_query("INSERT INTO `forum_prefix` (`name`, `style`) VALUES ('".$new_pref_name."', '".$new_pref_style."')");

mysql_query("INSERT INTO `forum_prefix2` SET `name` = '".$new_pref_name2."',`style` = '".$new_pref_style2."'");

echo '<div class="menu"><center><b>Префиксы созданы!</b></center></div>';
echo '<div class="menu">» <a href="?act=prefix-them">Вернуться назад</a></div>';
include ('../CGcore/footer.php'); exit;
}


echo'<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<span class="prefix_t" style="background: #555; color: #222; margin-bottom: 15px; width: 50px;"><center><i class="fas fa-plus"></i></center></span>';

echo '<form action="" method="POST">
Префикс 1<br />
Префикс:<br /><input type="text" name="new_pref_name" placeholder="Форум" /><br />
Цвет префикса:<br /><input type="text" name="new_pref_style" placeholder="background-color: #000" /><br />

Префикс 2<br />
Префикс:<br /><input type="text" name="new_pref_name2" placeholder="Форум" /><br />
Цвет префикса:<br /><input type="text" name="new_pref_style2" placeholder="background-color: #000" />';
echo '<input type="submit" name="set_prefix" value="Сохранить" /></form>';

echo '</div>';

break;


}
//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>