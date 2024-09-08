<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!isset($user['id'])) {

include ('../design/element-styles/them-style-guest.php');

}

##############################
########## Главная ###########
##############################
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act) {
default:

echo '<title>Вывод категорий - '.$index['pod-title'].'</title>';

echo '<div class="menu" style="border-bottom: 0px;">
<h1>Форум</h1>
<h2 class="kat_opisanie">Все категории форума</h2>
</div>';

$forum_r = mysql_query("SELECT * FROM `forum_razdel` ORDER BY `id` ASC");
while($a = mysql_fetch_assoc($forum_r))
{
echo '<a class="link" href="/forum/razdel'.$a['id'].'"><span class="icon"><i class="far fa-circle"></i></span> '.$a['name'].' <span class="c">'.mysql_result(mysql_query('select count(`id`) from `forum_kat` where `razdel` = "'.$a['id'].'"'),0).'/'.mysql_result(mysql_query('select count(`id`) from `forum_tema` where `razdel` = "'.$a['id'].'"'),0).'/'.mysql_result(mysql_query('select count(`id`) from `forum_post` where `razdel` = "'.$a['id'].'"'),0).'</span></a>';
if($user['level'] >= 3) echo '<div class="main" style="border-bottom: 0px;"><a href="/forum/red_razdel'.$a['id'].'">Изменить</a> | <a href="/forum/del_razdel'.$a['id'].'">Удалить</a></div>';
}

$count = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_razdel` "),0);
if($count < 1) echo '<div class="menu">Разделов пока что нет</div>';

include ('footers.php');

if($user['level'] >= 3) echo '<a class="link" href="/forum/nr" style="border-bottom: 0px; border: solid 1px #303030; border-radius: 7px;"><span class="icon"><i class="fas fa-plus"></i></span> Новый раздел</a>';

break;
##############################
### Редактирование раздела ###
##############################
case 'red_razdel':

$id = abs(intval($_GET['id']));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$id."'"));

if($forum_r == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такого раздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/">'.$forum_r['name'].'</a> | Редактирование</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$opis = strong($_POST['opis']);

if(mb_strlen($opis,'UTF-8') < 5) $err = 'Минимум для ввода 5 символов!';
if(empty($opis)) $err = 'Введите описание раздела!';
if(mb_strlen($name,'UTF-8') < 3) $err = 'Минимум для ввода 3 символа!';
if(empty($name)) $err = 'Введите название раздела!';

if($err) {
echo '<div class="menu"><center><b>'.$err.'</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

/* Делаем запрос */
mysql_query("UPDATE `forum_razdel` SET `name` = '".$name."',`opis` = '".$opis."' WHERE `id` = '".$id."'");
echo '<div class="ok">Успешно</div>';
}

echo '<div class="menu"><form action="" method="POST"> 
Имя раздела:<br /> <input type="text" name="name" value="'.$forum_r['name'].'"/><br />
Описание:<br /><textarea name="opis">'.$forum_r['opis'].'</textarea><br />
<input type="submit" name="submit" value="Редактировать" />
</form></div>
<div class="menu">
</div>
<div class="links">» <a href="'.$HOME.'/forum/">Назад в разделы</a></div>';

break;
##############################
## Редактирование категории ##
##############################
case 'red_kat':

$id = abs(intval($_GET['id']));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_k['razdel']."'"));

if($forum_k == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такого подраздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/razdel'.$forum_r['id'].'">'.$forum_r['name'].'</a> | <a href="'.$HOME.'/forum/razdel'.$forum_r['id'].'">'.$forum_k['name'].'</a> | Редактирование категории</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);

if(mb_strlen($name,'UTF-8') < 3) $err = 'Минимум для ввода 3 символа!';
if(empty($name)) $err = 'Введите название категории!';

if($err) {
echo '<div class="menu"><center><b>'.$err.'</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

/* Делаем запрос */
mysql_query("UPDATE `forum_kat` SET `name` = '".$name."' WHERE `id` = '".$id."'");
echo '<div class="menu"><center><b>Успешно!</b></center></div>';
}

echo '<div class="menu"><form action="" method="POST"> 
Название категории:<br /> <input type="text" name="name" value="'.$forum_k['name'].'"/><br />
<input type="submit" name="submit" value="Редактировать" />
</form></div>
<div class="links">» <a href="'.$HOME.'/forum/razdel'.$forum_r['id'].'">Назад в подразделы</a></div>';


break;
##############################
##### Удаление категории #####
##############################
case 'del_kat':

echo '<meta name="robots" content="noindex">';

$id = abs(intval($_GET['id']));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$id."'"));

if($forum_k == 0) {
echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Ошибка</div><div class="menu"><center><b>Такого подраздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['ok'])) {
mysql_query("DELETE FROM `forum_kat` where `id` = '".$id."'");
mysql_query("DELETE FROM `forum_tema` where `kat` = '".$id."'");
mysql_query("DELETE FROM `forum_post` where `kat` = '".$id."'");
header('Location: '.$HOME.'/forum/razdel'.$forum_k['razdel'].'');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Удаление подраздела</div>
<div class="menu">Вы действительно хотите удалить этот подраздел?<br /><a href="'.$HOME.'/forum/del_kat'.$id.'?ok">Да</a></div>';

break;
##############################
###### Удаление раздела ######
##############################
case 'del_razdel':

echo '<meta name="robots" content="noindex">';

$id = abs(intval($_GET['id']));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$id."'"));

if($forum_r == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такого раздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(isset($_REQUEST['ok'])) {
mysql_query("DELETE FROM `forum_razdel` where `id` = '".$id."'");
mysql_query("DELETE FROM `forum_kat` where `razdel` = '".$id."'");
mysql_query("DELETE FROM `forum_tema` where `razdel` = '".$id."'");
mysql_query("DELETE FROM `forum_post` where `razdel` = '".$id."'");
header('Location: '.$HOME.'/forum');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Удаление раздела</div>
<div class="menu">Вы действительно хотите удалить этот раздел?<br /><a href="'.$HOME.'/forum/del_razdel'.$id.'?ok">Да</a></div>';

break;
##############################
######## Новый раздел ########
##############################
case 'nr':

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | Новый раздел</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$opis = strong($_POST['opis']);

if(mb_strlen($opis,'UTF-8') < 3) $err= 'Минимум для ввода 3 символа!';
if(empty($opis)) $err= 'Введите описание раздела!';
if(mb_strlen($name,'UTF-8') < 3) $err= 'Минимум для ввода 3 символа!';
if(empty($name)) $err= 'Введите название раздела!';

if($err) {
echo '<div class="menu"><center><b>'.$err.'</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("INSERT INTO `forum_razdel` SET `name` = '".$name."',`opis` = '".$opis."'");
echo '<div class="menu"><center><b>Раздел успешно создан!</b></center></div>';
}

echo '<div class="menu"><form action="" method="POST"> 
Имя раздела:<br /> <input type="text" name="name" value=""/><br />
Описание:<br /><center><textarea name="opis"></textarea></center><br />
<input type="submit" name="submit" value="Создать" />
</form></div>
<div class="links">» <a href="'.$HOME.'/forum/">Назад в форум</a></div>';

break;
##############################
######## Вывод раздела #######
##############################
case 'razdel':

$id = abs(intval($_GET['id']));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$id."'"));

if($forum_r == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такого раздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<title>'.$forum_r['name'].' - '.$index['pod-title'].'</title>';

echo '<div class="menu" style="border-bottom: 0px;">
<h1>'.$forum_r['name'].'</h1>
<h2 class="kat_opisanie">Все разделы категории</h2>
</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_kat` WHERE `razdel` = '".$id."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$forum_k = mysql_query("SELECT * FROM `forum_kat` WHERE `razdel` = '".$id."' ORDER BY `id` ASC LIMIT $start, $max");

while($a = mysql_fetch_assoc($forum_k)){
    
echo '<a class="link" href="/forum/kat'.$a['id'].'"><span class="icon"><i class="far fa-circle"></i></span> '.$a['name'].'  
<span class="c" style="background-color: #526380; color: #FFFFFF; margin-top: 0px; border-radius: 15px;">'.mysql_result(mysql_query('select count(`id`) from `forum_tema` where `kat` = "'.$a['id'].'"'),0).'/'.mysql_result(mysql_query('select count(`id`) from `forum_post` where `kat` = "'.$a['id'].'"'),0).'</span></a>';
if($user['level'] >= 3) echo '<div class="main" style="border-bottom: 0px;"><a href="/forum/red_kat'.$a['id'].'">Изменить</a> | <a href="/forum/del_kat'.$a['id'].'">Удалить</a></div>';

}

if($k_post < 1) echo '<div class="menu">В данной категории разделов пока нет</div>';
if($user['level'] >= 3) echo '<a class="link" href="/forum/nk'.$id.'" style="border-bottom: 0px; border: solid 1px #303030; border-radius: 7px;"><span class="icon"><i class="fas fa-plus"></i></span> Новый подраздел</a>';

include ('footers.php');

if($k_page>1) echo str(''.$HOME.'/forum/razdel'.$id.'?',$k_page,$page); // Вывод страниц

break;
##############################
####### Вывод категории ######
##############################
case 'kat':

$id = abs(intval($_GET['id']));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_k['razdel']."'"));

