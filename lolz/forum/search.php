<?

include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<title>Поиск по форуму</title>';
echo '<meta name="description" content="Поиск тем и пользователей форума">';

if(!$user['id']) {
header('Location: '.$HOME.'');
exit();
}
echo'<div class="title">Поиск по форуму</div>';

echo '<div class="menu">';
echo '<form method="post" action="">';
echo '<center><input placeholder="Что ищем?" type="text" name="tema" id="search" /></center>';
echo '<center><input type="submit" name="ok" value="Найти" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>';
echo '</form>';
echo '</div>';

if (isset($_REQUEST['ok'])){
    
$tema = strong($_POST['tema']);
if(empty($tema) or mb_strlen($tema) > 20) {
include ('../CGcore/footer.php'); 
exit;
}

$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum_tema` WHERE `name` like '%".strong($tema)."%'"),0);
if ($k_post==0){
echo '<div class="err" style="background: none; border-radius: 0px; color: #d6d6d6; border-bottom: 1px solid #2d2d2d; padding: 5px 10px; margin-bottom: 10px;">По вашему запросу ничего не найдено</div>';
}else{
echo'<div class="ok" style="background: none; border-radius: 0px; color: #d6d6d6; border-bottom: 1px solid #2d2d2d; padding: 5px 10px; margin-bottom: 10px;">По запросу <b>#'.strong($tema).'</b> найдены следующие результаты:</div>';
}

$q = mysql_query("SELECT * FROM `forum_tema` WHERE `name` like '%".strong($tema)."%' ORDER BY `time` DESC");
while ($a = mysql_fetch_array($q)){
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['us']."' LIMIT 1"));

include ('../CGcore/div-link-thems-info.gt');

}
}

include ('../CGcore/footer.php');
?>