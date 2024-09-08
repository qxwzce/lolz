<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if (empty($_GET['ulog']) and empty($_GET['upas'])){
$login = strong($_POST['login']); //фильтрируем
$pass = md5(md5(md5(strong($_POST['pass'])))); //фильтрируем
} else {
$login = strong($_GET['ulog']);
$pass = md5(md5(md5(strong($_GET['upas']))));
}

$sql = mysql_query("SELECT `login` FROM `users` WHERE `login` = '".$login."' and `pass` = '".$pass."' LIMIT 1");
$dbsql = mysql_fetch_array(mysql_query("SELECT `login`,`pass` FROM `users` WHERE `login` = '".$login."' and `pass`='".$pass."' LIMIT 1"));

if(mysql_num_rows($sql)){	
setcookie('uslog', $dbsql['login'], time()+86400*365, '/');
setcookie('uspass', $pass, time()+86400*365, '/');
header('location: '.$HOME);
exit();

} else {

$title = 'Авторизация';

echo '<div class="title">Авторизация</div>';

if(empty($login)) {
echo err('Вы не ввели логин!');
include ('CGcore/footer.php'); exit;
}

if(mb_strlen($login) > 20 or mb_strlen($login) < 3) {
echo err('Введите логин от 3 до 20 символов!');
include ('CGcore/footer.php'); exit;
}

if(!preg_match('|^[a-z0-9\-]+$|i', $login)) {
echo err('Кириллица запрещена в логине!');
include ('CGcore/footer.php'); exit;
}

//-----Проверяем на ввод пароля-----//
if(empty($pass)) {
echo err('Вы не ввели свой пароль!');
include ('CGcore/footer.php'); exit;
}

if(mb_strlen($pass) < 5) {
echo err('Введите пароль от 5 символов!');
include ('CGcore/footer.php'); exit;
}

//-----Проверка на символы-----//
if(!preg_match('|^[a-z0-9\-]+$|i', $pass)) {
echo err('Кириллица запрещена в пароле!');
include ('CGcore/footer.php'); exit;
}

if(!empty($login) && !empty($pass)) if($dbsql==0) {
echo err('Такого пользователя не существует!');
include ('CGcore/footer.php'); exit;
}
}

?>