if($forum_k == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Данный раздел не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<title>'.$forum_k['name'].' - '.$index['pod-title'].'</title>';
echo '<meta property="og:title" content="'.$forum_k['name'].'">';
echo '<meta name="description" content="'.$forum_k['opisanie'].'">';

echo '<div class="menu" style="border-bottom: 0px; font-size: 20px;">
<a class="kat_name"><h1>'.$forum_k['name'].'</h1><h2 class="kat_opisanie">'.$forum_k['opisanie'].'</h2></a></div>';

echo '<div class="menu_but" style="margin-bottom: 10px;">';
echo '<a class="long" onClick="refreshPage()"><i class="fas fa-sharp fa-regular fa-arrow-rotate-right fa-fw"></i></a>';
echo '<a class="log_nt" href="/forum/nt'.$id.'" style="border-bottom: 0px; border: none; border-radius: 7px; float: right; margin-top: -5px; margin-right: 10px; padding: 9px 12px;"><i class="fas fa-plus" style="margin-right: 10px;"></i><span class="but_name">Добавить тему</span></a>';
echo '<a class="log_nt_reg" href="/autch/login.php" style="border-bottom: 0px; border: solid 1px #303030; border-radius: 7px; float: right; margin-top: -5px; margin-right: 10px; padding: 9px 12px;">Авторизация</a>';
echo '</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `kat` = '".$id."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$forum_t = mysql_query("SELECT * FROM `forum_tema` WHERE `kat` = '".$id."' ORDER BY `id` and `status` = '2' DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($forum_t)) {
echo '<div class="lenta-tems">';
include ('../CGcore/div-link-thems-info.gt');
echo '</div>';
}

if($k_post < 1) echo '<div class="menu" style="border-bottom: 0px; padding-bottom: 10px; padding-top: 10px;"><b><center>В данном подразделе нет тем!</center></b></div>';
if($k_page > 1) echo str(''.$HOME.'/forum/kat'.$id.'?',$k_page,$page); // Вывод страниц

include ('footers.php');

break;
##############################
######### Новая тема #########
##############################
case 'nt':

$id = abs(intval($_GET['id']));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_k['razdel']."'"));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix` WHERE `id` = '".$id."'"));
$forum_p2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix2` WHERE `id` = '".$id."'"));

if($forum_k == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такой категории не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

include '../design/element-styles/new-them-style.php';

echo '<div class="menu" style="border-radius: 10px 10px 0 0;"><a href="'.$HOME.'">Главная</a> | <a href="'.$HOME.'/forum/kat'.$forum_k['id'].'">'.$forum_k['name'].'</a> | Новая тема</div>';

if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$text = strong($_POST['msg']);
$level = strong($_POST['level']);
$prefix = strong($_POST['prefix']);
$prefix2 = strong($_POST['prefix2']);

if(mb_strlen($name, 'UTF-8') > 500) {
echo '<div class="err">Слишком длинное название темы</br>(Максимум 500 символов)</div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($name)) {
echo '<div class="err">Вы не ввели название темы</div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($text)) {
echo '<div class="err">Вы не ввели текст темы</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 4) {
echo '<div class="err">Короткий текст темы</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) { 
echo '<div class="err">Авторизуйтесь чтобы создать тему</div>';
include ('../CGcore/footer.php');
exit();
}

$tema_spam = mysql_fetch_array(mysql_query('select * from `forum_tema` where `us` = "'.$user['id'].'" and `name` = "'.$name.'"'));
if($tema_spam != 0) {
echo '<div class="menu"><center><b>Вы такую тему уже создавали!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `forum_tema` WHERE `us`='".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `forum_tema` "));
$timeout = $t['time'];
if((time()-$timeout) < $forum_antispam['forum_tema']) {
echo '<div class="err">Создавать тему можно раз в '.$forum_antispam['forum_tema'].' секунд</div>';
include ('../CGcore/footer.php');
exit();
}
}




if($user['prev'] == 0){ mysql_query("INSERT INTO `forum_tema` SET `name` = '".$name."',`razdel` = '".$forum_r['id']."',`kat` = '".$id."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #d6d6d6'"); }
elseif($user['prev'] == 1){ mysql_query("INSERT INTO `forum_tema` SET `name` = '".$name."',`razdel` = '".$forum_r['id']."',`kat` = '".$id."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #d6d6d6'"); }
elseif($user['prev'] == 2){ mysql_query("INSERT INTO `forum_tema` SET `name` = '".$name."',`razdel` = '".$forum_r['id']."',`kat` = '".$id."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #ffff66'"); }

$sql = mysql_insert_id();
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.03)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("INSERT INTO `forum_post` SET `kat` = '".$id."',`text` = '".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$sql."',`razdel` = '".$forum_r['id']."'");
header('Location: /forum/tema'.$sql.'');
exit();
}

echo '<title>Создать тему в разделе '.$forum_k['name'].'</title>';
echo '<div class="menu">';
echo '<form action="" name="message" method="POST"> 
<span class="label">Заголовок</span><br />
<center><input placeholder="О чем ваша тема?" style="margin-left: 15px; margin-right: 15px; border-bottom: 0px;" type="text_nt" name="name" value=""/></center>';
echo '</div>';
echo '<div class="menu" style="border-bottom: 0px; padding-top: 18px;">';
echo '<div class="selections">';
include '../CGcore/set-prefix.php'; 
echo '<br />';
include '../CGcore/set-prefix-2.php'; 
echo '</div>';
echo '</div>';
echo '<div class="menu" style="border-bottom: 0px;">';
include ('../CGcore/bbcode.php'); 
echo '</div>';

echo '<div class="menu" style="border-bottom: 0px; border-radius: 0 0 10px 10px; padding: 0 10px 10px 10px;">';
echo '<center><textarea style="margin-left: 15px; margin-right: 15px; margin-bottom: 0px; height: 120px;" placeholder="Сообщение..." name="msg"></textarea></center>';
echo '<table style="margin-top: 13px;">';
echo '<input type="submit" style="margin: 0px; border-bottom: 0px; border-radius: 7px; display: inline-block; width: 150px; float: right; margin: 15px 15px 7px 15px;" name="submit" value="Создать тему" />';
echo '</table></form>';
echo '</div>';

include ('footers.php');

break;
################################
######### Новая статья #########
################################
case 'ns':

$id = abs(intval($_GET['id']));
$wiki_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix` WHERE `id` = '".$id."'"));
$wiki_p2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix2` WHERE `id` = '".$id."'"));

include '../design/element-styles/new-them-style.php';

echo '<div class="menu" style="border-radius: 10px 10px 0 0;"><a href="'.$HOME.'">Главная</a> | Новая статья</div>';

if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$text = strong($_POST['msg']);
$level = strong($_POST['level']);
$prefix = strong($_POST['prefix']);
$prefix2 = strong($_POST['prefix2']);

if(mb_strlen($name, 'UTF-8') > 150) {
echo '<div class="err">Слишком длинное название статьи</br>(Максимум 150 символов)</div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($name)) {
echo '<div class="err">Вы не ввели название статьи</div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($text)) {
echo '<div class="err">Вы не ввели текст статьи</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 4) {
echo '<div class="err">Короткий текст статьи</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) { 
echo '<div class="err">Авторизуйтесь чтобы написать статью</div>';
include ('../CGcore/footer.php');
exit();
}

$tema_spam = mysql_fetch_array(mysql_query('select * from `wiki_tema` where `us` = "'.$user['id'].'" and `name` = "'.$name.'"'));
if($tema_spam != 0) {
echo '<div class="menu"><center><b>Вы такую статью уже писали!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `wiki_tema` WHERE `us`='".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `wiki_tema` "));
$timeout = $t['time'];
}




if($user['prev'] == 0){ mysql_query("INSERT INTO `wiki_tema` SET `name` = '".$name."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #d6d6d6'"); }
elseif($user['prev'] == 1){ mysql_query("INSERT INTO `wiki_tema` SET `name` = '".$name."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #d6d6d6'"); }
elseif($user['prev'] == 2){ mysql_query("INSERT INTO `wiki_tema` SET `name` = '".$name."',`text` = '".$text."',`status` = '0',`us` = '".$user['id']."',`prefix` = '".$prefix."',`prefix2` = '".$prefix2."',`time` = '".time()."',`up` = '".time()."',`usup` = '".$user['id']."',`color` = 'color: #ffff66'"); }

