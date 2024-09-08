<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

$act = isset($_GET['act']) ? $_GET['act'] : null;

switch($act) {

default:

echo '<title>Сообщения</title>';

echo '<div class="title">Сообщения</div>';

echo '<table style="text-align:center;margin-bottom:10px;" cellspacing="0" cellpadding="0">';
echo '<td><a style="border-right:none;" class="link" href="/mes/ignor_list">Игнор лист</a></td>';
echo '<td><a style="border-right:none;" class="link" href="/mes/search/">Поиск</a></td>';
echo '<td><a class="link" href="/mes/save/">Избранные</a></td>';
echo '</table>';

if (empty($user['max'])) $user['max']=10;

$max = $user['max'];

$k_post = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kto` = '".$user['id']."' and `del` = '0'"),0);

$k_page = k_page($k_post,$max);

$page = page($k_page);

$start = $max*$page-$max;



$dialog = mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `del` = '0' ORDER BY `posl_time` DESC LIMIT $start, $max");

while($d = mysql_fetch_assoc($dialog)){

echo '<table class="div-link" role="link" data-href="'.$HOME.'/mes/dialog'.$d['kogo'].'" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$d['kogo']."'"));
echo (empty($ank['avatar'])?'<img class="ava_mes" src="/files/ava/net.png">':'<img class="ava_mes" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo '<div class="name_in-mes--user">'.nick($d['kogo']).'</div> <span class="time">'.vremja($d['time']).'</span>';

$count = mysql_result(mysql_query("SELECT COUNT(id) FROM `message` WHERE `kto` = '".$user['id']."' and `komy` = '".$d['kogo']."' or `kto` = '".$d['kogo']."' and `komy` = '".$user['id']."'"),0);

$list = mysql_fetch_assoc(mysql_query("SELECT * FROM `message` WHERE `kto` = '".$user['id']."' and `komy` = '".$d['kogo']."' or `kto` = '".$d['kogo']."' and `komy` = '".$user['id']."' ORDER BY `time` DESC LIMIT 1"));

if($count) {

echo '<div class="msg_block_norep">'.bb(smile($list['text'])).'';

} else {

echo 'Переписка еще не происходила';

}


if(!empty($list['id']) and $user['id'] != $list['kto'] and $list['readlen'] == 0) echo ' <span style="margin: 0 0 0 10px;" class="icon"><i class="fas fa-chevron-left" title="Не просмотренно"></i></span> ';

echo '</div>';

echo '</td>';

echo '</table>';

}



if($k_post < 1) echo '<div class="menu">Список контактов пуст</div>';

if($k_page > 1) echo str(''.$HOME.'/mes?',$k_page,$page); // Вывод страниц


break;



case 'del_c':



$id = abs(intval($_GET['id']));

$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));



if($ank == 0) {

echo err($title, 'Такого пользователя не существует!');

include ('../CGcore/footer.php'); exit;

}

echo '<div class="menu"><a href="'.$HOME.'/mes/">Сообщения</a> | Удалить диалог</div>';



if (isset($_GET['da'])){

$msg = mysql_query("SELECT * FROM `message` WHERE `kto` = '".$user['id']."' and `komy` = '".$id."' and `readlen` = '0' or `kto` = '".$id."' and `komy` = '".$user['id']."' and `readlen` = '0' ORDER BY `time` DESC");

while($m = mysql_fetch_assoc($msg)){

if($user['id'] == $m['komy']) {

mysql_query("UPDATE `message` SET `readlen` = '1' WHERE `id`='".$m['id']."' limit 1");

}

}



mysql_query('UPDATE `message_c` SET `del`="1" WHERE `kogo` = "'.$id.'" AND `kto` = "'.$user['id'].'" limit 1');

header('Location: '.$HOME.'/mes/'); exit;

}



echo '<div class="menu" style="border-bottom: 0px;">Вы действительно хотите УДАЛИТЬ диалог с '.nick($id).' ? <br /><br /><a class="ok_no_but" href="'.$HOME.'/mes/del_c'.$id.'?da">Да</a><a class="ok_no_but" href="'.$HOME.'/mes">Нет</a></div>';



break;



case 'newmes':



$id = abs(intval($_GET['id']));

$mess = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));



if(!isset($mess['id']) or $user['id'] == $mess['id']) {

echo err($title, 'Произошла ошибка!');

include ('../CGcore/footer.php'); exit;

}



$ignor = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$mess['id']."' and `kogo` = '".$user['id']."'"));

if($ignor['ignor'] == 1) {

echo err($title, 'Пользователь добавил вас в игнор лист!');

include ('../CGcore/footer.php'); exit;  

}





echo '<div class="menu"><a href="'.$HOME.'/mes/">Сообщения</a> | Новое письмо</div>';



if(isset($_REQUEST['ok'])) {



$text = strong($_POST['msg']);



if(empty($text) or mb_strlen($text) < 3) {

echo err('Ошибка ввода ,минимум 3 символа!');

include ('../CGcore/footer.php'); exit;

}



$tim = mysql_query("SELECT * FROM `message` WHERE `kto` = '".$user['id']."' ORDER BY `time` DESC");

while($ncm2 = mysql_fetch_assoc($tim)){

$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `mes` "));

$ncm_timeout = $ncm2['time'];

if((time()-$ncm_timeout) < $news_antispam['mes']) {

echo err('Пишите не чаще чем раз в '.$news_antispam['mes'].' секунд!');

include ('../CGcore/footer.php'); exit;

}

}



$con = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kogo` = '".$mess['id']."' and `kto` = '".$user['id']."' LIMIT 1"),0);

if($con == 0) {

mysql_query("INSERT INTO `message_c` SET `kto` = '".$user['id']."', `kogo` = '".$mess['id']."', `time` = '".time()."', `posl_time` = '".time()."'");

mysql_query("INSERT INTO `message_c` SET `kto` = '".$mess['id']."', `kogo` = '".$user['id']."', `time` = '".time()."', `posl_time` = '".time()."'");

}



$dels = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kogo` = '".$mess['id']."' and `kto` = '".$user['id']."' and `del` = '1' or `kogo` = '".$user['id']."' and `kto` = '".$mess['id']."' and `del` = '1' LIMIT 2"),0);

if($dels >= 1) {

mysql_query('UPDATE `message_c` SET `del`="0" WHERE `kogo` = "'.$mess['id'].'" AND `kto` = "'.$user['id'].'" limit 1');

mysql_query('UPDATE `message_c` SET `del`="0" WHERE `kogo` = "'.$user['id'].'" AND `kto` = "'.$mess['id'].'" limit 1');

}



mysql_query("UPDATE `message_c` SET `posl_time`='".time()."' WHERE `kogo` = '".$user['id']."' and `kto`='".$id."' limit 1");

mysql_query("UPDATE `message_c` SET `posl_time`='".time()."' WHERE `kto` = '".$user['id']."' and `kogo`='".$id."' limit 1");



mysql_query("INSERT INTO `message` SET `text` = '".$text."', `kto` = '".$user['id']."', `komy` = '".$mess['id']."', `time` = '".time()."', `readlen` = '0'");

header('Location: '.$HOME.'/mes/dialog'.$mess['id'].'');

exit();

}



echo '<div class="menu">Письмо: '.nick($id).'</div><div class="menu"><form action="" name="message" method="POST">

*Текст сообщения:<br />';

if($user['bb_panel'] == 1) {

include ('../CGcore/bbcode.php');  

}

echo '<textarea name="msg"></textarea><br />

<input type="submit" name="ok" value="Написать" />

</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/user_'.$mess['id'].'">В анкету '.$mess['login'].'</a></div>';





break;

case 'dialog':


$id = abs(intval($_GET['id']));

$mess = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));



if(isset($mess['id']) and $user['id'] == $id) {

echo err($title, 'Ошибка!');

include ('../CGcore/footer.php'); exit;

}



$di = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c`  WHERE `kto` = '".$user['id']."' and `kogo` = '".$mess['id']."'  LIMIT 1"));

if($di['del'] == 1) {

echo err($title,'Диалог был удален!');

include ('../CGcore/footer.php'); exit;

}





$ignor = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$mess['id']."' and `kogo` = '".$user['id']."'"));

