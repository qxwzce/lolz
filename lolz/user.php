<?
include ('CGcore/core.php');
include ('CGcore/head.php');

echo '<title>Все пользователи</title>';

if(!isset($user['id'])) {
echo err($title, '
Уважаемый посетитель, Вы зашли на сайт как незарегистрированный пользователь.<br/>
Мы рекомендуем Вам зарегистрироваться либо войти на сайт под своим именем.
');
include ('CGcore/footer.php'); exit;
}

$act = isset($_GET['act']) ? $_GET['act'] : null;

switch($act) {
default:
echo '<div class="title_st-gt">Все пользователи</div>';

$users = mysql_query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1");

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$users = mysql_query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($users)){

$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['id']."'"));
echo '<table class="div-link" role="link" id="cont_tem" cellspacing="0" cellpadding="0" data-href="user_'.$ank['id'].'">';
echo '<td style="width: 65px;">';
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png" style="height: 50px; width: 50px;">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'" style="height: 50px; width: 50px;">');
echo '</td>';
echo '<td class="block_content">';
echo '<span class="nick_user" style="pointer-events: none;">'.nick($a['id']).'</span></br>';
$p_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '$ank[id]'"),0);
echo 'Постов в форуме: <span class="num-indi">'.$p_forum.'</span></br>';
$t_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '$ank[id]'"),0);
echo 'Тем в форуме: <span class="num-indi">'.$t_forum.'</span>';
echo '</td>';
echo '</table>';

}

if ($k_page>1) echo str('/user.php?',$k_page,$page); // Вывод страниц

break;
case 'online':

echo '<div class="title">Онлайн</div>';


if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `viz` > '".(time()-360)."'"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;


$users = mysql_query("SELECT * FROM `users` where `viz` > '".(time()-360)."' ORDER BY `viz` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($users)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';
echo '<td style="width: 75px;">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['id']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '<td style="border-right: 100px;">';
echo '</td>';
echo '<td class="block_content">';
echo ''.nick($a['id']).'</br>';
$p_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '$ank[id]'"),0);
echo "Постов в форуме: $p_forum</br>";
$t_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '$ank[id]'"),0);
echo "Тем в форуме: $t_forum";
echo '</td>';
echo '</table>';

}

if ($k_page>1)echo str('/online.php?',$k_page,$page); // Вывод страниц

break;
case 'adm':

echo '<div class="title">Администрация</div>';


if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `level` >= '1' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$users = mysql_query("SELECT * FROM `users` where `level` >= '1' ORDER BY `viz` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($users)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';
echo '<td style="width: 60px;">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['id']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';
echo ''.nick($a['id']).'  <span class="time">'.vremja($a['viz']).'</span></br>';
if($ank['level'] == 1){  echo '<font color="ffffff" style="background-color: #658e5b; padding-left: 5px; padding-right: 5px; padding-top: 3px; padding-bottom: 3px; border-radius: 5px; font-size: 11px; margin-top: 5px;">Модератор</font>';}
elseif($ank['level'] == 2){ echo '<font color="ffffff" style="background-color: #517e94; padding-left: 5px; padding-right: 5px; padding-top: 3px; padding-bottom: 3px; border-radius: 5px; font-size: 11px; margin-top: 5px;">Администратор</font>';}
elseif($ank['level'] == 3){ echo '<font color="ffffff" style="background-color: #e06b6b; padding-left: 5px; padding-right: 5px; padding-top: 3px; padding-bottom: 3px; border-radius: 5px; font-size: 11px; margin-top: 5px;">Директор</font>';}
echo '</td>';
echo '</table>';

}


if ($k_page>1)echo str('/administration.php?',$k_page,$page); // Вывод страниц

break;




case 'verified':

echo '<div class="title">Проверенные</div>';


if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `level` >= '1' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;

$users = mysql_query("SELECT * FROM `users` where `verified` >= '1' ORDER BY `viz` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($users)){

echo '<table class="menu" cellspacing="0" cellpadding="0">';
echo '<td style="width: 75px;">';
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['id']."'"));
echo (empty($ank['avatar'])?'<img class="avatar" src="/files/ava/net.png">':'<img class="avatar" src="/files/ava/'.$ank['avatar'].'">');
echo '</td>';
echo '<td class="block_content">';
echo ''.nick($a['id']).'</br>';
$p_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_post` WHERE `us` = '$ank[id]'"),0);
echo "Постов в форуме: $p_forum</br>";
$t_forum=mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '$ank[id]'"),0);
echo "Тем в форуме: $t_forum";
echo '</td>';
echo '</table>';

}


if ($k_page>1)echo str('/administration.php?',$k_page,$page); // Вывод страниц

break;
}

//-----Подключаем низ-----//
include ('CGcore/footer.php');
?>