$sql = mysql_insert_id();
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.03)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("INSERT INTO `forum_post` SET `kat` = '".$id."',`text` = '".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$sql."',`razdel` = '".$forum_r['id']."'");
header('Location: /forum/tema'.$sql.'');
exit();
}

echo '<title>Написать статью</title>';
echo '<div class="menu">';
echo '<form action="" name="message" method="POST"> 
<span class="label">Заголовок</span><br />
<center><input placeholder="О чем ваша статья?" style="margin-left: 15px; margin-right: 15px; border-bottom: 0px;" type="text_nt" name="name" value=""/></center>';
echo '</div>';
echo '<div class="menu" style="border-bottom: 0px; padding-top: 18px;">';
echo '<div class="selections">';
echo '<span class="label">Префикс:</span>';
include '../CGcore/set-prefix.php'; 
echo '<br />';
echo '<span class="label">Префикс 2:</span>';
include '../CGcore/set-prefix-2.php'; 
echo '</div>';
echo '</div>';
echo '<div class="menu" style="border-bottom: 0px;">';
include ('../CGcore/bbcode.php'); 
echo '</div>';

echo '<div class="menu" style="border-bottom: 0px; border-radius: 0 0 10px 10px; padding: 0 10px 10px 10px;">';
echo '<center><textarea style="margin-left: 15px; margin-right: 15px; margin-bottom: 0px; height: 120px;" placeholder="Напишите что нибудь..." name="msg"></textarea></center>';
echo '<table style="margin-top: 13px;">';
echo '<input type="submit" style="margin: 0px; border-bottom: 0px; border-radius: 7px; display: inline-block; width: 150px; float: right; margin: 15px 15px 7px 15px;" name="submit" value="Создать тему" />';
echo '</table></form>';
echo '</div>';

include ('footers.php');

break;
##############################
####### Новая категория ######
##############################
case 'nk':

$id = abs(intval($_GET['id']));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$id."'"));

if($forum_r == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такого раздела не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 3) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>У вас не достаточно прав для просмотра данной страницы!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | Новый подраздел</div>';

/* Если нажали кнопку */
if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);

if(mb_strlen($name,'UTF-8') < 3) $err = 'Минимум для ввода 3 символа!';
if(empty($name)) $err = 'Введите название подраздела!';

if($err) {
echo err($err);
include ('../CGcore/footer.php'); exit;
}

mysql_query("INSERT INTO `forum_kat` SET `razdel` = '".$id."',`name` = '".$name."'");
echo '<div class="menu"><center><b>Подраздел успешно создан!</b></center></div>';
}

echo '<div class="menu"><form action="" method="POST"> 
<input type="text" placeholder="Название" name="name" value=""/><br />
<input type="submit" name="submit" value="Создать" />
</form></div>

<a class="link" a href="'.$HOME.'/forum/razdel'.$forum_r['id'].'">Назад в раздел</a>';

break;
##############################
######### Вывод темы #########
##############################

case 'tema':

