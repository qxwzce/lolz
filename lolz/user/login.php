<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(isset($user['id'])) {
header('Location: ');
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

echo '<center><div class="icon_window">';

include '../CGcore/min-window-icon.gt';

echo'</div></center><br />';
echo '<center><div class="name_window" style="font-size: 15px; color: #d6d6d6;">Авторизация</div></center>';

##############################
####### Главная ###### #######
##############################
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act)
{
default:

echo '<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<title>Авторизация</title>';
echo '<meta name="description" content="Страница авторизации пользователя">';
echo '
<form action="?act=true" method="POST">
<center><input placeholder="Логин" type="text" name="login" maxlength="20" /></center>
<center><input placeholder="Пароль" type="password" name="pass" maxlength="25"/></center><br />
<center><input type="submit" value="Войти" style="margin-left: 3px; font-color: #d2d2d2; width: 175px; margin-top: 10px; margin-bottom: 0px; border-bottom: 0px;"></center><br /><center><a class="pass_rec_but" href="/autch/pass.php" style="color: #c33929;">Забыли пароль</a></center><br />
</form>';
echo '</div>';

echo '<center><a class="link" href="/autch/registr.php" style="border: solid 1px #303030; border-radius: 7px; max-width: 155px;">Создать аккаунт</a></center>';

break;
##############################
####### Кейс проверки ########
##############################
case 'true':

//-----Фильтрируем переменную-----//
$onepass = strong($_POST['pass']);
$login = strong($_POST['login']);

if(empty($login)) {
echo err('<center>Вы не ввели логин!</center>');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($login) > 20 or mb_strlen($login) < 3) {
echo err('<center>Введите логин от 3 до 20 символов!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверка на символы-----//
if (!preg_match('|^[a-z0-9\-]+$|i', $login)) {
echo err('<center>Кириллица запрещена в логине!</center>');
include ('../CGcore/footer.php'); exit;
}

$pass = md5(md5(md5(strong($_POST['pass'])))); //фильтрируем и в мд5

//-----Проверяем на ввод пароля-----//
if(empty($pass)){
echo err('<center>Вы не ввели свой пароль!</center>');
include ('../CGcore/footer.php'); exit;
}

if(!empty($pass)){
echo err('<center>Введен неверный пароль!</center>');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($pass) < 5) {
echo err('<center>Введите пароль от 5 символов!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверка на символы-----//
if (!preg_match('|^[a-z0-9\-]+$|i', $pass)) {
echo err('<center>Кириллица запрещена в пароле!</center>');
include ('../CGcore/footer.php'); exit;
}

$dbsql = mysql_fetch_array(mysql_query("SELECT `login`,`pass` FROM `users` WHERE `login` = '".$login."' and `pass`='".$pass."' LIMIT 1"));
if(!empty($login) && !empty($pass)) if($dbsql==0) {
echo err('<center>Такого пользователя не существует!</center>');
include ('../CGcore/footer.php'); exit;
}

header('Location:'.$HOME.'/autolog.php?ulog='.$login.'&upas='.$onepass.'');
session_start();
$_SESSION['newEl'] = 'value';
if(!empty($_POST)){
    $_SESSION['login'] = $_POST['login'];
}
echo '<div class="menu">
<b>Вы успешно авторизировались!</b>
</div>
<div class="podmenu">Ваш автологин:<br />
<textarea>'.$HOME.'/autolog.php?ulog='.$login.'&upas='.$onepass.'</textarea>
</div>
<div class="podmenu"><a href="'.$HOME.'/autolog.php?ulog='.$login.'&amp;upas='.$onepass.'"><b>На главную</b></a></div>';

include ('../CGcore/footer.php');
exit();

break;
}

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>