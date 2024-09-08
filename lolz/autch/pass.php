<?
$title = 'Восстановление пароля';
include ('../CGcore/core.php');
include ('../CGcore/head.php');
if(isset($user['id'])){
header('Location: /');
exit();
}
echo '<style>
.content {
margin: 60px 10px 0px 10px;
padding: 50px 40px;
max-width: 350px;
box-sizing: border-box;
}
@media all and (min-width: 368px){ 
#sidebar {
	display: none;
}
.content {
margin: 60px auto;
}
</style>';

if(isset($_REQUEST['true']))
{
$login = strong($_POST['login']);
if(empty($login))
{
echo err('<center>Вы не ввели логин!</center>');
include ('../CGcore/footer.php'); exit;
}
if(mb_strlen($login) > 20 or mb_strlen($login) < 3)
{
echo err('<center>Введите логин от 3 до 20 символов!</center>');
include ('../CGcore/footer.php'); exit;
}
if (!preg_match('|^[a-z0-9\-]+$|i', $login))
{
echo err('<center>Кириллица запрещена в логине!</center>');
include ('../CGcore/footer.php'); exit;
}

$email = strong($_POST['email']);
if(empty($email))
{
echo err('<center>Вы не ввели свой e-mail!</center>');
include ('../CGcore/footer.php'); exit;
}
//-----Проверяем правильность ввода e-mail-----//
if (!preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $email)) {
echo err('<center>Формат e-mail введён не верно!</center>');
include ('../CGcore/footer.php'); exit;
}
$sqldb = mysql_fetch_array(mysql_query("SELECT `login`,`email` FROM `users` WHERE `login` = '".$login."' and `email`='".$email."' LIMIT 1"));
if(!empty($login) && !empty($email)) if($sqldb == 0){
echo err('<center>Введенные данные не верны!</center>');
include ('../CGcore/footer.php'); exit;
}
$rou = rand(1000000000,5000000000);
mysql_query("UPDATE `users` SET `pass` = '".md5(md5(md5($rou)))."' WHERE `login` = '".$login."'");

echo '<center><div class="icon_window">';

include '../CGcore/min-window-icon.gt';

echo '</div></center><br />';
echo '<center><div class="name_window" style="font-size: 15px; color: #d6d6d6;">Восстановление</div></center>';
echo '<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<center><div class="menu" style="border-bottom: 0px; background: #2d2d2d; border-radius: 7px;">На ваш e-mail<br /><span class="eml" style="color: #fc3e27;">'.$email.'</span><br />было отправлено письмо с вашими регистрациоными данными!</div></center>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
$title = $_SERVER['HTTP_HOST'];

$msg = '
<html>
<head>
<img src="https://hack-lair.com/design/lg.png"></img><br />
<table bradius=15 bgcolor=#2d2d2d border=0 cellpadding=10 color=#fff>
</table>
</head>
<body>
<div class="hello" style="border-radius: 15px;">
<table bradius=15 bgcolor=#2a2a2a border=0 cellpadding=10>
<b>Здравствуйте '.$login.'!</b><br /><br />
Вами (или нет) была произведена операция по восстановлению пароля на сайте hack-lair.com
<br />
Ваши данные для входа в аккаунт:<br />
<br /><hr><br />
<b>Логин: '.$login.' </b><br /><br />
<b>Пароль: '.$rou.' </b><br /><br /><hr><br />
Пароль сгенерирован автоматически, просим вас сменить его после авторизации.
</html>';
$mail.= "hack-lair.com";
$headers.= "MIME-version: 1.0\n";
$headers.= "Content-type: text/html; charset= iso-8859-1\n";
$sets = 'info@'.$mail;
$adds = "From: <" . $sets . ">\r\n";
$adds .= "Content-Type: text/html; charset=\"utf-8\"\r\n";

mail($email, '=?utf-8?B?'.base64_encode('Восстановление пароля').'?=', $msg, $adds);
session_destroy();
exit();
}
//-----Форма ввода-----//
echo '<center><div class="icon_window">';

include '../CGcore/min-window-icon.gt';

echo '</div></center><br />';
echo '<center><div class="name_window" style="font-size: 15px; color: #d6d6d6;">Восстановление</div></center>';
echo '<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<form action="" method="POST">
<center><input placeholder="Логин" type="text" name="login" maxlength="20" /></center>
<center><input placeholder="Email" type="text" name="email" maxlength="40" /></center><br />
<center><input type="submit" name="true" value="Продолжить" style="margin-left: 3px; font-color: #d2d2d2; width: 175px; margin-top: 10px; margin-bottom: 0px; border-bottom: 0px;" /></center>
</form>';
echo '</div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');

?>