$id = abs(intval($_GET['id']));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_t['razdel']."'"));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_t['kat']."'"));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix` WHERE `id` = '".$forum_t['prefix']."'"));
$forum_p2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix2` WHERE `id` = '".$forum_t['prefix2']."'"));
$forum_zaklad = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_zaklad` WHERE `tema` = '".$id."' and `us` = '".$user['id']."' "));

if($forum_t == 0) {
echo '<div class="menu">Форум | Ошибка</div><div class="menu"><center><b>Такой темы не существует!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

echo '<style>
.content {
	padding: 0px;
	background: none;
	margin: 0px;
}
@media all and (min-width: 800px){
	#sidebar {
		display: none;
	}
	.back_but_link {
		display: inline-block;
	}
 .content {
 margin: 0px;
 padding: 0px;
 background: none;
}
</style>';

echo '<title>'.$forum_t['name'].' - '.$index['pod-title'].'</title>';
echo '<meta property="description" content="'.$forum_t['text'].'">';

echo '<div class="them_title">';
echo '<span class="prefix_them">';


if(empty($forum_t['prefix'])) {
if($forum_t['prefix'] == $forum_p['id']){ echo '<span class="prefix_for" style="display: none;"><div class="prefix_t" style="'.$forum_p['style'].'"><b>'.$forum_p['name'].'</b></div></span>'; }
} else {
if($forum_t['prefix'] == $forum_p['id']){ echo '<span class="prefix_for" style="display: inline-block;"><div class="prefix_t" style="'.$forum_p['style'].'"><b>'.$forum_p['name'].'</b></div></span>'; }
}

if(empty($forum_t['prefix2'])) {
if($forum_t['prefix2'] == $forum_p2['id']){ echo '<span class="prefix_for" style="display: none;"><div class="prefix_t" style="'.$forum_p2['style'].'"><b>'.$forum_p2['name'].'</b></div></span>'; }
} else {
if($forum_t['prefix2'] == $forum_p2['id']){ echo '<span class="prefix_for" style="display: inline-block;"><div class="prefix_t" style="'.$forum_p2['style'].'"><b>'.$forum_p2['name'].'</b></div></span>'; }
}


echo '</span>';
echo '<div class="name_teme_tree"><h1 style="display: inline;">'.$forum_t['name'].'</h1></div><br />';



echo '<div class="dod_block"><span class="dodname_forum" style="color: #999; display: inline-block;">Тема в разделе <a class="kat_t_name" href="/forum/kat'.$forum_t['kat'].'" style="color: #fc3e27;">'.$forum_k['name'].'</a> создана <a class="r_name" style="color: #fc3e27;">'.vremja($forum_t['time']).'</a><a class="r_name" style="color: #999;"> пользователем '.nick($forum_t['us']).'</a><span class="info-separator"></span><a class="up_name" style="color: #999;">поднята </a><a class="up_name" style="color: #fc3e27;">'.vremja($forum_t['up']).'</a></span></div>';



echo '</div>';

if($forum_t['status'] == 1) {
echo '<center><div class="t_lock"> <i class="fas fa-lock" style="padding-right: 5px; color: #abb15b"></i> Тема закрыта для обсуждений</div></center>';
}

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['msg']);

if(empty($text)) {
echo '<div class="err">Введите текст сообщения</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 3) {
echo '<div class="err">Минимум для ввода 3 символа</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) { 
echo '<div class="err">Авторизуйтесь чтобы ответить</div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `forum_post` WHERE `us` = '".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `forum_post` "));
$timeout = $t['time'];
if((time()-$timeout) < $forum_antispam['forum_post']) {
echo '<div class="err">Пишите не чаще чем раз в '.$forum_antispam['forum_post'].' секунд</div>';
include ('../CGcore/footer.php');
exit();
}
}





if(!isset($forum_t['usup'])) {
mysql_query("UPDATE `forum_tema` SET `usup` = '".$forum_t['us']."' WHERE `id` = '".$id."'");
}


mysql_query("UPDATE `forum_tema` SET `up` = '".time()."' WHERE `id` = '".$id."'");
mysql_query("UPDATE `forum_tema` SET `usup` = '".$user['id']."' WHERE `id` = '".$id."'");










mysql_query("INSERT INTO `forum_post` SET `kat` = '".$forum_k['id']."',`text` = '".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$id."',`razdel` = '".$forum_r['id']."'");
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));
mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.01)."' WHERE `id` = '$user[id]' LIMIT 1");
##оповещание
if($user['id'] != $forum_t['us']) {
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$forum_t['us']."', `kto` = '".$user['id']."', `text` = 'написал в вашей [url=".$HOME."/forum/tema".$id."?selection=top]теме[/url]'");
}
header('Location: /forum/tema'.$id.'?selection=top');
exit();
}

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `tema` = '".$id."' and `kat` = '".$forum_t['kat']."' and `razdel` = '".$forum_t['razdel']."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$k_post = $start+1;
$post = mysql_query("SELECT * FROM `forum_post` WHERE  `tema`='".$id."' ORDER BY `id` LIMIT $start,$max");


echo '<div class="head_bar_menu_pages">';

$gde = '/forum/tema'.$id.'';
if ($k_page>1) { echo str(''.$HOME.'/forum/tema'.$id.'?',$k_page,$page);} else { echo '<style>.head_bar_menu_pages { display: none; }</style>'; } // Вывод страниц

echo '</div>';

echo '<div class="head_bar_menu" style="padding: 15px; border-radius: 10px 10px 0 0;">';
?><a style="float:right; margin-top: -5px;" href="#drop_menu_forum" onclick="$('.open_m').toggle();return false;"><span class="ficon" style="margin-right: 5px;"><i class="fas fa-ellipsis-h" style="padding-left: 5px; padding-right: 0px; font-size: 20px;"></i></span></a><?
echo '</div>';

?>
<style>
.open_m {
  display: none;
}
.open_m {
  display: none;
}
</style>
<?

echo '<div class="open_m" style="float:right; margin-right: -65px; width: 166px; margin-top: -20px;">';
echo '<div class="drop_menu" id="dropdown-content">';

if($forum_zaklad == 0) {
echo '<a class="link" href="/forum/zaklad'.$id.'"><span class="fontawesome_in_menu"><i class="far fa-star"></i><span class="text_in_menu">В закладки</span></span></a>';
} else {
echo '<a class="link" href="/forum/zaklad'.$id.'"><span class="fontawesome_in_menu"><i class="fas fa-star"></i><span class="text_in_menu">Из закладок</span></span></a>';
}

if( $forum_t['status'] == 0 or $forum_t['status'] == 2 ) {
if($user['id'] == $forum_t['us']) {
echo '<a class="link" href="/forum/tema_close'.$id.'"><span class="fontawesome_in_menu"><i class="fas fa-lock"></i><span class="text_in_menu">Закрыть</span></span></a>';
} 
}
elseif ($forum_t['status'] == 1){
if($user['id'] == $forum_t['us']) {
echo '<a class="link" href="/forum/tema_close'.$id.'"><span class="fontawesome_in_menu"><i class="fas fa-unlock-alt"></i><span class="text_in_menu">Открыть</span></span></a>';
}
}

if($user['level'] >= 1) echo '<a class="link" href="/forum/index.php?act=move&id='.$id.'"><span class="fontawesome_in_menu"><i class="fas fa-arrow-up-from-bracket"></i><span class="text_in_menu">Переместить</span></span></a>';


if($forum_t['status'] >= 2) {
echo '<a class="link" href="/forum/tema_top'.$id.'"><span class="fontawesome_in_menu"><i class="fa-solid fa-arrow-up"></i><span class="text_in_menu">Поднять</span></span></a>';
} else {
echo '</span></span>';
}

if($user['level'] >= 1) echo '<a class="link" href="#delete_them" style="color: #ea4c3e;"><span class="fontawesome_in_menu"><i class="fas fa-trash"></i><span class="text_in_menu">Удалить</span></span></a>';
	
echo '<div id="delete_them" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Удаление темы</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Вы действительно хотите удалить тему '.$forum_t['name'].'?</div>
		<br />
	 <br />
  <br />
		<center><a class="submit" href="/forum/tema_del'.$id.'" style="margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;">Да</a></center>
	   <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';
	
echo '</div>';
echo '</div>';

echo '<div class="tema_vis" style="padding: 10px 10px 0 10px;" style="padding: 5px; background-color: #272727; border-radius: 0px 0px 10px 10px;">';

while($a = mysql_fetch_assoc($post)){
	
echo '<div class="cnt">';

echo '<table class="menu_t" cellspacing="0" cellpadding="0"">';

echo '<td class="block_avatar" style="margin: 0px;">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['us']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');


echo '<span class="prefix_rank">';
if($ank['level'] == 0){  echo '<font color="ffffff"></font>';}
elseif($ank['level'] == 1){  echo '<center><span class="adm-frefix_full" data-hint="Модератор"><font color="ffffff" style="background-color: #658e5b; padding: 2px 5px; border-radius: 100px; font-size: 11px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -10px;"<i class="fas fa-screwdriver-wrench"></i></font></span></center>';}
elseif($ank['level'] == 2){ echo '<center><span class="adm-frefix_full" data-hint="Администратор"><font color="ffffff" style="background-color: #517e94; padding: 2px 5px; border-radius: 100px; font-size: 11px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -10px;"><i class="fas fa-screwdriver-wrench"></i></font></span></center>';}
elseif($ank['level'] == 3){ echo '<center><span class="adm-frefix_full" data-hint="Директор"><font color="ffffff" style="background-color: #e06b6b; padding: 2px 5px; border-radius: 100px; font-size: 11px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -10px;"><i class="fas fa-screwdriver-wrench"></i></font><background></span></center>';}

if($ank['level'] == 0){  echo '<font color="ffffff"></font>';}
elseif($ank['level'] == 1){  echo '<center><span class="adm-frefix_min" data-hint="Модератор"><font color="ffffff" style="background-color: #658e5b; padding: 2px 4px; border-radius: 100px; font-size: 10px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -8px;"<i class="fas fa-screwdriver-wrench"></i></font></span></center>';}
elseif($ank['level'] == 2){ echo '<center><span class="adm-frefix_min" data-hint="Администратор"><font color="ffffff" style="background-color: #517e94; padding: 2px 4px; border-radius: 100px; font-size: 10px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -8px;"><i class="fas fa-screwdriver-wrench"></i></font></span></center>';}
elseif($ank['level'] == 3){ echo '<center><span class="adm-frefix_min" data-hint="Директор"><font color="ffffff" style="background-color: #e06b6b; padding: 2px 4px; border-radius: 100px; font-size: 10px; margin-right: 12px; display: inline-block; position: relative; border: 3px solid #222; top: -8px;"><i class="fas fa-screwdriver-wrench"></i></font><background></span></center>';}
echo '</span>';


echo '</td>';
echo '<td class="block_content" style="margin: 0px;">';
echo '<b>'.nick($a['us']).' </b>';

if($a['us'] == $forum_t['us']) {
echo '<span class="autor">Автор темы</span>';
}

echo '<div class="vremja_post">'.vremja($a['time']).'</div><br />';

if(!$a['citata'] == NULL) echo '<div class="cit">'.nick($a['citata_us']).': '.nl2br(smile(bb($a['citata']))).'</div>';

echo '<div class="block_msg">'.nl2br(smile(bb($a['text']))).'</div>';

if($a['us'] == $forum_t['us'] & mb_strlen($a['text']) > 550){
if(!isset($user['id'])) {
echo '<div class="thankAuthorBox">
<div class="thankAuthorTitle">Это сообщение оказалось полезным?</div>
<div class="thankAuthorDiscrip">Вы можете отблагодарить автора темы путем перевода средств на баланс</div>
<a class="btnThanksAuthor mn-15-0-0 OverlayTrigger" href="'.$HOME.'/autch/login.php">Авторизация</a>
</div>';
} else {
echo '<div class="thankAuthorBox">
<div class="thankAuthorTitle">Это сообщение оказалось полезным?</div>
<div class="thankAuthorDiscrip">Вы можете отблагодарить автора темы путем перевода средств на баланс</div>
<a class="btnThanksAuthor mn-15-0-0 OverlayTrigger" href="'.$HOME.'/user/perevod.php?id='.$ank['id'].'">
<span class="icon leftIcon thankAuthorButtonIcon"><i class="fas fa-usd" style="color: #d6d6d6;"></i></span>Отблагодарить автора</a>
</div>';
}
}

echo '<span class="action_teme_us">';
if($user['id'] != $a['us']) echo ' <a href="/forum/post_otvet'.$a['id'].'" title="Ответить"><span class="ficon"><i class="fas fa-reply"></i></span></a> ';
if($user['id'] != $a['us']) echo ' <a href="/forum/post_citata'.$a['id'].'" title="Ответить, цитируя это сообщение"><span class="ficon"><i class="far fa-comment-alt"></i></span></a> ';
if($user['id'] == $a['us'] or $user['level'] >= 1) echo '<a href="/forum/post_red'.$a['id'].'" title="Редактировать сообщение"><span class="ficon"><i class="fas fa-edit"></i></span></a>';
if($user['level'] >= 2) echo ' <a href="/forum/post_del'.$a['id'].'" title="Удалить сообщение"><span class="ficon"><i class="fas fa-trash"></i></span></a> ';
echo '</span>';

$count = mysql_result(mysql_query("SELECT COUNT(`id`) FROM `forum_file` WHERE `post_id` = '".$a['id']."'"),0);
if($count) {
$load_s = mysql_query("SELECT * FROM `forum_file` WHERE `post_id`='".$a['id']."'");
while($a = mysql_fetch_array($load_s)){
echo '</br></br><div class="block_msg"><a style="padding-bottom: 10px; padding-top: 10px; padding-left: 10px; padding-right: 10px; border-radius: 7px;" href="../files/forum/'.$a['name_file'].'"><span class="icon"><i class="fas fa-file"></i></span> '.$a['name_file'].'</a> <span class="time">'.fsize('../files/forum/'.$a['name_file']).'</span></div>';

}
}

echo '</td>';
echo '</table>';
echo '</div>';

}

if($forum_t['status'] == 1) {
echo '<span class="c_lock">Тема закрыта для обсуждений</span>';
}

if($forum_t['status'] != 1) {

echo '<span class="no_reg">Рекомендуем вам зарегистрироваться или войти под своим именем чтобы начать обсуждение</span>';

echo '<div class="menu_tad">';
include ('../CGcore/bbcode.php');  
echo '<form action="" name="message" method="POST" onsubmit="return getContent()" style="display: flex;"> ';

include '../CGcore/textarea.php';

echo '</form></div>';
}


echo '</div>';
//-----------------------------------------------------------------------------------------------------------------------------------------//

echo '<div class="head_bar_menu_pages" style="margin-top: 15px;">';

$gde = '/forum/tema'.$id.'';
if ($k_page>1) { echo str(''.$HOME.'/forum/tema'.$id.'?',$k_page,$page);} else { echo '<style>.head_bar_menu_pages { display: none; }</style>'; } // Вывод страниц

echo '</div>';

echo '<div class="kto_tut">';
echo '<span class="title_kt"><b>Кто в теме:</b></span><br />';
$id = abs(intval($_GET['id']));
$tema = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$gde = '/forum/tema'.$tema['id'].'';
$who = mysql_query('SELECT * FROM `users` WHERE `gde` LIKE "%'.$gde.'%" and `viz` > "'.(time()-60).'" ORDER BY `viz` DESC');
while($w = mysql_fetch_assoc($who))
{
echo '<span class="user_gde">'.nick($w['id']).'</span>';
}
echo '</div>';



break;
case 'zaklad':

$id = abs(intval($_GET['id']));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$forum_zaklad = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_zaklad` WHERE `tema` = '".$id."' and `us` = '".$user['id']."' "));

