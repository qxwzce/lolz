<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

$act = isset($_GET['act']) ? strong($_GET['act']) : null;
switch($act)
{
default:

echo '<title>Уведомления</title>';

echo '<description>Мои уведомления | Халява, скрипты, схемы заработка, сливы, торговля, скам проекты, общение, чат, социальная инженерия, сливы LolzTeam. А также множество других услуг предоставлены только на нашем форуме GROVE!</description>';

echo '<div class="menu">Уведомления</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `lenta` WHERE `komy` = '".$user['id']."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$lenta = mysql_query("SELECT * FROM `lenta` WHERE `komy` = '".$user['id']."' ORDER BY `time` DESC LIMIT $start, $max");
while($l = mysql_fetch_assoc($lenta)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$l['kto']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';

echo ''.nick($l['kto']).' <span class="time2">'.vremja($l['time']).'</span> <div class="block_msg" style="font-size: 13px;">'.bb($l['text']).'</div>';
if($l['readlen'] == 0) echo ' <img src="'.$HOME.'/images/readlen.png">';

echo '</td>';
echo '</table>';

mysql_query("UPDATE `lenta` SET `readlen` = '1' WHERE `id`='".$l['id']."' limit 1");

}

if($k_post < 1) echo '<div class="menu"><center><b>Пока пусто!</b></center></div>';
if($k_page>1) echo str(''.$HOME.'/lenta/?',$k_page,$page); // Вывод страниц

break;
case 'dellenta':

if(isset($_REQUEST['okda'])) {
mysql_query("DELETE FROM `lenta` WHERE `komy` = '".$user['id']."'");
header('Location: '.$HOME.'/lenta');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/lenta/">Лента</a> | Удалить Всё</div>
<div class="menu">Вы действительно хотите удалить все уведомления?<br /><br /><a href="'.$HOME.'/lenta/dellenta/?okda" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin-top: 5px;">Да</a><a href="'.$HOME.'/lenta" style="background-color: #228e5d; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; border-radius: 7px; margin: 5px;">Нет</a></div>';

break;
}

echo '<a class="link" href="/lenta/dellenta/"><span class="icon"><i class="far fa-trash-alt"></i></span> Очистить</a>';

//-----Подключаем вверх-----//
include ('CGcore/footer.php');
?>