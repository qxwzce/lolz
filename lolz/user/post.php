<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

$act = isset($_GET['act']) ? strong($_GET['act']) : "";
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : "";
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

switch($act){
default:

if($ank == 0) {
header('Location: '.$HOME.'/post'.$user['id']); exit;
}

if($id == $user['id']) echo '<div class="title">Мои посты</div>'; 
else echo '<div class="title"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | Посты</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '".$ank['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$post = mysql_query("SELECT * FROM `forum_post` WHERE `us` = '".$ank['id']."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($post)){

echo '<title>Посты</title>';

echo '<table class="menu" cellspacing="0" cellpadding="0">';

echo '<td class="block_avatar">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['us']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';
echo ''.nick($a['us']).' <span class="time">'.vremja($a['time']).'</span>';
echo '<div class="block_msg">'.nl2br(smile(bb($a['text']))).'</div>
<a class="but_friend" href="/forum/tema'.$a['tema'].'">Перейти в тему</a>';
echo '</td>';
echo '</table>';

}

if($k_post < 1) echo '<div class="menu" style="border-bottom: 0px;">Пользователь еще не оставлял постов</div>';
if ($k_page>1) echo str(''.$HOME.'/post'.$id.'?',$k_page,$page); // Вывод страниц

break;
}

include ('../CGcore/footer.php');
?>