if($forum_t == 0) {
echo '<div class="menu">Форум</div><div class="err">Такой темы не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) {
echo '<div class="err">Авторизуйтесь чтобы добавить в закладки</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_zaklad == 0) {
mysql_query("INSERT INTO `forum_zaklad` SET `tema` = '".$id."',`us` = '".$user['id']."' ");
header('Location: '.$HOME.'/forum/tema'.$id.'?selection=top');
exit();
} else {
mysql_query("DELETE FROM `forum_zaklad` where `id` = '".$forum_zaklad['id']."'");
header('Location: '.$HOME.'/forum/tema'.$id.'?selection=top');
exit();
}


break;

case 'tema_top':

$id = abs(intval($_GET['id']));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_t['razdel']."'"));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_t['kat']."'"));

if($user['level'] < 2) {
echo '<div class="menu">Форум</div><div class="err">У вас не достаточно прав для просмотра данной страницы</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t == 0) {
echo '<div class="menu">Форум</div><div class="err">Такой темы не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t['status'] == 0) {
mysql_query("UPDATE `forum_tema` SET `status` = '2', `up` = '".time()."' WHERE `id` = '".$id."'");
header('Location: /forum/tema'.$id.'?selection=top');
exit();
} else {
mysql_query("UPDATE `forum_tema` SET `status` = '0', `up` = '".time()."' WHERE `id` = '".$id."'");
header('Location: /forum/tema'.$id.'?selection=top');
exit();
}


break;

case 'tema_close':

$id = abs(intval($_GET['id']));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_t['razdel']."'"));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_t['kat']."'"));

if($user['id'] != $forum_t['us']) {
echo '<div class="menu">Форум</div><div class="err">У вас не достаточно прав для просмотра данной страницы</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t == 0) {
echo '<div class="menu">Форум</div><div class="err">Такой темы не существует</div>';
include ('../CGcore/footer.php');
exit();
}


if($forum_t['status'] == 1) {
mysql_query("UPDATE `forum_tema` SET `status` = '0', `up` = '".time()."' WHERE `id` = '".$id."'");
header('Location: /forum/tema'.$id.'?selection=top');
exit();
}


if(isset($_REQUEST['submit'])) {
mysql_query("UPDATE `forum_tema` SET `status` = '1', `up` = '".time()."' WHERE `id` = '".$id."'");
header('Location: /forum/tema'.$id.'?selection=top');
exit();
}

echo '<div class="menu">Форум | Закрытие темы: '.$forum_t['name'].'</div><div class="menu"><center><b>Закрыть тему?</b></center></div>';
 
echo '<div class="menu"><form action="" name="message" method="POST"> ';
if($user['bb_panel'] == 1) {
include ('../CGcore/bbcode.php');  
}
echo '<input type="submit" name="submit" value="Закрыть" />
</form></div>';

break;
case 'tema_del':

echo '<meta name="robots" content="noindex">';

$id = abs(intval($_GET['id']));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_t['razdel']."'"));
$forum_k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_t['kat']."'"));

if($forum_t == 0) {
echo '<div class="menu">Форум</div><div class="err">Такой темы не существует</div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("DELETE FROM `forum_tema` where `id` = '".$id."'");
mysql_query("DELETE FROM `forum_post` where `tema` = '".$id."'");
header('Location: '.$HOME.'/forum/kat'.$forum_k['id'].'');
exit();

break;
case 'post_del':

$id = abs(intval($_GET['id']));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$forum_p['tema']."'"));

if($forum_t['status'] == 1) {
echo '<div class="menu">Форум</div><div class="err">Тема закрыта или ее не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($user['level'] < 2) {
echo '<div class="menu">Форум</div><div class="err">У вас не достаточно прав для просмотра данной страницы</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_p == 0) {
echo '<div class="menu">Форум</div><div class="err">Такого поста не существует</div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("DELETE FROM `forum_post` where `id` = '".$id."'");
header('Location: '.$HOME.'/forum/tema'.$forum_p['tema'].'?selection=top');
exit();

break;
case 'post_otvet':

echo '<meta name="robots" content="noindex">';

$id = abs(intval($_GET['id']));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$forum_p['tema']."'"));
$us = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$forum_p['us']."'"));

if($forum_p == 0) {
echo '<div class="menu">Форум</div><div class="err">Такого поста не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t['status'] == 1) {
echo '<div class="menu">Форум</div><div class="err">Тема закрыта</div>';
include ('../CGcore/footer.php');
exit();
}

if($user['id'] == $forum_p['us']) {
echo '<div class="menu">Форум</div><div class="err">Самому себе отвечать нельзя</div>';
include ('../CGcore/footer.php');
exit();
}

echo '<style>
.content {
	padding: 0px 10px 0px 10px;
}
</style>';

echo '<div class="menu"><a href="'.$HOME.'/forum/tema'.$forum_t['id'].'">'.$forum_t['name'].'</a></div>';

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['msg']);

if(empty($text)) {
echo '<div class="err">Введите текст сообщения</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 3) {
echo '<div class="err">Минимум для ввода 3 символа</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) { 
echo '<div class="err">Авторизуйтесь чтобы ответить</div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `forum_post` WHERE `us`='".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `forum_post` "));
$timeout = $t['time'];
if((time()-$timeout) < $forum_antispam['forum_post']) {
echo '<div class="err">Пишите не чаще чем раз в '.$forum_antispam['forum_post'].' секунд!</div>';
include ('../CGcore/footer.php');
exit();
}
}

if($user['form_file'] == 1) {
$maxsize = 25; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

if(@file_exists($_FILES['filename']['tmp_name'])) {
    
if($size > (1048576 * $maxsize)) {
echo err($title, 'Максимальный размер файла '.$maxsize.'мб!');
include ('../CGcore/footer.php'); exit;
}

$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', 'mp4','mp3','amr','3gp','avi','flv', 'jar', 'jad', 'apk', 'sis', 'sisx', 'ipa' ); 
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 

if(!in_array($upfiletype,$filetype)) {
echo err($title, 'Такой формат запрещено загружать!');
include ('../CGcore/footer.php'); exit;
}

$files = $_SERVER['HTTP_HOST'].'_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 
move_uploaded_file($_FILES['filename']['tmp_name'], "../files/forum/".$files.""); 
mysql_query("INSERT INTO `forum_file` SET `post_id` = '0', `name_file` = '".$files."'");
$f_id = mysql_insert_id();
}
}


