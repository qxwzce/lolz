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
header('Location: '.$HOME.'/them'.$user['id']); exit;
}

if($id == $user['id']) echo '<div class="menu">Мои темы</div>'; 
else echo '<div class="menu"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | Темы</div>';

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `us` = '".$ank['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$tema = mysql_query("SELECT * FROM `forum_tema` WHERE `us` = '".$ank['id']."' ORDER BY `id` DESC LIMIT $start, $max");

while($a = mysql_fetch_assoc($tema)){
echo '<title>Мои темы</title>';
include ('../CGcore/div-link-thems-info.gt');
}

if($k_post < 1) echo '<div class="menu" style="border-bottom: 0px;">Пользователь еще не создавал тем</div>';
if ($k_page>1) echo str(''.$HOME.'/them'.$id.'?',$k_page,$page); // Вывод страниц

break;
}

include ('../CGcore/footer.php');
?>