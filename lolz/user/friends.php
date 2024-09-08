<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

$act = isset($_GET['act']) ? strong($_GET['act']) : "";
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : "";
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

switch($act)
{
default:

if($ank == 0) {
header('Location: '.$HOME.'/friends'.$user['id']); exit;
}

if($id == $user['id']) echo '<div class="title">Мои друзья</div>'; 
else echo '<div class="title"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | Друзья</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `friends` WHERE `us_a` = '".$user['id']."' AND `status` = '1'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$q = mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$id."' AND `status` = '1' ORDER BY `time` DESC LIMIT $start,$max");

while($a = mysql_fetch_assoc($q)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['us_b']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo ''.nick($a['us_b']).' <br/>';

if($id == $user['id']) echo '<div class="but_friend"><a href="'.$HOME.'/mes/newmes'.$a['us_b'].'">Написать</a></div><div class="but_friend" style="margin-left: 5px;"><a href="'.$HOME.'/friends/delete'.$a['us_b'].'">Удалить</a></div>';
if($a['us_b'] != $user['id'] && $id != $user['id']) echo '<a href="'.$HOME.'/mes/newmes'.$a['us_b'].'">Написать</a></br><a href="'.$HOME.'/friends/add'.$a['us_b'].'">Добавить</a>';

echo '</td></table>';

}

if($k_post < 1) {
echo '<div class="menu">Друзей пока нет</div>';
}

if ($k_page > 1) {
echo str($HOME.'/friends'.$id, $k_page,$page); // Вывод страниц
}

break;

##Добавляем друга
case 'add':

if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
include ('../CGcore/footer.php'); exit;
}

if ($user['id'] == $ank['id']) {
echo err($title, 'Вы не можете добавить в друзья самого себе!');
include ('../CGcore/footer.php'); exit;  
}

$tim = mysql_query("SELECT * FROM `friends` WHERE `us_b`='".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam`"));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['friends'])
{
echo err($title, 'Добавлять друзей можно не чаще чем раз в '.$news_antispam['friends'].' секунд!');
include ('../CGcore/footer.php'); exit; 
}
}

$bid = mysql_fetch_assoc(mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$id."' AND `status` = '0'"));

if($bid != 0) {
echo err($title, 'Заявка отправлена. Ожидайте!');
echo '<div class="links"><a href="'.$HOME.'/user_'.$id.'">Перейти в анкету</a></div>';
include ('../CGcore/footer.php'); exit;
}

$s = mysql_fetch_assoc(mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$id."' AND `us_b` = '".$user['id']."'"));

if($s['status'] == 1) {
echo err($title, 'Пользователь уже находится у Вас в друзьях!');
include ('../CGcore/footer.php'); exit;
}
echo '<div class="title"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | <a href="'.$HOME.'/friends'.$id.'"> Друзья</a> | Добавить</div>';

if (isset($_GET['da'])){
##Оповещаем юзера
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'хочет добавить Вас в [url=".$HOME."/friends/bid]друзья[/url]'");

mysql_query("INSERT INTO `friends` SET `us_a` = '".$id."', `us_b` = '".$user['id']."', `status` = '0', `time` = '".time()."'");

echo '<div class="menu">Заявка отправлена</div>';
echo '<div class="links"><a href="'.$HOME.'/user_'.$id.'">Перейти в анкету</a></div>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu" style="border-bottom: 0px;">Вы действительно хотите добавить '.$ank['login'].' в друзья ? <br /><br /><div class="but" style="background-color: #228e5d;"><a href="'.$HOME.'/friends/add'.$id.'?da">Да</a></div><div class="but" style="background-color: #228e5d; margin-left: 5px;"><a href="/index.php">Нет</a></div></div>';

break;

##Список заявок
case 'bid':

echo '<div class="title"><a href="'.$HOME.'/friends'.$user['id'].'">Мои друзья</a> | Заявки</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `friends` WHERE `us_a` = '".$user['id']."' AND `status` = '0'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$q = mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$user['id']."' AND `status` = '0' ORDER BY `time` DESC LIMIT $start,$max");
while($as = mysql_fetch_assoc($q)){
    
echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$as['us_b']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo ''.nick($as['us_b']).' <span class="time">'.vremja($as['time']).'</span></br>';
echo '<div class="but_friend"><a href="'.$HOME.'/friends/da'.$as['us_b'].'/'.$as['id'].'">Принять заявку</a></div>';

echo '</td>';
echo '</table>';

}

if($k_post < 1) {
echo '<div class="menu">Заявок нет</div>';
}

if ($k_page > 1) {
echo str($HOME.'/friends/bid',$k_page,$page); // Вывод страниц
}

break;

##Принимаем заявку
case 'da':

$fid = abs(intval($_GET['fid']));
$bid = mysql_fetch_assoc(mysql_query("SELECT * FROM `friends` WHERE `id` = '".$fid."' AND `status` = '0'"));

if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
include ('../CGcore/footer.php'); exit;
}

if($bid == 0) {
echo err($title, 'Такой заявки не существует!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("INSERT INTO `friends` SET `us_a` = '".$ank['id']."', `us_b` = '".$user['id']."', `status` = '1', `time` = '".time()."'");
mysql_query("UPDATE `friends` SET `status` = '1' WHERE `id` = '".$fid."'");
##Оповещаем юзера
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'добавил Вас в [url=".$HOME."/friends/]друзья[/url]'");

header('Location: /friends/bid'); exit;

break;

##Удаляем друга
case 'delete':

if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
include ('../CGcore/footer.php'); exit;
}

$q = mysql_fetch_assoc(mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$id."' AND `us_b` = '".$user['id']."' AND `status` = '1'"));

if($q == 0) {
echo err($title, 'У Вас в друзьях нет такого пользователя!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("DELETE FROM `friends` WHERE `us_a` = '".$id."' AND `us_b` = '".$user['id']."'");

mysql_query("DELETE FROM `friends` WHERE `us_b` = '".$id."' AND `us_a` = '".$user['id']."'");

header('Location: '.$HOME.'/friends'.$user['id']); exit;


break;

}
include ('../CGcore/footer.php');
?>