mysql_query("UPDATE `users` SET `money` = '".($user['money']+5)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("INSERT INTO `forum_post` SET `kat` = '".$forum_t['kat']."',`text` = '[b]".$us['login'].",[/b] ".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$forum_t['id']."',`razdel` = '".$forum_t['razdel']."'");
if($user['form_file'] == 1) {
$p_id = mysql_insert_id();
mysql_query("UPDATE `forum_file` SET `post_id` = '".$p_id."' WHERE `id` = '".$f_id."' LIMIT 1");
}
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));
mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.01)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("UPDATE `forum_tema` SET `up` = '".time()."' WHERE `id` = '".$forum_t['id']."'");
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$forum_p['us']."', `kto` = '".$user['id']."', `text` = 'ответил на ваш пост[url=".$HOME."/forum/tema".$forum_t['id']."?selection=top] в теме[/url]'");
header('Location: /forum/tema'.$forum_t['id'].'?selection=top');
exit();
}

echo '<div class="menu" style="border-bottom: 0px;">Ответ для: '.nick($forum_p['us']).'</div>';

echo '<form action="" name="message" method="POST" enctype="multipart/form-data">';
if($user['form_file'] == 1) {
echo '<div class="menu">';
echo '<input type="file" name="filename"/></div>';
} 

echo '<div class="no_reg">Рекомендуем вам зарегистрироваться или войти под своим именем чтобы начать обсуждение</div>';

echo '<div class="menu_tad" style="display: flex;">';
include ('../CGcore/bbcode.php'); 
echo '<form action="" name="message" method="POST" onsubmit="return getContent()"> ';

include '../CGcore/textarea.php';

echo '</form></div>';


break;
case 'post_red':

$id = abs(intval($_GET['id']));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$forum_p['tema']."'"));
$count = mysql_result(mysql_query("SELECT COUNT(`id`) FROM `forum_file` WHERE `post_id` = '".$id."'"),0);

if($forum_p == 0) {
echo '<div class="menu">Форум</div><div class="err">Такого поста не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($user['id'] != $forum_p['us'] && $user['level'] < 2) {
echo '<div class="menu">Форум</div><div class="err">У вас не достаточно прав для просмотра данной страницы</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t['status'] == 1) {
echo '<div class="menu">Форум</div><div class="err">Тема закрыта</div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/tema'.$forum_t['id'].'">Тема '.$forum_t['name'].'</a> | Редактирование поста</div>';

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['msg']);

if(mb_strlen($text,'UTF-8') < 3) $err = 'Минимум для ввода 3 символа!';
if(empty($text)) $err = 'Введите текст сообщения!';

if($err) {
echo '<div class="err">'.$err.'</div>';
include ('../CGcore/footer.php');
exit();
}

mysql_query("UPDATE `forum_post` SET `text` = '".$text."' WHERE `id` = '".$id."'");
header('Location: /forum/tema'.$forum_t['id'].'?selection=top');
exit();
}

echo '<div class="menu">Пост пользователя: '.nick($forum_p['us']).'</div>
<div class="menu" style="border-bottom: 0px;">
<form action="" name="message" method="POST"> ';
echo '<center><textarea style="height:200px;" name="msg">'.$forum_p['text'].'</textarea></center><br />
<center><input type="submit" name="submit" value="Изменить" style="width: 175px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form>
</div>';

if($user['form_file'] == 1) {
    
if(isset($_POST['sfile'])){
    
if($count >= 5) {
echo '<div class="title"><a href="'.$HOME.'/down">Загрузки</a> | Ошибка</div><div class="menu"><center><b><big>Максимум можно прикреплять 5 файлов!</big></b></center></div>';
include ('../CGcore/footer.php');
exit();
}

$maxsize = 25; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла
if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo err($title, 'Вы не выбрали файл!');
include ('../CGcore/footer.php'); exit;
}

if($size > (1048576 * $maxsize)) {
echo err($title, 'Максимальный размер файла '.$maxsize.'мб!');
include ('../CGcore/footer.php'); exit;
}

$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', 'mp4','mp3','amr','3gp','avi','flv', 'jar', 'jad', 'apk', 'sis', 'sisx', 'ipa' ); 
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 

if(!in_array($upfiletype,$filetype)) {
echo err($title, 'Такой формат запрещено загружать!');
include ('../CGcore/footer.php'); exit;
}


$files = $_SERVER['HTTP_HOST'].'_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 
move_uploaded_file($_FILES['filename']['tmp_name'], "../files/forum/".$files.""); 
mysql_query("INSERT INTO `forum_file` SET `post_id` = '".$id."', `name_file` = '".$files."'");

header('Location: '.$HOME.'/forum/post_red'.$id.''); exit;
}

echo '<div class="menu"><form action="/forum/post_red'.$id.'" method="post" enctype="multipart/form-data">
Выберите файл:<br><input type="file" name="filename"/><br />
<input type="submit" value="Загрузить" name="sfile"/>
</form></div>';
}
echo '<div class="title">Файлы ['.$count.']</div>';

if($count < 1) { 
    
echo '<div class="menu">Файлов нет</div>';

} else {
    
$ff = mysql_query("SELECT * FROM `forum_file` WHERE `post_id`='".$id."'");

while($a = mysql_fetch_array($ff)){
echo '<div class="menu">
<a href="'.$HOME.'/files/forum/'.$a['name_file'].'">'.$a['name_file'].'</a> | 
<a href="/forum/delfile'.$id.'/'.$a['id'].'">Удалить</a></div>';
}
}
break;

case 'delfile':
$id = abs(intval($_GET['id']));
$id_file = abs(intval($_GET['id_file']));

$f_post = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));

if(!isset($f_post['id'])) {
echo err($title, 'Нет такого файла');
include ('../CGcore/footer.php'); exit;
}

if($user['id'] != $f_post['us'] && $user['level'] != 3){
echo err($title, 'Нет доступа!');
include ('../CGcore/footer.php'); exit;
}

$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$f_post['tema']."'"));
echo '<div class="title"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/tema'.$forum_t['id'].'">'.$forum_t['name'].'</a> | Пост №'.$id.'| Удаление файла</div>';

$fil = mysql_fetch_array(mysql_query("SELECT * FROM `forum_file` WHERE `id`='".$id_file."'"));

if(isset($_REQUEST['da'])) { 

unlink('../files/forum/'.$fil['name_file']);

mysql_query("DELETE FROM `forum_file` WHERE `id` = '".$id_file."' LIMIT 1");

header('Location: '.$HOME.'/forum/post_red'.$id); exit;

} 
echo '<div class="menu">Вы действительно хотите УДАЛИТЬ файл <a href="'.$HOME.'/files/forum/'.$fil['name_file'].'">'.$fil['name_file'].'</a> ? <br /><br /><a href="'.$HOME.'/forum/delfile'.$id.'/'.$id_file.'?da"><b>Да</b></a> | <a href="'.htmlspecialchars(getenv("HTTP_REFERER")).'">Отмена</a></div>';

break; ##END

##############################
############ Цитаты ##########
##############################
case 'post_citata':

echo '<meta name="robots" content="noindex">';

$id = abs(intval($_GET['id']));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$forum_p['tema']."'"));
$us = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$forum_p['us']."'"));

if($forum_p == 0) {
echo '<div class="menu">Форум</div><div class="err">Такого поста не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t['status'] == 1) {
echo '<div class="menu">Форум</div><div class="err">Тема закрыта</div>';
include ('../CGcore/footer.php');
exit();
}

if($user['id'] == $forum_p['us']) {
echo '<div class="menu">Форум</div><div class="err">Цитировать самого себя нельзя</div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/tema'.$forum_t['id'].'">Тема '.$forum_t['name'].'</a> </div>';

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['msg']);

if(empty($text)) {
echo '<div class="err">Введите текст сообщения</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 3) {
echo '<div class="err">Минимум для ввода 3 символа</div>';
include ('../CGcore/footer.php');
exit();
}

if(!isset($user['id'])) { 
echo '<div class="err">Авторизуйтесь чтобы ответить</div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `forum_post` WHERE `us`='".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `forum_post` "));
$timeout = $t['time'];
if((time()-$timeout) < $forum_antispam['forum_post']) {
echo '<div class="err">Пишите не чаще чем раз в '.$forum_antispam['forum_post'].' секунд</div>';
include ('../CGcore/footer.php');
exit();
}
}

if($user['form_file'] == 1) {
$maxsize = 2048; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

if(@file_exists($_FILES['filename']['tmp_name'])) {
    
if($size > (1048576 * $maxsize)) {
echo err($title, 'Максимальный размер файла '.$maxsize.'мб!');
include ('../CGcore/footer.php'); exit;
}

$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', 'mp4','mp3','amr','3gp','avi','flv', 'jar', 'jad', 'apk', 'sis', 'sisx', 'ipa' ); 
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 

if(!in_array($upfiletype,$filetype)) {
echo err($title, 'Такой формат запрещено загружать!');
include ('../CGcore/footer.php'); exit;
}

$files = $_SERVER['HTTP_HOST'].'_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 
move_uploaded_file($_FILES['filename']['tmp_name'], "../files/forum/".$files.""); 
mysql_query("INSERT INTO `forum_file` SET `post_id` = '0', `name_file` = '".$files."'");
$f_id = mysql_insert_id();
}
}

