<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

include '../design/element-styles/anketa.php';

if(!isset($user['id'])) {
echo err($title, '
Уважаемый посетитель, Вы зашли на сайт как незарегистрированный пользователь.<br/>
Мы рекомендуем Вам зарегистрироваться либо войти на сайт под своим именем.
');
include ('../CGcore/footer.php'); exit;
}

$act = isset($_GET['act']) ? $_GET['act'] : null;
$id = abs(intval($_GET['id']));
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

echo '<title>'.$ank['login'].' - '.$index['pod-title'].'</title>';
echo '<meta name="description" content="Профиль пользователя '.$ank['login'].'">';

switch($act)
{
default:


if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
$title = 'Профиль';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="cont_ank">';

if(empty($ank['background'])) { echo '<style>body { background: #292929; }</style>'; } else { include '../design/element-styles/background-vip-prime.php'; }


$ban = mysql_fetch_assoc(mysql_query("SELECT * FROM `ban_list` WHERE `kto` = '".$id."' && `time_end` > '".time()."' LIMIT 1"));
if($ban != 0) {
echo '<div class="ban">';
echo '<span class="ban-tag">Пользователь заблокирован</span>';

echo '<span class="ban-info">';
echo '<span class="ban-punct">Заблокировал: </span>'.nick($ban['add_ban']).'<br/>';
echo '<span class="ban-punct">Причина: </span>'.smile(bb($ban['about'])).'<br/>';
echo '<span class="ban-punct">Дата разблокировки: </span>'.date('d.m.Y в H:i',$ban['time_end']).'';
echo '</div>';
echo '</span>';

echo '<style>
.ank-buttun--menu {
	display: none;
}
</style>';
}

echo '<head-ank--block>';

echo (empty($ank["headback"])?'<div class="ank_block" style="background: rgba(33, 33, 33, 0.85);">':'<div class="ank_block" style="background: linear-gradient(rgba(54, 54, 54, 0.35), rgba(54, 54, 54, 0.35)), url('.$ank['headback'].'); background-size: cover;"><style>.headank { border-bottom: 0px }</style>');

echo '<div class="headank" style="padding-bottom: 15px; border-radius: 10px 10px 0 0; background: none;">';
echo '<span class="nickname" style="font-size: 15px; padding-left: 10px;"><b>'.nick($ank['id']).'</b></span> ';

if($ank['prev'] == 0){ echo '<span></span>'; }
elseif($ank['prev'] == 1){ echo '<span class="vip" data-hint-prefix="VIP"><img src="https://icon666.com/r/_thumb/nge/ngeuw8us7zuc_64.png" alt="Звезда" style="width: 13px; margin-top: -5px;"></span>'; }
elseif($ank['prev'] == 2){ echo '<span class="prime" data-hint-prefix="PRIME"><i class="fas fa-crown"></i></span>'; }

echo '<span style="float:right; padding-right: 10px;">'.vremja($ank['viz']).'</span>';
echo '</div>';

echo '<center><div class="menu" style="padding-bottom: 15px; border-bottom: 0px; background: none; box-shadow: none;">';
echo '<td style="width: 90px;">';
echo (empty($ank['avatar'])?'<img src="files/ava/net.png" style="border-radius: 100px; width: 90px; height: 90px; margin-right: 0px;">':'<img src="files/ava/'.$ank['avatar'].'" style="border-radius: 100px; width: 90px; height: 90px;">');
echo '</td>';
echo '</div>';

if($ank['level'] == 0){  echo '<font color="ffffff"></font>';}
if($ank['level'] == 1){  echo '<font color="ffffff" style="background-color: #658e5b; padding: 2px 15px; border-radius: 5px; font-size: 12px;">Модератор</font>';}
elseif($ank['level'] == 2){ echo '<font color="ffffff" style="background-color: #517e94; padding: 2px 15px; border-radius: 5px; font-size: 12px;">Администратор</font>';}
elseif($ank['level'] == 3){ echo '<font color="ffffff" style="background-color: #e06b6b; padding: 2px 15px; border-radius: 5px; font-size: 12px;">Директор</font><background>';}

echo '</center>';

echo '<center><div class="menu" style="padding-top: 5px; margin-top: 0px; padding: 10px; max-width: 900px; height: 25px; border-bottom: 0px; border-radius: 10px; background: none;">';
echo '<div class="ank_status_text">';
echo (empty($ank['stat'])?'Статус не установлен':''.bb($ank['stat']).'');
echo '</div>';
echo '</div></center>';

echo '<center><div class="ank-buttun--menu">';

if($user['id'] != $ank['id']) {
echo '<table style="text-align: center; padding: 12px; border-top: 1px solid #303030; border-bottom: 0px; border-radius: 0 0 10px 10px" class="menu" cellspacing="0" cellpadding="0">';
echo '<td><a class="dev" href="'.$HOME.'/mes/dialog'.$ank['id'].'">Написать</a>';
$fri = mysql_fetch_assoc(mysql_query("SELECT * FROM `friends` WHERE `us_a` = '".$user['id']."' and `us_b` = '".$ank['id']."'"));
if($fri['status'] != 1) {
echo '<td><a class="dev" href="'.$HOME.'/friends/add'.$ank['id'].'">В друзья</a></td>';
} else {
echo '<td><a class="dev" href="'.$HOME.'/friends/delete'.$ank['id'].'">Из друзей</a></td>';
}
$ignor = mysql_fetch_assoc(mysql_query("SELECT * FROM `message_c` WHERE `kto` = '".$user['id']."' and `kogo` = '".$ank['id']."'"));
if($ignor['ignor'] != 1) {
echo '<td><a class="dev" href="'.$HOME.'/mes/ignor'.$ank['id'].'" style="margin: 0px;">ЧС</a></td>';
} else {
echo '<td><a class="dev" href="'.$HOME.'/mes/ignor_up'.$ank['id'].'" style="margin: 0px;">Из чс</a></td>';
}
echo '</table>';
}

echo '</div></center>';

echo '</div>';

if($user['prev'] == 0) { echo '<span></span>'; }
if($user['prev'] == 1) { echo '<span></span>'; }
if($user['prev'] == 2 & $ank['id'] == $user['id']) { echo '<a class="but_headbar_rez" href="#reset_headbar">Сменить фон</a>'; }

if(isset($_REQUEST['okset'])) { $okback = strong($_POST['okback']); mysql_query("UPDATE `users` SET `background` = '".$okback."' WHERE `id` = '".$user[id]."' LIMIT 1");}
if(isset($_REQUEST['okset'])) { $oksetbar = strong($_POST['oksetbar']); mysql_query("UPDATE `users` SET `headback` = '".$oksetbar."' WHERE `id` = '".$user[id]."' LIMIT 1"); echo '
<script>
let stateObj = {
  foo: "bar",
};

history.pushState(stateObj, "page 2", "https://hack-lair.com/user_'.$user['id'].'");
</script>

<script>
let stateObj = {
  foo: "bar",
};

history.pushState(stateObj, "page 2", "https://hack-lair.com/user_'.$user['id'].'");
</script>';}

if($user['prev'] == 0) {
echo '<div id="reset_headbar" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Упс...</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">К сожалению в данный момент этот раздел вам не доступен. Предобретите PRIME чтобы воспользоваться сменой фона.</div><br />
		<center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';
}

if($user['prev'] == 1) {
echo '<div id="reset_headbar" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Упс...</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">К сожалению в данный момент этот раздел вам не доступен. Предобретите PRIME чтобы воспользоваться сменой фона.</div><br />
		<center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';
}

if($user['prev'] == 2) {
echo '<div id="reset_headbar" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Замена фона</h3>
      </div>
      <div class="modal-body">    
  <form name="form" action="?act=set&amp;ok=1" method="post">
        <div class="text-in-modal" style="margin-left: 5px;">Шапка</div>
        <center><input type="text" name="oksetbar" id="okset" style="margin-top: 5px; margin-bottom: 0px; border-bottom: 0px;" value="'.$user['headback'].'" placeholder="URL картинки..." /></center><br />
		<div class="text-in-modal" style="margin-left: 5px;">Фон</div>
		<center><input type="text" name="okback" id="okset" style="margin-top: 5px; margin-bottom: 0px; border-bottom: 0px;" value="'.$user['background'].'" placeholder="URL картинки..." /></center><br />
		<center><input type="submit" name="okset" value="Сохранить" style="margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
        </form>
		<center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>';
}


$count_friends = mysql_result(mysql_query("SELECT COUNT(*) FROM `friends` WHERE `us_a` = '".$ank['id']."' AND `status` = '1'"),0);
$t_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '$ank[id]'"),0);
$p_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '$ank[id]'"),0);




echo '<div class="menu" style="margin-top: 15px; border-radius: 10px 10px 0 0;">';

echo '<div class="balance_user">Баланс: <span class="balance" style="color: #c33929; font-weight: bold;">'.bb($ank['money']).' ₽</span></div>';



if($id == $user['id']) {
echo '<div class="plus_money">';
echo '<a class="bot_bal" href="https://hack-lair.com/pay/" style="float: right;">Пополнить</a>';
echo '</div>';
} else {
echo '<div class="plus_money">';
echo '<a class="bot_bal" href="'.$HOME.'/user/perevod.php?id='.$ank['id'].'" style="float: right;">Перевести</a>';
echo '</div>';
}


echo '</div>';


echo '<div class="menu">';

echo (empty($ank['datareg'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc" style="display: inline-block; width: 150px; float: left;">
<div class="pod_object" style="display: inline-block; float: left;">
<div class="text_data_us">Регистрация:</div></div></div>

<div class="object_init" style="display: inline-block;width: 100px;">
<div class="pod_object" style="display: inline-block; float: left;">
<div class="info_ank_blc_text">'.vremja($ank['datareg']).'</div></div></div></div>');


echo (empty($ank['name'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Имя:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">'.bb($ank['name']).'</div></div></div></div>');


echo (empty($ank['strana'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Страна:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">'.bb($ank['strana']).'</div></div></div></div>');


echo (empty($ank['gorod'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Город:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">'.bb($ank['gorod']).'</div></div></div></div>');


if($ank['sex'] == 1) {
echo (empty($ank['sex'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Пол:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">Мужской</div></div></div></div>');
}

if($ank['sex'] == 2) {
echo (empty($ank['sex'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Пол:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">Женский</div></div></div></div>');
} else { echo '<span></span>'; }


echo (empty($ank['url'])?'<span></span>':'<div class="block_init">
<div class="object_ank_info_blc">
<div class="pod_object">
<div class="text_data_us">Сайт:</div></div></div>

<div class="object_init">
<div class="pod_object">
<div class="info_ank_blc_text">'.bb($ank['url']).'</div></div></div></div>');

echo '</span>


<div class="anc_function_buttons">
<a class="long-lite" href="/them'.$id.'"><span class="farier"><i class="far fa-comment-alt" style="margin: 0 8px 0px 6px; color: #525050; font-size: 15px; display: inline;"></i></span> Темы от '.$ank['login'].'</a>
<a class="long-lite" href="/reputation'.$id.'"><span class="farier"><i class="far fa-arrow-alt-circle-up" style="margin: 0 8px 0px 6px; color: #525050; font-size: 15px; display: inline;"></i></span> Поднять репутацию</a></div></div>';


echo '<div class="menu" style="text-align:center; border-radius: 0px 0px 10px 10px; margin-top: 0px; border-bottom: 0px;" class="menu" cellspacing="0" cellpadding="0">';
echo '<center><div class="tablo-prof-ind" style="overflow-x: scroll; white-space: nowrap;">
<div class="ank-indikation"><a href="/them'.$id.'"><font color="#fc3e27">'.$t_forum.'</font></br><font color="#949494">темы</font></a></div>
<div class="ank-indikation"><a href="/reputation'.$id.'"><font color="#fc3e27">'.mysql_result(mysql_query('select count(`id`) from `repa_user` where `komy` = "'.$ank['id'].'" and `repa` = "+"'),0).'</font></br><font color="#949494">репутация</font></a></div>
<div class="ank-indikation"><a href="/post'.$id.'"><font color="#fc3e27">'.$p_forum.'</font></br><font color="#949494">ответы</font></a></div>
<div class="ank-indikation"><a href="/friends'.$id.'"><font color="#fc3e27">'.$count_friends.'</font></br><font color="#949494">друзья</font></a></div>
</div></center>';

echo '</div>';

echo '</div>';


/*** Стена в профиле ***/

echo '<div class="stena">';
if(isset($_REQUEST['ok'])) {

$msg = strong($_POST['msg']);
if(empty($msg)) {
echo err('Введите сообщение!');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($msg) < 3) {
echo err('Введите сообщение минимум 3 символа!');
include ('../CGcore/footer.php'); exit;
}

$ttte = mysql_fetch_array(mysql_query('select * from `stena` where `avtor` = "'.$user['id'].'" and `msg` = "'.$msg.'"'));
if($ttte != 0) {
echo err('Вы такой пост уже писали!');
include ('../CGcore/footer.php'); exit;
}

$tim = mysql_query("SELECT * FROM `stena` WHERE `avtor` = '".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `stena` "));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['stena'])
{
echo err('Пишите не чаще чем раз в '.$news_antispam['stena'].' секунд!');
include ('../CGcore/footer.php'); exit;
}
}
mysql_query("INSERT INTO `stena` SET `msg` = '".$msg."', `avtor` = '".$user['id']."', `ukogo` = '".$id."', `time` = '".time()."'");

if($user['id'] != $ank['id']) {
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'написал у вас на [url=".$HOME."/user_".$anks['id']."]стене[/url]'");
}
}

include ('../CGcore/bbcode.php');  

echo '<div class="menu_tad">';
echo '<form action="" name="message" method="POST" onsubmit="return getContent()" style="display: flex;"> ';
echo '<img class="avatar" src="/files/ava/'.$user['avatar'].'" style="margin-top: 4px; width: 38px; height: 36px;">';
echo '<textarea id="content" type="pole" placeholder="Создать запись..." name="msg" class="amemenu-kamesan" style="border: 1px solid #303030; background: none;"></textarea>';
?><button class="drop" href="#" onclick="$('.teg').toggle();return false;"><i style="background: none; padding: 0px 10px 0 15px; font-size: 23px; border-radius: 0px 7px 7px 0px; margin-top: 1px; position: relative;" class="fa-solid fa-arrow-up"></i></button><?
?><button class="drop" type="submit" name="ok"><svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 -1 25 24" fill="none">
<path d="M11.5003 12H5.41872M5.24634 12.7972L4.24158 15.7986C3.69128 17.4424 3.41613 18.2643 3.61359 18.7704C3.78506 19.21 4.15335 19.5432 4.6078 19.6701C5.13111 19.8161 5.92151 19.4604 7.50231 18.7491L17.6367 14.1886C19.1797 13.4942 19.9512 13.1471 20.1896 12.6648C20.3968 12.2458 20.3968 11.7541 20.1896 11.3351C19.9512 10.8529 19.1797 10.5057 17.6367 9.81135L7.48483 5.24303C5.90879 4.53382 5.12078 4.17921 4.59799 4.32468C4.14397 4.45101 3.77572 4.78336 3.60365 5.22209C3.40551 5.72728 3.67772 6.54741 4.22215 8.18767L5.24829 11.2793C5.34179 11.561 5.38855 11.7019 5.407 11.8459C5.42338 11.9738 5.42321 12.1032 5.40651 12.231C5.38768 12.375 5.34057 12.5157 5.24634 12.7972Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button><?
echo '</form></div>';


if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `stena` WHERE `ukogo` = '".$id."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$stena = mysql_query("SELECT * FROM `stena` WHERE `ukogo` = '".$id."' ORDER BY `time` DESC LIMIT $start, $max");
while($st = mysql_fetch_assoc($stena)){

echo '<div class="ms_block">';
echo '<table class="post_it_is" cellspacing="0" cellpadding="0">';

echo '<td class="block_content_us">';

echo '<div class="menu" style="background: none; padding: 0px 0px 10px 0px;">';
if($id == $user['id'] or $user['level'] >= 1) echo ' <a class="del_post_us" style="float: right;" href="'.$HOME.'/delmsg_'.$st['id'].'"><i class="fas fa-trash"></i></a>';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$st['avtor']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'" style="margin-top: -20px;">');
echo '<span class="ava_init_block;" style="margin-left: 5px; position: relative; display: inline-block; margin-bottom: -10px;">'.nick($st['avtor']).' <br /> <span class="time" style="display: inline-block; margin-left: 0px; margin-top: 4px;">'.vremja($st['time']).'</span></span>';
echo '</div>';

echo '<div class="block_msg" style="margin-top: 5px;">'.smile(bb($st['msg'])).'</div>';

echo '</td>';
echo '</table>';

echo '</div>';

}

if($k_post < 1) {
echo '<div class="st_title" style="padding: 15px;"><center>Постов нет</center></div><hr>';
}

echo '</div>';


/*** Функции для админа ***/
if($user['level'] >= 1) {
echo '<div class="adm_block" style="margin-top: 15px;">';
echo '<div style="margin-top: 5px; border-bottom: 0px; font-size: 12px;" class="menu">
» Браузер: '.$ank['browser'].' <br />
» IP: '.$ank['ip'].'
</div>';

echo '</div>';


if($ank['level'] <= $user['level'] and $user['id'] != $ank['id']) {

if($ban != 0){
echo '<a class="link" href="/panel/ban/list/updateban'.$id.'"><span class="icon"><i class="fas fa-shield-alt"></i></span>Разблокировать</a>';
} else {
echo '<a class="link" href="/panel/ban/list/addban'.$id.'"><span class="icon"><i class="fas fa-shield-alt"></i></span>Заблокировать</a>';
}

echo '<a class="link" href="/panel/up_us_'.$id.'"><span class="icon"><i class="fas fa-edit"></i></span>Редактировать</a>';

}
echo '</div>';
}

break;

##СТЕНА

case 'stena':

if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="title"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> > Стена</div>';

if(isset($_REQUEST['ok'])) {

$msg = strong($_POST['msg']);
if(empty($msg)) {
echo err('Введите сообщение!');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($msg) < 3) {
echo err('Введите сообщение минимум 3 символа!');
include ('../CGcore/footer.php'); exit;
}

$ttte = mysql_fetch_array(mysql_query('select * from `stena` where `avtor` = "'.$user['id'].'" and `msg` = "'.$msg.'"'));
if($ttte != 0) {
echo err('Вы такой пост уже писали!');
include ('../CGcore/footer.php'); exit;
}

$tim = mysql_query("SELECT * FROM `stena` WHERE `avtor` = '".$user['id']."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `stena` "));
$ncm_timeout = $ncm2['time'];
if((time()-$ncm_timeout) < $news_antispam['stena'])
{
echo err('Пишите не чаще чем раз в '.$news_antispam['stena'].' секунд!');
include ('../CGcore/footer.php'); exit;
}
}
mysql_query("INSERT INTO `stena` SET `msg` = '".$msg."', `avtor` = '".$user['id']."', `ukogo` = '".$id."', `time` = '".time()."'");

if($user['id'] != $ank['id']) {
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'написал у вас на [url=".$HOME."/user_".$ank['id']."?selection=top]стене[/url]'");
}

header('Location: '.$HOME.'/stena_id_'.$id.'');
}

echo '<div class="menu">
<form action="" name="message" method="POST">
<textarea name="msg" placeholder="Введите сообщение..."></textarea><br />
<input type="submit" name="ok" value="Написать" />
</form></div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `stena` WHERE `ukogo` = '".$id."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$stena = mysql_query("SELECT * FROM `stena` WHERE `ukogo` = '".$id."' ORDER BY `time` DESC LIMIT $start, $max");
while($st = mysql_fetch_assoc($stena)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$st['avtor']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo ''.nick($st['avtor']).' <span class="time">'.vremja($st['time']).'</span>';
if($id == $user['id'] or $user['level'] >= 1) echo ' [<a href="'.$HOME.'/delmsg_'.$st['id'].'">удалить</a>]';
echo '<div class="block_msg">'.smile(bb($st['msg'])).'</div>';

echo '</td>';
echo '</table>';

}

if($k_post < 1) {
echo '<div class="menu">Сообщений нет</div>';
}


break;
case 'delmsg':

$id = abs(intval($_GET['id']));
$stenka = mysql_fetch_assoc(mysql_query("SELECT * FROM `stena` WHERE `id` = '".$id."'"));
$anks = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$stenka['ukogo']."'"));

if($stenka == 0) {
echo err($title, 'Такого комментария не существует!');
include ('../CGcore/footer.php'); exit;
}

if($anks['id'] == $user['id'] or $user['level'] >= 1) {
mysql_query("DELETE FROM `stena` WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/user_'.$anks['id'].'');
exit();
} else {
header('Location: '.$HOME.'/user_'.$anks['id'].'');
exit();
}

break;

##РЕПУТАЦИЯ

case 'repa':

echo '<div class="func-rep">';

if($ank == 0) {
echo err($title, 'Такого пользователя не существует!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | Репутация</div>';

if(isset($_REQUEST['ok'])) {

$text = strong($_POST['msg']);
$repa = abs(intval($_POST['repa']));

if($user['id'] == $ank['id']) {
echo err('Вы не можете изменять себе репутацию!');
include ('../CGcore/footer.php'); exit;
}

if(empty($text)) {
echo err('Введите текст!');
include ('../CGcore/footer.php'); exit;
}

if($repa != '0' && $repa != '1') {
echo err('Можно ставить только + или -');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($text,'UTF-8') < 3) {
echo err('Введите сообщение минимум 3 символа!');
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_array(mysql_query('select * from `repa_user` where `kto` = "'.$user['id'].'" and `text` = "'.$text.'"'));
if($sql != 0) {
echo err('Ошибка!');
include ('../CGcore/footer.php'); exit;
}
if($repa == '0') $repa = '+';
elseif($repa == '1') $repa = '-';

$tim = mysql_query("SELECT * FROM `repa_user` WHERE `komy` = '".$id."' ORDER BY `time` DESC");
while($ncm2 = mysql_fetch_assoc($tim)){  
$news_antispam = mysql_fetch_assoc(mysql_query("SELECT * FROM `antispam` WHERE `repa` "));
$ncm_timeout = $ncm2['time'];
$vremja = 0 * $news_antispam['repa'];
if((time()-$ncm_timeout) < $vremja) {
echo err('Репутацию можно изменять раз в '.$news_antispam['repa'].' Минут! ');
include ('../CGcore/footer.php'); exit;
}
}

$settings = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));
mysql_query("INSERT INTO `repa_user` SET `text` = '".$text."', `kto` = '".$user['id']."', `komy` = '".$id."', `time` = '".time()."', `repa` = '".$repa."'");

if($repa == '+') {
##добавляем юзеру рейтинг
mysql_query("UPDATE `users` SET `rating` = '".($user['rating']+0.05)."' WHERE `id` = '".$id."' LIMIT 1");
##Оповещаем юзера
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'повысил вашу репутацию'");
}
elseif($repa == '-') {
##отнимаем юзеру рейтинг
mysql_query("UPDATE `users` SET `rating` = '".($user['rating']-0.02)."' WHERE `id` = '".$id."' LIMIT 1");
##Оповещаем юзера
mysql_query("INSERT INTO `lenta` SET `readlen` = '0', `time` = '".time()."', `komy` = '".$ank['id']."', `kto` = '".$user['id']."', `text` = 'понизил вашу репутацию'");
}

header('Location: '.$HOME.'/reputation'.$id.'');
}

if($user['id'] != $ank['id']) {

echo '<div class="spoiler-block" style="margin: 0px; background: #222; padding: 10px;">';
echo '<a href="#" class="spoiler-title" style="color :#d6d6d6; padding: 6px 6px 7px; background: #303030; margin: 5px;"><center>Изменить репутацию</center></a>';
echo '<div class="spoiler-content" style="padding: 3px; background: #222; border-radius: 10px; margin-top: 10px;">';

echo '<div class="menu"><form action="" name="message" method="POST">
<center><textarea name="msg" placeholder="Введите сообщение..."></textarea></center>
<center><select name="repa" style=" margin-right: 0px; margin-left: 1px;">
<option value="0">Плюс</option>
<option value="1">Минус</option>
</select></center>
<center><input type="submit" name="ok" value="Изменить репутацию" style="width: 180px;" /></center>
</form></div>';

echo '<div class="menu" style="border-bottom: 0px;"><center>Обязательно указывайте за что вы изменяете репутацию данного юзера</center></div>';

echo '</div>';
echo '</div>';
}

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `repa_user` WHERE `komy` = '".$id."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$repa = mysql_query("SELECT * FROM `repa_user` WHERE `komy` = '".$id."' ORDER BY `time` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($repa)){

echo '<div class="ms_r_block">';
echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['kto']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo ''.nick($a['kto']).' <span class="time">'.vremja($a['time']).'</span>';
if($user['level'] >= 1) echo ' <a class="del_post_us" href="'.$HOME.'/del_repa_'.$a['id'].'" style="float: right"><i class="fas fa-trash"></i></a>';
echo '<div class="block_msg"><span style="color: #228e5d; font-weight: bold;">'.$a['repa'].'</span> '.smile(bb($a['text'])).'</div>';

echo '</td>';
echo '</table>';

echo '</div>';

}

if($k_post < 1) {
echo '<div class="menu" style="border-bottom: 0px;"><center>Репутацию не изменяли</center></div>';
}

if ($k_page>1) {
echo str('reputation'.$id.'?',$k_page,$page); // Вывод страниц
}

break;
case 'del_repa':

$id = abs(intval($_GET['id']));
$repa = mysql_fetch_assoc(mysql_query("SELECT * FROM `repa_user` WHERE `id` = '".$id."'"));
$anks = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$repa['komy']."'"));

if($repa == 0) {
echo err($title, 'Данный ID в базе не найден!');
include ('../CGcore/footer.php'); exit;
}

if($user['level'] >= 1) {
mysql_query("DELETE FROM `repa_user` WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/reputation'.$anks['id'].'');
exit();
} else {
header('Location: '.$HOME.'/reputation'.$anks['id'].'');
exit();
}

echo '</div>';

break;
}

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>