$youignor = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `kogo` = '".$mess['id']."'"));



if(isset($_REQUEST['ok'])) {



$text = strong($_POST['msg']);



if($ignor['ignor'] == 1) {

echo err($title, 'Пользователь добавил Вас в игнор лист!');

include ('../CGcore/footer.php'); exit;  

}



if(empty($text) or mb_strlen($text) < 3) {

echo err('Ошибка ввода ,минимум 3 символа!');

include ('../CGcore/footer.php'); exit;

}



$tim = mysql_query("SELECT * FROM `message` WHERE `kto` = '".$user['id']."' ORDER BY `time` DESC");

while($ncm2 = mysql_fetch_assoc($tim)){

$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `mes` "));

$ncm_timeout = $ncm2['time'];

if((time()-$ncm_timeout) < $news_antispam['mes']) {

echo '<div class="menu"><center><b>Пишите не чаще чем раз в '.$news_antispam['mes'].' секунд!</b></center></div>';

include ('../CGcore/footer.php');

exit();

}

}



$files = null;

if($user['form_file'] == 1) {

$maxsize = 25; // Максимальный размер файла,в мегабайтах 

$size = $_FILES['filename']['size']; // Вес файла



if(@file_exists($_FILES['filename']['tmp_name'])) {

    

if($size > (1048576 * $maxsize)) {

echo err($title, 'Максимальный размер файла '.$maxsize.'мб!');

include ('../CGcore/footer.php'); exit;

}



$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp', 'zip', 'rar', 'mp4','mp3','amr','3gp','avi','flv' ); 

$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 



if(!in_array($upfiletype,$filetype)) {

echo err($title, 'Такой формат запрещено загружать!');

include ('../CGcore/footer.php'); exit;

}



$files = $_SERVER['HTTP_HOST'].'_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 

move_uploaded_file($_FILES['filename']['tmp_name'], "../files/mes/".$files.""); 

}

}

$con = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kogo` = '".$mess['id']."' and `kto` = '".$user['id']."' LIMIT 1"),0);

if($con == 0) {

mysql_query("INSERT INTO `message_c` SET `kto` = '".$user['id']."', `kogo` = '".$mess['id']."', `time` = '".time()."', `posl_time` = '".time()."'");

mysql_query("INSERT INTO `message_c` SET `kto` = '".$mess['id']."', `kogo` = '".$user['id']."', `time` = '".time()."', `posl_time` = '".time()."'");

}



$dels = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kogo` = '".$mess['id']."' and `kto` = '".$user['id']."' and `del` = '1' or `kogo` = '".$user['id']."' and `kto` = '".$mess['id']."' and `del` = '1' LIMIT 2"),0);

if($dels >= 1) {

mysql_query('UPDATE `message_c` SET `del`="0" WHERE `kogo` = "'.$mess['id'].'" AND `kto` = "'.$user['id'].'" limit 1');

mysql_query('UPDATE `message_c` SET `del`="0" WHERE `kogo` = "'.$user['id'].'" AND `kto` = "'.$mess['id'].'" limit 1');

}



mysql_query("INSERT INTO `forum_file` SET `post_id` = '".$id."', `name_file` = '".$files."'");

mysql_query("UPDATE `message_c` SET `posl_time`='".time()."' WHERE `kogo` = '".$user['id']."' and `kto`='".$id."' limit 1");

mysql_query("UPDATE `message_c` SET `posl_time`='".time()."' WHERE `kto` = '".$user['id']."' and `kogo`='".$id."' limit 1");



mysql_query("INSERT INTO `message` SET `text` = '".$text."', `kto` = '".$user['id']."', `komy` = '".$mess['id']."', `time` = '".time()."', `readlen` = '0', `file` = '".$files."'");



header('Location: '.$HOME.'/mes/dialog'.$mess['id'].'');

exit();

}

