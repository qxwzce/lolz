<?php

//-Находим пользователей забаненных-//
session_start();

$_SESSION['access'] = TRUE;

if(isset($user['id'])) {

$bl = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$user['id']."' LIMIT 1"));//которые уже освободились
$ban_list = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$user['id']."' && `time_end` > '".time()."' LIMIT 1"));//еще в бане

if($ban_list != 0) {
include $_SERVER['DOCUMENT_ROOT'].'/CGcore/head.php';

echo '<style>
.content {
margin: 65px 0px 25px 0px;
padding: 40px 0;
}
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content {
margin: 65px 0px 25px 0px;
}
</style>';

echo '<center><div class="icon_window"><img src="https://hack-lair.com/images/lock.svg" style="width: 100px; height: 100px;"></div></center><br />';
echo '<center><div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;">Доступ к сайту запрещён</div></center>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Ваш аккаунт был заблокирован по причине:</center><br /><center><b><span class="news" style="margin-top: 10px; background-color: #2d2d2d; padding: 5px 15px; border-radius: 5px;"">'.smile(bb($ban_list['about'])).'</center></b></span></div>
<div class="podmenu" style="margin-top: 5px;"><center>Дата разблокировки: <b>'.date('d.m.Y в H:i',$ban_list['time_end']).'</center></b></div><br /><hr><br />
<div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;"><center>Считаете что это ошибка?</center></div>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Узнать подробности или обжаловать блокировку можно нажав на кнопку ниже:</center></div><br />
<center><a class="log" href="mailto:grove.info@bk.ru" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">Связаться с нами</a></center><br /><hr><br />
<div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;"><center>Платная разблокировка</center></div>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Сумма разблокировки зависит от причины бана, узнать сумму можно перейдя на страницу <a href="https://hack-lair.com/ban/pardon.php" style="color: #228e5d; cursor: pointer;">платный разбан</a>.</center></div>';

if(isset($_REQUEST['ok'])) {

$about = strong($_POST['about']);



/* Антиспам */
$pr = mysql_result(mysql_query("SELECT COUNT(id) FROM `jalob_ba` WHERE `avtor` = '".$user['id']."'"),0);
if($pr != 0) {
echo '<div class="podmenu"><center><b>Вы уже своё сказали!</b></center></div>';
include $_SERVER['DOCUMENT_ROOT'].'/CGcore/footer.php';
exit();
}

mysql_query("INSERT INTO `jalob_ba` SET `about` = '".$about."', `avtor` = '".$user['id']."', `komy` = '1', `time` = '".time()."'");
header('Location: '.$HOME.'');
exit();
}

$pr = mysql_result(mysql_query("SELECT COUNT(id) FROM `jalob_ba` WHERE `avtor` = '".$user['id']."'"),0);

if($pr == 0) {
echo '<div>
</form></div>';
} else {
$list = mysql_query("SELECT * FROM `jalob_ba` WHERE `avtor` = '".$user['id']."' ORDER bY `id` DESC ");

while($l = mysql_fetch_assoc($list))
{
echo '<div class="links">'.nick($l['avtor']).' ('.vremja($l['time']).')</div><div class="podmenu">'.smile(bb($l['about'])).'</div>';
}

include $_SERVER['DOCUMENT_ROOT'].'/CGcore/footer.php';
exit();
}

$chet = mysql_result(mysql_query("SELECT COUNT(id) FROM `jalob_ba` WHERE `avtor` = '".$user['id']."'"),0);
if($chet == 0) 

include $_SERVER['DOCUMENT_ROOT'].'/CGcore/footer.php';
exit();
}else if($bl['time_end'] < time())
{
mysql_query("DELETE FROM `ban_list` WHERE `kto` = '".$bl['kto']."'");
}
}
?>