<?
include ('CGcore/core.php');
include ('CGcore/head.php');

echo '<title>Новости портала</title>';
echo '<description>'.$news['text'].'</description>';

if(!isset($user['id'])) {
echo '<style>
.lin_com {
	pointer-events: none;
}
</style>';
}

$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act)
{
default:

echo '<div class="menu" style="color: #d6d6d6;">Новости</div>';

if($user['level'] == 3) echo '<a style="margin-bottom:10px;" class="link" href="/news/addnews"><span class="icon"><i class="fas fa-plus"></i></span> Добавить новость</a>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `news`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$sql = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $start, $max");

while($sql1 = mysql_fetch_assoc($sql)){
echo '<div class="menu">';
echo '<span class="time" style="background-color: #526380; color: #FFFFFF; margin: 0px; border-radius: 7px; padding-left: 6px; padding-right: 6px; padding-top: 2px; padding-bottom: 2px; font-size: 10px;">'.vremja($sql1['time']).'</span></br></br><a class="lin_com" href="/news/comment'.$sql1['id'].'">'.nl2br(smile(bb($sql1['text']))).'</a></br></br>';
echo '</div>';

if($user['level'] >= 3){
echo '<table style="width:100%;text-align:center;" cellspacing="0" cellpadding="0">';
echo '<td><a class="link" href="/news/upnew_'.$sql1['id'].'">Изменить</a></td>';
echo '<td><a class="link" href="/news/delnew_'.$sql1['id'].'">Удалить</a></td>';
echo '</table>';
} 

echo '<div style="margin-bottom:0px;"></div>';

}

if($k_post < 1) echo '<div class="menu">Новостей нет</div>';
if($k_page>1) echo str('/news/'.$id.'?',$k_page,$page); // Вывод страниц

break;
case 'upnew':

/* Переадресация если нету должности */
if($user['level'] < 3) {
header('Location: '.$HOME.'/news');
exit();
}

/* Делаем запрос для вывода */
$id = abs(intval($_GET['id']));
$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news` WHERE `id` = '".$id."'"));
if($news == 0) {
echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Ошибка</div><div class="podmenu"><center><b>Такой новости пока еще нет!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Редактировать новость</div>';
/* Если нажали кнопку */
if(isset($_REQUEST['true'])) {

/* Фильтрация и вывод ошибки */
$text = strong($_POST['msg']);
if(empty($text)) {
echo '<div class="podmenu"><center><b>Введите текст новости!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

/* Вывод ошибки */
if(mb_strlen($text) < 5) {
echo '<div class="podmenu"><center><b>Введите текст новости от 5 символов!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

/* Делаем запрос */
mysql_query("UPDATE `news` SET `text` = '".$text."' WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/news/');
exit();
}

echo '<div class="podmenu"><form action="" name="message" method="POST">
Текст новости:<br />';
if($user['bb_panel'] == 1) {
include ('CGcore/bbcode.php');  
}
echo '<textarea name="msg">'.$news['text'].'</textarea><br />
<input type="submit" name="true" value="Изменить" />
</form></div>';

break;
case 'delnew':

/* Переадресация если нету должности */
if($user['level'] < 3) {
header('Location: '.$HOME.'/news');
exit();
}

/* Делаем запрос для вывода */
$id = abs(intval($_GET['id']));
$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news` WHERE `id` = '".$id."'"));
if($news == 0) {
echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Ошибка</div><div class="podmenu"><center><b>Такой новости пока еще нет!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Удаление новости</div>';

/* Если согласились с удалением */
if(isset($_REQUEST['true'])) {
mysql_query("DELETE FROM `news` where `id` = '".$id."'");
header('Location: '.$HOME.'/news/');
exit();
}

/* Подтверждение */
echo '<div class="podmenu">Вы действительно хотите удалить эту новость?<br /><br />
<a href="'.$HOME.'/news/delnew_'.$id.'?true" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin-top: 5px;">Да</a><a href="'.$HOME.'/news" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin: 5px;">Нет</a>';
break;
case 'addnews':

/* Переадресация если нету должности */
if($user['level'] != 3) {
header('Location: /index.php');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Добавить новость</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

/* Фильтрация и вывод ошибки */
$text = strong($_POST['msg']);
if(empty($text)) {
echo '<div class="podmenu"><center><b>Введите содержание новости!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

/* Вывод ошибки */
if(mb_strlen($text) < 5 ) {
echo '<div class="podmenu"><center><b>Введите минимум 5 символов!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

/* Делаем запрос */
mysql_query("INSERT INTO `news` SET `text` = '".$text."', `avtor` = '".$user['id']."', `time` = '".time()."'");
header('Location: /news.php');
}

echo '<div class="podmenu"><form action="" name="message" method="POST">
*Содержание новости:<br />';
if($user['bb_panel'] == 1) {
include ('CGcore/bbcode.php');  
}
echo '<textarea row="3" name="msg"></textarea><br />
<input type="submit" value="Создать" name="submit" />
<form></div>';

break;
case 'comment':

/* Делаем запрос для вывода */
$id = abs(intval($_GET['id']));
$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news` WHERE `id` = '".$id."'"));
if($news == 0) {
echo '<div class="title">Новости | Ошибка</div><div class="podmenu"><b>Новость не существует!</b></div>';
include ('CGcore/footer.php');
exit();
}

echo '<div class="title">Новости</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['add'])) {

/* Фильтрация и вывод ошибки */
$msg = strong($_POST['msg']);
if(empty($msg)) {
echo '<div class="err">Вы не ввели сообщение</div>';
include ('CGcore/footer.php');
exit();
}

/* Вывод ошибки */
if(mb_strlen($msg) < 3) {
echo '<div class="err">Сообщение содержит меньше 3-х символов</div>';
include ('CGcore/footer.php');
exit();
}

$ttte = mysql_fetch_array(mysql_query('select * from `news_com` where `avtor` = "'.$user['id'].'" and `msg` = "'.$msg.'"'));
if($ttte != 0) {
echo '<div class="err">Пост был написан ранее</div>';
include ('CGcore/footer.php');
exit();
}

/* Антиспам */
$tim = mysql_query("SELECT * FROM `news_com` WHERE `avtor`='".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)) {  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `news` "));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['news']) {
echo '<div class="err">Пишите не чаще чем раз в '.$news_antispam['news'].' секунд</div>';
include ('CGcore/footer.php');
exit();
}
}

/* Делаем запрос*/
mysql_query("INSERT INTO `news_com` SET `msg` = '".$msg."', `avtorlogin` = '".$user['login']."', `avtor` = '".$user['id']."', `time` = '".time()."', `news` = '".$id."'");
if($user['id'] != $news['avtor']) {
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$news['avtor']."', `kto` = '".$user['id']."', `text` = 'оставил комментарий к вашей [url=".$HOME."/news/comment".$news['id']."?selection=top]новости[/url]'");
}

header('Location: /news/comment'.$id.'');
exit();
}

echo '<div class="menu">'.nl2br(smile(bb($news['text']))).'</div>';
echo '<div class="menu">';
echo '<form action="" name="message" method="POST">';
echo '<textarea placeholder="Введите сообщение..." name="msg"></textarea><br />
<input type="submit" name="add" value="Отправить">
</form>';
echo '</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `news_com` WHERE `news` = '".$id."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$com = mysql_query("SELECT * FROM `news_com` WHERE `news` = '".$id."' ORDER BY `id` DESC LIMIT $start, $max");

while($c = mysql_fetch_assoc($com)){
    
if($user['level'] >= 1) $ddel = '[<a href="/news/delcom_'.$c['id'].'">уд</a>]';
echo '<div class="menu">'.nick($c['avtor']).' '.$ddel.' <span class="time">'.vremja($c['time']).'</span></br>';
if($user['id'] != $c['avtor']) echo '[<a href="/news/otvet_'.$c['id'].'">отв</a>]';
echo '<div style="padding: 5px 0 5px 0;">'.smile(bb($c['msg'])).'</div>';
echo '</div>';

}

/* Если сообщений еще нету*/
if($k_post < 1) echo '<div class="menu">Комментариев нет</div>';
if($k_page>1) echo str('comment'.$id.'?',$k_page,$page); // Вывод страниц

break;
case 'delcom':

/* Делаем запрос для удаления */
$id = abs(intval($_GET['id']));
$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news_com` WHERE `id` = '".$id."'"));

if($user['level'] < 1) {
header('Location: '.$HOME.'/news/comment'.$news['news'].'');
exit();
}

/* Удаляем */
if(isset($_REQUEST['ok'])) {

if($news != 0) {
mysql_query("DELETE FROM `news_com` WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/news/comment'.$news['news'].'');
exit();
} else {
header('Location: '.$HOME.'');
exit();
}

}

echo '<div class="title"><a href="'.$HOME.'/news/">Новости портала</a> | Удалить комментарий</div>
<div class="podmenu">Вы действительно хотите удалить этот комментарий?<br /><br />
<a href="'.$HOME.'/news/delcom_'.$id.'?ok" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin-top: 5px; color: #FFFFFF;">Да</a><a href="'.$HOME.'/news/comment'.$id.'?" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin: 5px; color: #FFFFFF;">Нет</a>';

break;
case 'otvet':

/* Делаем запрос для вывода */
$id = abs(intval($_GET['id']));
$news = mysql_fetch_assoc(mysql_query("SELECT * FROM `news_com` WHERE `id` = '".$id."'"));

if($news == 0) {
echo '<div class="title">Новости</div><div class="err">Такого сообщения нет</div>';
include ('CGcore/footer.php');
exit();
}

if($user['id'] == $news['avtor']) {
header('Location: /news/comment'.$news['news'].'');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/news">Новости портала</a> | Ответ</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

/* Фильтрация и вывод ошибки */
$msg = strong($_POST['msggg']);

if(empty($msg)) {
echo '<div class="err">Вы не ввели сообщение</div>';
include ('CGcore/footer.php');
exit();
}

/* Вывод ошибки */
if(mb_strlen($msg) < 3) {
echo '<div class="err">Сообщение содержит меньше 3-х символов</div>';
include ('CGcore/footer.php');
exit();
}

/* Антиспам */
$anti = mysql_query("SELECT `news` FROM `antispam`");
while($an = mysql_fetch_assoc($anti)){
$tim = mysql_query("SELECT * FROM `news_com` WHERE `avtor`='".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $an['news'])
{
echo '<div class="err">Пишите не чаще чем раз в '.$an['news'].' секунд</div>';
include ('CGcore/footer.php');
exit();
}
}
}

/* Делаем запрос */
mysql_query("INSERT INTO `news_com` SET `msg` = '[b]".$news['avtorlogin'].",[/b]".$msg."', `avtorlogin` = '".$users['login']."', `avtor` = '".$user['id']."', `time` = '".time()."', `news` = '".$news['news']."'");
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$news['avtor']."', `kto` = '".$user['id']."', `text` = 'ответил на Ваш комментарий к [url=".$HOME."/news/comment".$news['news']."?selection=top]новости[/url]'");
header('Location: /news/comment'.$news['news'].'');
exit();
}

echo '<div class="podmenu">Ответ: '.nick($news['avtor']).'</div><div class="podmenu"><form action="" name="message" method="POST">
*Сообщение:<br />';
if($user['bb_panel'] == 1) {
include ('CGcore/bbcode.php');  
}
echo '<textarea name="msg" ></textarea><br />
<input type="submit" name="submit" value="Ответить" />
</form></div>
<div class="links">» <a href="'.$HOME.'/news/comment'.$news['news'].'">Назад в комментарии</a></div>';

break;
}

//-----Подключаем низ-----//
include ('CGcore/footer.php');
?>