echo '<div class="menu"><img class="head_ava_us" src="https://hack-lair.com/files/ava/'.$mess['avatar'].'" style="width: 40px; height: 40px; margin: -21px 10px 0 0;"></img><span class="user_talk_block" style="display: inline-block; position: relative; margin-top: -5px;">'.nick($mess['id']).'<br />Был в сети: <span class="time">'.vremja($mess['viz']).'</span></span><div class="action_teme_us" style="margin: 0px;"><a href="'.$HOME.'/mes/ignor'.$mess['id'].'"><span class="ficon"><i class="fas fa-ban"></i></span></a><a href="'.$HOME.'/mes/del_c'.$mess['id'].'"><span class="ficon"><i class="fas fa-trash"></i></span></a></div></div>';

$max = 10000;

$k_post = mysql_result(mysql_query("SELECT COUNT(id) FROM `message` WHERE `kto` = '".$user['id']."' and `komy` = '".$mess['id']."' or `kto` = '".$mess['id']."' and `komy` = '".$user['id']."'"),0);

$k_page = k_page($k_post,$max);

$page = page($k_page);

$start = $max*$page-$max;



$msg = mysql_query("SELECT * FROM `message` WHERE `kto` = '".$user['id']."' and `komy` = '".$mess['id']."' or `kto` = '".$mess['id']."' and `komy` = '".$user['id']."' ORDER BY `time` LIMIT $start, $max");

