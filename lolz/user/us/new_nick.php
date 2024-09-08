<?
include ('../../CGcore/core.php');
include ('../../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="menu" style="color: #d6d6d6; font-size: 15px;">'.$title.'</div>';

if (isset($user) & $user['prev'] == 0 & $user['money']<=90){
echo "<div class='err'>Извините, но у вас не хватает денег для смены ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>";
include ('../../CGcore/footer.php');
exit();
}
elseif($user['prev'] == 1 & $user['money']<=0){ echo '<div class="err" style="display: none;">Извините, но у вас не хватает денег для смены ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>'; }
elseif($user['prev'] == 2 & $user['money']<=0){ echo '<div class="err" style="display: none;">Извините, но у вас не хватает денег для смены ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>'; }


if (isset($_POST['submit'],$_POST['login']))
{
$login = mysql_real_escape_string($_POST['login']);

$sql = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `login` = '".$login."'"); 
if(mysql_result($sql, 0)){
echo err('Этот ник уже занят!');
include ('../../CGcore/footer.php'); exit;
}

if (!preg_match('|^[a-z0-9\-]+$|i', $login)){
echo err('Кириллица запрещена в логине!');
include ('../../CGcore/footer.php'); exit;
}

if($user['prev'] == 0) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-100)."' WHERE `id` = '$user[id]' LIMIT 1"); }
elseif($user['prev'] == 1) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-0)."' WHERE `id` = '$user[id]' LIMIT 1"); }
elseif($user['prev'] == 2) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-0)."' WHERE `id` = '$user[id]' LIMIT 1"); }
mysql_query("UPDATE `users` SET `login` = '". $login ."' WHERE `id` = '". $user['id'] ."' LIMIT 1");

if (isset($_COOKIE['uslog']) and isset($_COOKIE['uspass'])) 
setcookie('uslog', $login, time()+86400*365, '/');

if($user['prev'] == 0) { echo '<div class="ok">Ваш ник успешно изменен, теперь он будет использоваться для входа на сайт. С вас списано 100 ₽. <br /></div>'; }
elseif($user['prev'] == 1) { echo '<div class="ok">Ваш ник успешно изменен, теперь он будет использоваться для входа на сайт.</div>'; }
elseif($user['prev'] == 2) { echo '<div class="ok">Ваш ник успешно изменен, теперь он будет использоваться для входа на сайт.</div>'; }
include ('../../CGcore/footer.php');
}

if($user['prev'] == 0) { echo '<div class="menu">Вы можете сменить ник за <b>100</b> ₽, Кириллица запрещена.</div>'; }
elseif($user['prev'] == 1) { echo '<div class="menu">Вы можете бесплатно сменить ник. Кириллица запрещена.</div>'; }
elseif($user['prev'] == 2) { echo '<div class="menu">Вы можете бесплатно сменить ник. Кириллица запрещена.</div>'; }

echo '<div class="menu" style="border-bottom: 0px;"><form action="" method="POST">
<input placeholder="Новый ник" type="text" maxlength="13" name="login" value="'.$user['login'].'"/>
<center><input type="submit" name="submit" value="Сменить" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
</form></div>';

include ('../../CGcore/footer.php');
?>