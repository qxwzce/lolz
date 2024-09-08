<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));


echo '<div class="menu">Личный кабинет | Смена почты</div>';

if(isset($_REQUEST['upsemail'])) {

$email = strong($_POST['email']);
$nee = strong($_POST['nee']);
$hp = strong($_POST['hp']))));

if(empty($hp) or empty($email)) {
echo err('Введите новую почту и пароль!');
include ('../CGcore/footer.php'); exit;
}

if($email != $nee){
echo err('Новая почта подтверждена неверно!');
include ('../CGcore/footer.php'); exit;
}

if (!preg_match('|^[a-z0-9\-]+$|i', $email)) {
echo err('Кириллица запрещена в новой почте!');
include ('../CGcore/footer.php'); exit;
}

if (!preg_match('|^[a-z0-9\-]+$|i', $hp)) {
echo err('Кириллица запрещена в пароле!');
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_assoc(mysql_query("SELECT `pass` FROM `users` WHERE `id` = '".$user['id']."'"));
if($sql['pass'] != $hp) {
echo err('Неверно введён пароль!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("UPDATE `users` SET `email` = '". $email."' WHERE `id` = '". $user['id']."' ");

echo '<div class="ok">Почта успешно изменена</div>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu" style="border-bottom: 0px;">
<form action="" method="POST">
<center><input placeholder="Новый email" type="text" name="ne" maxlength="25" /></center>
<center><input placeholder="пароль" type="text" name="hp" maxlength="25" /></center>
<center><input type="submit" name="upsemail" value="Изменить" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form>
</div></div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>