mysql_query("INSERT INTO `forum_post` SET `citata` = '".$forum_p['text']."...',`citata_us` = '".$forum_p['us']."',`kat` = '".$forum_t['kat']."',`text` = '".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$forum_t['id']."',`razdel` = '".$forum_t['razdel']."'");
if($user['form_file'] == 1) {
$p_id = mysql_insert_id();
mysql_query("UPDATE `forum_file` SET `post_id` = '".$p_id."' WHERE `id` = '".$f_id."' LIMIT 1");
}
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));
mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.01)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("UPDATE `forum_tema` SET `up` = '".time()."' WHERE `id` = '".$forum_t['id']."'");
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$us['id']."', `kto` = '".$user['id']."', `text` = 'Процитировал ваш пост[url=".$HOME."/forum/tema".$forum_t['id']."?selection=top] в теме[/url]'");
header('Location: /forum/tema'.$forum_t['id'].'?selection=top');
exit();
}

echo '<div class="menu">
<div class="cit">
'.nick($us['id']).': '.nl2br(smile(bb($forum_p['text']))).'
</div></div>';

echo '<form action="" name="message" method="POST" enctype="multipart/form-data">';
if($user['form_file'] == 1) {

}

echo '<span class="no_reg">Рекомендуем вам зарегистрироваться или войти под своим именем чтобы начать обсуждение</span><br />';

echo '<div class="menu_tad" style="display: flex;">';
include ('../CGcore/bbcode.php');  
echo '<form action="" name="message" method="POST" onsubmit="return getContent()"> ';

include '../CGcore/textarea.php';

echo '</form></div>';

break;
##############################
########## Спойлеры ##########
##############################
case 'post_spoiler':

$id = abs(intval($_GET['id']));
$forum_p = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_post` WHERE `id` = '".$id."'"));
$forum_t = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$forum_p['tema']."'"));
$us = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$forum_p['us']."'"));

if($forum_p == 0) {
echo '<div class="menu">Форум</div><div class="err">Такого поста не существует</div>';
include ('../CGcore/footer.php');
exit();
}

if($forum_t['status'] == 1) {
echo '<div class="menu">Форум</div><div class="err">Тема закрыта</div>';
include ('../CGcore/footer.php');
exit();
}

if($user['id'] == $forum_p['us']) {
echo '<div class="menu">Форум</div><div class="err">Цитировать самого себя нельзя</div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">'.$title.'</a> | <a href="'.$HOME.'/forum/tema'.$forum_t['id'].'">Тема '.$forum_t['name'].'</a> </div>';

if(isset($_REQUEST['submit'])) {

$text = strong($_POST['msg']);

if(empty($text)) {
echo '<div class="err">Введите текст сообщения</div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($text,'UTF-8') < 3) {
echo '<div class="err">Минимум для ввода 3 символа</div>';
include ('../CGcore/footer.php');
exit();
}

$time = mysql_query("SELECT * FROM `forum_post` WHERE `us`='".$user['id']."' ORDER BY `time` DESC");
while($t = mysql_fetch_assoc($time)){  
$forum_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `forum_post` "));
$timeout = $t['time'];
if((time()-$timeout) < $forum_antispam['forum_post']) {
echo '<div class="err">Пишите не чаще чем раз в '.$forum_antispam['forum_post'].' секунд</div>';
include ('../CGcore/footer.php');
exit();
}
}

if($user['form_file'] == 1) {
$maxsize = 2048; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

if(@file_exists($_FILES['filename']['tmp_name'])) {
    
if($size > (1048576 * $maxsize)) {
echo err($title, 'Максимальный размер файла '.$maxsize.'мб!');
include ('../CGcore/footer.php'); exit;
}

$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', 'mp4', 'mp3', 'amr', '3gp', 'avi', 'flv', 'jar', 'jad', 'apk', 'sis', 'sisx', 'ipa', 'iso', 'exe', '7z' ); 
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 

if(!in_array($upfiletype,$filetype)) {
echo err($title, 'Такой формат запрещено загружать!');
include ('../CGcore/footer.php'); exit;
}

$files = $_SERVER['HTTP_HOST'].'_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 
move_uploaded_file($_FILES['filename']['tmp_name'], "../files/forum/".$files.""); 
mysql_query("INSERT INTO `forum_file` SET `post_id` = '0', `name_file` = '".$files."'");
$f_id = mysql_insert_id();
}
}

mysql_query("INSERT INTO `forum_post` SET `citata` = '".$forum_p['text']."...',`citata_us` = '".$forum_p['us']."',`kat` = '".$forum_t['kat']."',`text` = '".$text."',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$forum_t['id']."',`razdel` = '".$forum_t['razdel']."'");
if($user['form_file'] == 1) {
$p_id = mysql_insert_id();
mysql_query("UPDATE `forum_file` SET `post_id` = '".$p_id."' WHERE `id` = '".$f_id."' LIMIT 1");
}
##добавляем юзеру стронгов и рейтинг
$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));
mysql_query("UPDATE `users` SET `money` = '".($user['money']+$settings['forum_tem_m'])."', `rating` = '".($user['rating']+0.01)."' WHERE `id` = '$user[id]' LIMIT 1");
mysql_query("UPDATE `forum_tema` SET `up` = '".time()."' WHERE `id` = '".$forum_t['id']."'");
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$us['id']."', `kto` = '".$user['id']."', `text` = 'процитировал ваш пост[url=".$HOME."/forum/tema".$forum_t['id']."?selection=top] в теме[/url]'");
header('Location: /forum/tema'.$forum_t['id'].'?selection=top');
exit();
}

echo '<div class="spoiler_body">
<div class="spoiler">
'.$us['login'].': '.nl2br(smile(bb($forum_p['text']))).'
</div></div>';

echo '<form action="" name="message" method="POST" enctype="multipart/form-data">';
if($user['form_file'] == 1) {
echo '<div class="menu">';
echo '<input type="file" name="filename"/>';
echo '</div>';
}

echo '<span class="no_reg">Рекомендуем вам зарегистрироваться или войти под своим именем чтобы начать обсуждение</span><br />';

echo '<div class="menu_tad">';
include ('../CGcore/bbcode.php');  
echo '<textarea placeholder="Введите спойлер..." name="msg"></textarea>
<table>
<td><input type="submit" name="submit" value="Отправить" style="border-radius: 7px 0px 0px 7px; margin-left: 3px;" /></td>';
?><td style="width:10px; display: none"><a style="float:right;" href="#" onclick="$('.teg').toggle();return false;"><i style="background: #c33929; padding: 2px 10px; font-size: 31px; color: #c3c3c3; border-radius: 0px 7px 7px 0px; margin-right:2px;" class="fas fa-angle-up"></i></a></td><?
echo '</table></form></div>';

break;
##############################
####### Кто на форуме ########
##############################
case 'who_forum':

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Кто на форуме</div>';

$gde = '/forum';

$who = mysql_query('SELECT * FROM `users` WHERE `gde` LIKE "%'.$gde.'%" and `viz` > "'.(time()-60).'" ORDER BY `viz` DESC');
while($w = mysql_fetch_assoc($who)){
    
echo '<table class="menu" cellspacing="0" cellpadding="0">';
echo '<td style="width: 75px;">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$w['id']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';
echo ''.nick($w['id']).' <span class="time">'.vremja($w['viz']).'</span></br>';
echo '<div class="block_msg">На форуме</div>';
echo '</td>';
echo '</table>';

}

break;
##############################
######### Кто в теме #########
##############################
case 'who_tema':

$id = abs(intval($_GET['id']));
$tema = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$gde = '/forum/tema'.$tema['id'].'';

if($tema== 0) {
echo '<div class="menu">Форум</div><div class="err">Такой темы не существует</div>';
include ('../CGcore/footer.php');
exit();
}

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Кто в теме</div>';

$who = mysql_query('SELECT * FROM `users` WHERE `gde` LIKE "%'.$gde.'%" and `viz` > "'.(time()-60).'" ORDER BY `viz` DESC');
while($w = mysql_fetch_assoc($who))
{
echo '<div class="menu">'.nick($w['id']).' ('.vremja($w['viz']).')</div>';
}

echo '<div class="links">» <a href="'.$HOME.'/forum/tema'.$tema['id'].'">Назад</a></div>';

break;
##############################
########### Мои темы #########
##############################
case 'my_tem':

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Мои темы</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '".$user['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$tema = mysql_query("SELECT * FROM `forum_tema` WHERE `us` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($tema))
{

if($a['status'] == 0) { $icon = 'tem'; } else { $icon = 'close';}

echo '<div class="menu"><img src="/images/'.$icon.'.png" alt="*"> <a href="/forum/tema'.$a['id'].'">'.$a['name'].'</a> 
('.mysql_result(mysql_query('select count(`id`) from `forum_post` where `tema` = "'.$a['id'].'"'),0).') 
<a href="/forum/tema'.$a['id'].'?selection=top">>></a></div>';
}

if($k_post < 1) echo '<div class="menu">Вы еще не создавали тем</div>';
if ($k_page>1) echo str(''.$HOME.'/forum/myt'.$id.'?',$k_page,$page); // Вывод страниц

break;
case 'my_post':

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Мои посты</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '".$user['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$post = mysql_query("SELECT * FROM `forum_post` WHERE `us` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($post))
{
echo '<div class="links">'.nick($a['us']).' ('.vremja($a['time']).')</div>
<div class="menu">'.nl2br(smile(bb($a['text']))).'
<br />
<a href="/forum/tema'.$a['tema'].'?selection=top" style="background-color: #228e5d;">Перейти в тему</a>
</div>';
}

if($k_post < 1) echo '<div class="menu">Вы еще не оставляли постов</div>';
if ($k_page>1) echo str(''.$HOME.'/forum/myp'.$id.'?',$k_page,$page); // Вывод страниц

break;
case 'new_tem':

echo '<title>Новые темы</title>';

echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Новые темы</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `time` > '".(time()-86400)."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$tem = mysql_query("SELECT * FROM `forum_tema` WHERE `time` > '".(time()-86400)."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($tem))
{
include ('../CGcore/div-link-thems-info.gt');
}

if($k_post < 1) echo '<div class="menu" style="border-bottom: 0px;">За 24 часа новых тем нету</div>';
if ($k_page>1) echo str(''.$HOME.'/forum/newt?',$k_page,$page); // Вывод страниц

break;
case 'new_post':

echo '<style>
.content {
	padding: 0px;
	background: none;
}
.post_block {
	margin-top: 15px;
	border-radius: 10px;
	padding: 0px 10px 0px 10px;
	background: #222;
}
</style>';

echo '<title>Новые посты - '.$index['pod-title'].'</title>';
echo '<meta name="description" content="Новые поты за последние 24 часа">';
echo '<div class="menu" style="border-radius: 10px; border-bottom: 9px;"><a href="'.$HOME.'/forum/">Форум</a> | Новые посты</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `time` > '".(time()-86400)."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$post = mysql_query("SELECT * FROM `forum_post` WHERE `time` > '".(time()-86400)."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($post)){
echo '<div class="post_block">';
echo '<div class="menu">'.nick($a['us']).''.vremja($a['time']).'</div>';
echo '<div class="menu" style="border-bottom: 0px; padding-top: 5px;">'.smile(bb($a['text'])).'<br />
<a href="/forum/tema'.$a['tema'].'?selection=top">Перейти в тему</a></div>';
echo '</div>';
}

if($k_post < 1) echo '<div class="menu">За 24 часа новых постов нету</div>';
if ($k_page>1) echo str(''.$HOME.'/forum/newp'.$id.'?',$k_page,$page); // Вывод страниц

break;

######################
###### Закладки ######
######################

case 'my_zakl':

if(!isset($user['id'])) {
echo err($title, '
Уважаемый посетитель, Вы зашли на сайт как незарегистрированный пользователь.<br/>
Мы рекомендуем Вам зарегистрироваться либо войти на сайт под своим именем.
');
include ('../CGcore/footer.php'); exit;
}

echo '<title>Закладки - '.$index['pod-title'].'</title>';
echo '<meta name="robots" content="noindex">';
echo '<meta name="description" content="Ваши темы в закладках">';
echo '<div class="menu"><a href="'.$HOME.'/forum/">Форум</a> | Мои закладки</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_zaklad` WHERE `us` = '".$user['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$z = mysql_query("SELECT * FROM `forum_zaklad` WHERE `us` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($z))
{

$a = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$a['tema']."'"));