echo '<div class="message_block">';

while($m = mysql_fetch_assoc($msg)){

echo '<table class="menu" style="border-bottom: 0px;" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$m['kto']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content_msg">';

if($m['kto'] == $user['id']) echo nick($m['kto']).' ';

else echo nick($m['kto']).' ';

echo '<span class="time_mes">'.vremja($m['time']).'</span>';



$sav = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_save` WHERE `uid` = '".$m['id']."'"),0);





echo '<div class="block_msg">'.bb(smile($m['text'])).'';


if($m['readlen'] == 0) {

echo ' <span class="icon_mes">
<svg xmlns="http://www.w3.org/2000/svg" width="22px" height="auto" viewBox="0 0 24 18" fill="none">
<path d="M4 12.9L7.14286 16.5L15 7.5" stroke="#c33929" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</span> ';

} else {

echo ' <span class="icon_mes">
<svg xmlns="http://www.w3.org/2000/svg" width="22px" height="auto" viewBox="0 0 24 18" fill="none">
<path d="M4 12.9L7.14286 16.5L15 7.5" stroke="#c33929" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M20 7.5625L11.4283 16.5625L11 16" stroke="#c33929" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</span> ';

}



if($m['file'])

echo '<a href="../files/mes/'.$m['file'].'">'.$m['file'].'</a> ['.fsize('../files/mes/'.$m['file']).']';





if($user['id'] == $m['komy']) {

mysql_query("UPDATE `message` SET `readlen` = '1' WHERE `id`='".$m['id']."' limit 1");

}
	

echo '</div>';
echo '</td>';
echo '</table>';

}

echo '</div>';


if($ignor['ignor'] != 1) {

echo '<form action="" name="message" method="POST" enctype="multipart/form-data">';
if($user['form_file'] == 1) {


}

include ('../CGcore/bbcode.php');  

echo '<style>
.content {
	padding: 8px 8px 0 8px;
}
</style>';

echo '<title>Сообщения</title>';

echo '<div class="menu_tad" style="display: flex;">';
echo '<textarea id="content" type="pole" placeholder="Введите сообщение..." name="msg" class="amemenu-kamesan"></textarea>';
?><button class="drop" href="#" onclick="$('.teg').toggle();return false;"><i style="background: none; padding: 0px 10px 0 15px; font-size: 23px; border-radius: 0px 7px 7px 0px; margin-top: 1px; position: relative;" class="fa-solid fa-arrow-up"></i></button><?
?><button class="drop" type="submit" name="ok"><svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 -1 25 24" fill="none">
<path d="M11.5003 12H5.41872M5.24634 12.7972L4.24158 15.7986C3.69128 17.4424 3.41613 18.2643 3.61359 18.7704C3.78506 19.21 4.15335 19.5432 4.6078 19.6701C5.13111 19.8161 5.92151 19.4604 7.50231 18.7491L17.6367 14.1886C19.1797 13.4942 19.9512 13.1471 20.1896 12.6648C20.3968 12.2458 20.3968 11.7541 20.1896 11.3351C19.9512 10.8529 19.1797 10.5057 17.6367 9.81135L7.48483 5.24303C5.90879 4.53382 5.12078 4.17921 4.59799 4.32468C4.14397 4.45101 3.77572 4.78336 3.60365 5.22209C3.40551 5.72728 3.67772 6.54741 4.22215 8.18767L5.24829 11.2793C5.34179 11.561 5.38855 11.7019 5.407 11.8459C5.42338 11.9738 5.42321 12.1032 5.40651 12.231C5.38768 12.375 5.34057 12.5157 5.24634 12.7972Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button><?
echo '</div>';



} else {

echo '<div class="noti_mes">'.nick($mess['id']).' добавил вас в игнор лист</div>';

}


if($k_post < 1) echo '<div class="menu">Переписка с '.nick($mess['id']).' еще не состоялась</div>';

if ($k_page > 1) echo str(''.$HOME.'/mes/dialog'.$mess['id'].'?',$k_page,$page); // Вывод страниц




break;

case 'ignor':



$id = abs(intval($_GET['id']));

$mess = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."' LIMIT 1"));



$ig = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `kogo` = '".$mess['id']."' LIMIT 1"));

if(isset($mess['id']) and $user['id'] != $mess['id'] and $ig['ignor'] != 1) {



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Игнорировать  '.$mess['login'].'</div>';



if(isset($_REQUEST['okda'])) {

mysql_query("UPDATE `message_c` SET `ignor` = '1' WHERE `kogo` = '".$mess['id']."' and `kto` = '".$user['id']."'");

header('Location: '.$HOME.'/mes/dialog'.$mess['id'].'');

exit();

}



echo '<div class="menu" style="border-bottom: 0px;">Вы действительно хотите добавить '.nick($id).' в игнор лист? <br /><br /><a class="ok_no_but" href="'.$HOME.'/mes/ignor'.$mess['id'].'?okda">Да</a><a class="ok_no_but" href="'.$HOME.'/mes">Нет</a></div>';



} else {

echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Ошибка</div>

<div class="menu"><center><b>Ошибка</b></center></div>';

include ('../CGcore/footer.php');

exit();

}



break;

case 'ignor_list':



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Ваш игнор лист</div>';



if (empty($user['max'])) $user['max']=100;

$max = $user['max'];

$k_post = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_c` WHERE `kto` = '".$user['id']."' and `ignor` = '1'"),0);

$k_page = k_page($k_post,$max);

$page = page($k_page);

$start = $max*$page-$max;



$ignor = mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `ignor` = '1' ORDER BY `id` DESC LIMIT $start, $max");

while($i = mysql_fetch_assoc($ignor))

{

echo '<div class="menu">'.nick($i['kogo']).' [<a href="'.$HOME.'/mes/ignor_up'.$i['kogo'].'">убрать с игнора</a>]</div>';

}



if($k_post < 1) echo '<div class="menu">Игнор-лист пуст</div>';

if ($k_page > 1) echo str(''.$HOME.'/mes/ignor_list/?',$k_page,$page); // Вывод страниц



break;

case 'ignor_up':



$id = abs(intval($_GET['id']));

$youignor = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `kogo` = '".$id."'"));



if($youignor['ignor'] == 1) {



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Убрать с игнор листа </div>';



if(isset($_REQUEST['okda'])) {

mysql_query("UPDATE `message_c` SET `ignor` = '0' WHERE `kogo` = '".$youignor['kogo']."' and `kto` = '".$user['id']."'");

header('Location: '.$HOME.'/mes/ignor_list/');

exit();

}



echo '<div class="menu" style="border-bottom: 0px;">Вы действительно хотите убрать '.nick($youignor['kogo']).' с вашего игнор листа?<br /><br /><a class="ok_no_but" href="'.$HOME.'/mes/ignor_up'.$id.'?okda">Да</a><a class="ok_no_but" href="'.$HOME.'/mes">Нет</a></div>';

} else {

echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Ошибка </div>';

echo '<div class="menu"><center><b>Ошибка,этот пользователь не в игнор листе</b></center></div>';

}



break;

case 'save_mes':



$id = abs(intval($_GET['id']));

$save = mysql_fetch_assoc(mysql_query("SELECT * FROM `message` WHERE `id` = '".$id."' LIMIT 1"));



if(isset($save['id']) and $save['komy'] == $user['id'] or $save['kto'] == $user['id']) {



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Добавить в избранное </div>';



if(isset($_REQUEST['okda'])) {

mysql_query("INSERT INTO `message_save` SET `uid` = '".$id."', `kto` = '".$user['id']."', `text` = '".$save['text']."', `ktoavtor` = '".$save['kto']."', `time` = '".$save['time']."'");

header('Location: '.$HOME.'/mes/save/');

exit();

}



echo '<div class="menu">Вы действительно хотите сохранить это письмо?<br /><a href="'.$HOME.'/mes/save_mes'.$id.'?okda">Да</a></div>';

} else {

echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Ошибка</div>

<div class="menu"><center><b>Такого сообщения не существует!<b></center></div>';

include ('../CGcore/footer.php');

exit();

}



break;

case 'save':



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Избранные сообщения</div>';



if (empty($user['max'])) $user['max']=10;

$max = $user['max'];

$k_post = mysql_result(mysql_query("SELECT COUNT(id) FROM `message_save` WHERE `kto` = '".$user['id']."'"),0);

$k_page = k_page($k_post,$max);

$page = page($k_page);

$start = $max*$page-$max;



$sa = mysql_query("SELECT * FROM `message_save` WHERE `kto` = '".$user['id']."'");

while($s = mysql_fetch_assoc($sa))

{

echo '<div class="menu">Сообщение от: '.nick($s['ktoavtor']).' ('.vremja($s['time']).')</div><div class="menu">'.bb(smile($s['text'])).'<br />[<a href="'.$HOME.'/mes/delsave'.$s['id'].'">убрать с избранных</a>]</div>';

}



if($k_post < 1) echo '<div class="menu">Избранных сообщений пока нету</div>';

if ($k_page > 1) echo str(''.$HOME.'/mes/save/?',$k_page,$page); // Вывод страниц



break;

case 'delsave':



$id = abs(intval($_GET['id']));

$save = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_save` WHERE `id` = '".$id."' LIMIT 1"));



if(isset($save['id']) and $save['kto'] == $user['id']) {



if(isset($_REQUEST['okda'])) {

mysql_query("DELETE FROM `message_save` WHERE `id` = '".$id."'");

header('Location: '.$HOME.'/mes/save/');

exit();

}



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Удалить избранное сообщение </div>';

echo '<div class="menu">Вы действительно хотите удалить это сообщение с избранных?<br /><a href="'.$HOME.'/mes/delsave'.$id.'?okda">Да</a></div>';

} else {

echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Удалить избранное сообщение </div>';

echo '<div class="menu"><center><b>Такого сообения не существует!</b></center></div>';

}



break;

case 'search':



echo '<div class="title"><a href="'.$HOME.'/mes/">Сообщения</a> | Поиск по переписке </div>

<div class="menu">Введите текст,который хотите найти в личных диалогах!</div>

<div class="menu"><form action="" method="POST">

Текст:<br /><input type="text" name="ser" /></br />

<input type="submit" name="ok" value="Искать" />

</form></div>';



if(isset($_REQUEST['ok'])) {



$ser = strong($_POST['ser']);



if(empty($ser) or mb_strlen($ser) < 3) {

echo '<div class="menu"><center><b>Ошибка ввода ,минимум 3 символа</b></center></div>';

include ('../CGcore/footer.php');

exit();

}



echo '<div class="menu"><img src="'.$HOME.'/design/gradient/lol.png"> Результаты поиска:</div>';

$search = mysql_query("SELECT * FROM `message` where `text` LIKE '%".$ser."%' and `komy` = '".$user['id']."' or `text` LIKE '%".$ser."%' and `kto` = '".$user['id']."' ORDER BY `time` DESC ");

$sql = mysql_result(mysql_query("SELECT COUNT(*) FROM `message` where `text` LIKE '%".$ser."%' and `komy` = '".$user['id']."' or `text` LIKE '%".$ser."%' and `kto` = '".$user['id']."'"),0);



while($s = mysql_fetch_assoc($search)){

echo '<div class="menu">'.nick($s['kto']).' =(написал)=> '.nick($s['komy']).' ('.vremja($s['time']).')</div>

<div class="menu">'.bb(smile($s['text'])).'</div>';

}

}



if($sql == 0) echo '<div class="menu"><center><b>По вашему запросу ничего не найдено!</b></center></div>';



break;

}

//-----Подключаем низ-----//

include ('../CGcore/footer.php');

?>