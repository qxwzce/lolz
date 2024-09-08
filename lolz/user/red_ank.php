<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<title>Редактировать анкету</title>';

echo '<div class="navigationSideBar ToggleTriggerAnchor">

<div class="menuVisible">

<a class="selected" href="../user/red_ank.php">Персональная информация</a>
<a class="side_link" href="../Account/faq.php">F.A.Q</a>
<a class="side_link" href="../Account/security.php">Безопасность</a>
</div>
</div>';

echo '<div class="menu">Личный кабинет | Редактировать анкету</div>';

if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$strana = strong($_POST['strana']);
$gorod = strong($_POST['gorod']);
$osebe = strong($_POST['osebe']);
$stat = strong($_POST['stat']);
$skype = strong($_POST['skype']);
$icq = strong($_POST['icq']);
$url = strong($_POST['url']);
$sex = abs(intval($_POST['sex']));

$name = strong($_POST['name']);


$rating = $user['rating'];

if(!empty($_POST['name'])) {
if (($rating + 0.01) <= 0.01) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$strana = strong($_POST['strana']);
if(!empty($_POST['strana'])) {
if (($rating + 0.01) <= 0.02) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$gorod = strong($_POST['gorod']);
if(!empty($_POST['gorod'])) {
if (($rating + 0.01) <= 0.03) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$osebe = strong($_POST['osebe']);
if(!empty($_POST['osebe'])) {
if (($rating + 0.01) <= 0.04) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$stat = strong($_POST['stat']);
if(!empty($_POST['stat'])) {
if (($rating + 0.01) <= 0.05) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$skype = strong($_POST['skype']);
if(!empty($_POST['skype'])) {
if (($rating + 0.01) <= 0.06) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$icq = strong($_POST['icq']);
if(!empty($_POST['icq'])) {
if (($rating + 0.01) <= 0.07) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$url = strong($_POST['url']);
if(!empty($_POST['url'])) {
if (($rating + 0.01) <= 0.08) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}
$sex = strong($_POST['sex']);
if(!empty($_POST['sex'])) {
if (($rating + 0.01) <= 0.08) {
$rating = $rating + 0.01;
mysql_query("UPDATE `users` SET `rating` = '".$rating."' WHERE `id` = '".$user['id']."'");
}
}

mysql_query("UPDATE `users` SET `name` = '".$name."', `strana` = '".$strana."', `gorod` = '".$gorod."', `osebe` = '".$osebe."', `stat` = '".$stat."', `skype` = '".$skype."', `icq` = '".$icq."', `url` = '".$url."', `sex` = '".$sex."'WHERE `id` = '".$user['id']."'");

echo '<style>
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content{
margin: 65px 243px 15px 0px;
border-radius: 7px;
}
}
</style>';

echo '<div class="ok">Данные сохранены</div>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu" style="padding: 15px; font-color: #d6d6d6; border-bottom: 0px;">
<form action="" method="POST">
<div class="setting_punkt" style="display: inline-block;">Ник: <span class="nickname_user">'.nick($user['id']).'</span></div></br>';

if($user['prev'] == 0){ echo '<a class="log" href="https://hack-lair.com/user/us/new_nick.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px; display: inline-block; margin-top: 10px;">Изменить ник за 100 <b>₽</b></a></br><br />'; }
elseif($user['prev'] == 1){ echo '<a class="log" href="https://hack-lair.com/user/us/new_nick.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px; display: inline-block; margin-top: 10px;">Изменить ник</a></br><br />'; }
elseif($user['prev'] == 2){ echo '<a class="log" href="https://hack-lair.com/user/us/new_nick.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px; display: inline-block; margin-top: 10px;">Изменить ник</a></br><br />'; }



echo '<body style="font-size: 13px; color: #777;">Ник отображается в сообщениях и профиле, видим для всех, является логином для входа на сайт.</body><br /><br /><br />';

if($user['prev'] == 0){ echo '<a class="log" href="https://hack-lair.com/user/us/color_nick.php" style="border-radius: 6px; padding: 8px; background-color: #363636; padding-left: 15px; padding-right: 15px; font-size: 13px;">Сменить цвет ника за 100 <b>₽</b></a></br></br><hr>'; }
elseif($user['prev'] == 1){ echo '<a class="log" href="https://hack-lair.com/user/us/color_nick.php" style="border-radius: 6px; padding: 8px; background-color: #363636; padding-left: 15px; padding-right: 15px; font-size: 13px;">Сменить цвет ника</a></br></br><hr>'; }
elseif($user['prev'] == 2){ echo '<a class="log" href="https://hack-lair.com/user/us/color_nick.php" style="border-radius: 6px; padding: 8px; background-color: #363636; padding-left: 15px; padding-right: 15px; font-size: 13px;">Сменить цвет ника</a></br></br><hr>'; }

echo '<div class="setting_punkt">Фото профиля:</div></br><a class="log" href="https://hack-lair.com/user/avatar.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">Изменить аватар</a></br></br><hr>

<div class="ank_setting">
<a class="setting_punkt">Имя:<br /></a><input type="text" name="name" value="'.$user['name'].'" style="height: 9px;"/><hr>
<a class="setting_punkt">Страна:<br /></a><input type="text" name="strana" value="'.$user['strana'].'" style="height: 9px;"/><hr>
<a class="setting_punkt">Город:<br /></a><input type="text" name="gorod" value="'.$user['gorod'].'" style="height: 9px;"/><hr>
<a class="setting_punkt">Статус:<br /></a><input type="text" name="stat" value="'.$user['stat'].'" style="height: 9px;"/><hr>
<a class="setting_punkt">Сайт:<br /></a><input type="text" name="url" value="'.$user['url'].'" style="height: 9px;"/><hr>';
echo '<a class="setting_punkt">Пол:<br /></a><select name="sex">';
$dat = array('Мужской' => '1', 'Женский' => '2');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $up_us['sex'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}


echo '</select><br/>';
echo '<center><input type="submit" name="submit" value="Сохранить изменения" style="width: 175px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form></div>
</div>';

echo '<style>
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content{
margin: 65px 243px 15px 0px;
border-radius: 7px;
}
}
</style>';

echo '<div class="navigationSideBar_Mobile">

<div class="menuVisible_Mobile">

<a class="selected" href="../user/red_ank.php">Персональная информация</a>
<a class="side_link" href="../Account/faq.php">F.A.Q</a>
<a class="side_link" href="../Account/security.php">Безопасность</a>
</div>
</div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>