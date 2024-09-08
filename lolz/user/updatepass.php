<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="menu"><a href="'.$HOME.'/user/cab.php">Личный кабинет</a> | Смена пароля</div>';

if(isset($_REQUEST['upspass'])) {

$np = strong($_POST['np']);
$npp = strong($_POST['npp']);
$hp = md5(md5(md5(strong($_POST['hp']))));

if(empty($hp) or empty($np)) {
echo err('Введите старый и новый пароль!');
include ('../CGcore/footer.php'); exit;
}

if($np != $npp){
echo err('Новый пароль подтвержден неверно!');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($hp) < 3 or mb_strlen($np) < 3) {
echo err('Введите старый и новый пароль от 3 символов!');
include ('../CGcore/footer.php'); exit;
}

if (!preg_match('|^[a-z0-9\-]+$|i', $np)) {
echo err('Кириллица запрещена в новом пароле!');
include ('../CGcore/footer.php'); exit;
}

if (!preg_match('|^[a-z0-9\-]+$|i', $hp)) {
echo err('Кириллица запрещена в старом пароле!');
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_assoc(mysql_query("SELECT `pass` FROM `users` WHERE `id` = '".$user['id']."'"));
if($sql['pass'] != $hp) {
echo err('Неверно введён старый пароль!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("UPDATE `users` SET `pass` = '".md5(md5(md5($np)))."' WHERE `id` = '".$user['id']."'");

if (isset($_COOKIE['uslog']) and isset($_COOKIE['uspass'])) 
setcookie('uspass', md5(md5(md5($np))), time() + 86400*31, '/'); 

echo '<div class="ok">Пароль успешно изменен</div>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu" style="border-bottom: 0px;">
<form action="" method="POST">
<input placeholder="Старый пароль" type="text" name="hp" maxlength="25" /><br />
<input placeholder="Новый пароль" type="text" name="np" maxlength="25" /><br />
<input placeholder="Повторите новый пароль" type="text" name="npp" maxlength="25" /><br />
<center><input type="submit" name="upspass" value="Изменить" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form>
</div></div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>