if($a['status'] == 0) { $icon = 'tem'; } else { $icon = 'close';}

echo '<div class="zakl_link_tem">';

include ('../CGcore/div-link-thems-info.gt');

echo '<a href="/forum/tema'.$a['id'].'?selection=top"></a>';
echo '</div>';
}

if($k_post < 1) echo '<div class="menu"><b><center>У вас нет закладок!</center></b></div>';
if($k_page>1) echo str(''.$HOME.'/forum/zakl'.$id.'?',$k_page,$page); // Вывод страниц

break;

##############################
###### Переместить тему ######
##############################

case 'move':
$id = abs(intval($_GET['id']));

if($user['level'] < 1) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));

if($forum_r == 0) {
echo err($title, 'Такой темы не существует!');
include ('../CGcore/footer.php'); exit;
}

$r2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_r['razdel']."'"));
$k2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_r['kat']."'"));

echo '<div class="menu">Перемещение темы: <a href="'.$HOME.'/forum/tema'.$forum_r['id'].'">'.$forum_r['name'].'</a></div>';
echo '<div class="menu">Переместить тему из <b><a href="'.$HOME.'/forum/razdel'.$r2['id'].'">'.$r2['name'].'</a></b> / <b><a href="/'.$HOME.'forum/kat'.$k2['id'].'">'.$k2['name'].'</a></b> в:</div>';

$forum_r = mysql_query("SELECT * FROM `forum_razdel` ORDER BY `id` DESC");

while($a = mysql_fetch_assoc($forum_r)){
echo '<div class="menu"><b> '.$a['name'].'</b></div><div class="menu">';
$forum_k = mysql_query("SELECT * FROM `forum_kat` WHERE `razdel` = '".$a['id']."' ORDER BY `id` DESC");

while($a = mysql_fetch_assoc($forum_k)){
echo '<a href="'.$HOME.'/forum/index.php?act=move_tem&id='.$id.'&kat='.$a['id'].'&razdel='.$a['razdel'].'"> '.$a['name'].'</a><br/>';
}

echo '</div>';

}


break;

case 'move_tem':

$id = abs(intval($_GET['id']));
$razdel = abs(intval($_GET['razdel']));
$kat = abs(intval($_GET['kat']));

if($user['level'] < 1) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

$forum_r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_tema` WHERE `id` = '".$id."'"));
$r = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$razdel."'"));
$k = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$kat."'"));


if($forum_r == 0) {
echo err($title, 'Такой темы не существует!');
include ('../CGcore/footer.php'); exit;
}

if($r == 0) {
echo err($title, 'Такого раздела не существует!');
include ('../CGcore/footer.php'); exit;
}

if($k == 0) {
echo err($title, 'Такая категория не существует!');
include ('../CGcore/footer.php'); exit;
}


$r2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_razdel` WHERE `id` = '".$forum_r['razdel']."'"));
$k2 = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_kat` WHERE `id` = '".$forum_r['kat']."'"));

echo '<div class="menu">Перемещение темы: <a href="'.$HOME.'/forum/tema'.$forum_r['id'].'">'.$forum_r['name'].'</a></div>';

if(isset($_REQUEST['okda'])) { 
/* Делаем запрос */
mysql_query("UPDATE `forum_tema` SET `razdel` = '".$razdel."', `kat` = '".$kat."' WHERE `id` = '".$id."'");

mysql_query("INSERT INTO `forum_post` SET `kat` = '".$kat."',`text` = 'Перенес тему из [b]".$r2['name']."[/b] / [b]".$k2['name']."[/b] в [b]".$r['name']."[/b] / [b]".$k['name']."[/b] :)',`us` = '".$user['id']."',`time` = '".time()."',`tema` = '".$id."',`razdel` = '".$razdel."'");

header('Location: '.$HOME.'/forum/tema'.$id.''); exit; 
} 

echo '<div class="menu">Вы действительно хотите переместить тему 
из <b><a href="'.$HOME.'/forum/razdel'.$r2['id'].'">'.$r2['name'].'</a></b> / <b><a href="/'.$HOME.'forum/kat'.$k2['id'].'">'.$k2['name'].'</a></b> 
в <b><a href="'.$HOME.'/forum/razdel'.$r['id'].'">'.$r['name'].'</a></b> / <b><a href="'.$HOME.'/forum/kat'.$k['id'].'">'.$k['name'].'</a></b> 
<br /><br /><a href="'.$HOME.'/forum/index.php?act=move_tem&id='.$id.'&kat='.$kat.'&razdel='.$razdel.'&okda"><b>Да</b></a> | <a href="'.htmlspecialchars(getenv("HTTP_REFERER")).'">Отмена</a></div>'; 
break;


}

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>