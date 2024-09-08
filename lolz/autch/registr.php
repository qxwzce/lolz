<?
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

echo '<center><div class="icon_window">';

include '../CGcore/min-window-icon.gt';

echo '</div></center><br />';
echo '<center><div class="name_window" style="font-size: 15px; color: #d6d6d6;">Регистрация</div></center>';

echo '<title>Регистрация - '.$index['pod-title'].'</title>';
echo '<meta name="description" content="Регистрация - '.$index['pod-title'].'">';

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `settings` WHERE `id` = '1'"));

if($sql['reg_on'] == 1){
    
echo '<div class="menu"><center><span style="font-size: 50px;" class="icon"><i class="fas fa-exclamation-triangle"></i></span></br>Извините</br>Регистрация временно недоступна</center></div>';

include ('../CGcore/footer.php'); exit;
}

//-----Если жмут submit(кнопку)-----//
if(isset($_REQUEST['reg']))
{
//-----Фильтрируем перемменые-----//
$login = strong($_POST['login']);
//-----Проверка на ввод логина-----//

if(empty($login)){
echo err('<center>Вы не ввели логин!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверка на символы-----//
if (!preg_match('|^[a-z0-9\-]+$|i', $login)){
echo err('<center>Кириллица запрещена в логине!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверяем длину ввода-----//
if(mb_strlen($login) > 13 or mb_strlen($login) < 3){
echo err('<center>Введите логин от 3 до 13 символов!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверка на занятость логина-----//
$sql = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `login` = '".$login."'"); 
if(mysql_result($sql, 0) > 0){
echo '<div class="err" style="border-bottom: 0px; margin-top: 20px;"><center>Такой логин уже существует!</center></div>';
include ('../CGcore/footer.php'); exit;
}

//-----Фильтрируем перемменые-----//
$pass = strong($_POST['pass']);
//-----Проверка на ввод логина-----//
if(empty($pass)){
echo err('<center>Вы не ввели свой пароль!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверка на символы-----//
if (!preg_match('|^[a-z0-9\-]+$|i', $pass)){
echo err('<center>Кириллица запрещена в пароле!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверяем длину ввода-----//
if(mb_strlen($pass) > 25 or mb_strlen($pass) < 5){
echo err('<center>Введите пароль от 5 до 25 символов!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Фильтрируем перемменые-----//
$r_pass = strong($_POST['r_pass']);
//-----Если не одинаковые пароли-----//
if($pass != $r_pass){
echo err('<center>Пароли не одинаковые!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Фильтрируем перемменые-----//
$name = strong($_POST['name']);
//-----Проверка на ввод логина-----//
if(empty($name)){
echo err('<center>Вы не ввели своё имя!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверяем длину ввода-----//
if(mb_strlen($name) > 30 or mb_strlen($name) < 3){
echo err('<center>Введите своё имя от 3 до 30 символов!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Фильтрируем перемменые-----//
$sex = strong($_POST['sex']);
$email = strong($_POST['email']);

//-----Проверяем правильность ввода e-mail-----//
if (!preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $email)) {
echo err('<center>Формат email введён не верно!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Проверяем e-mail на занятость-----//
$sqlemail = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `email` = '".$email."'"); 
if (mysql_result($sqlemail, 0) > 0) {
echo err('<center>Такой email уже существует!</center>');
include ('../CGcore/footer.php'); exit;
}

//-----Если всё нормально-----//
mysql_query("INSERT INTO `users` SET `login` = '".$login."', `pass` = '".md5(md5(md5($pass)))."', `name` = '".$name."', `sex` = '".$sex."', `email` = '".$email."', `datareg` = '".time()."', `avatar` = 'net.png', `level` = '0', `max` = '10', `prev` = '0'");
//-----Вычесляем id-----//
$uid = mysql_insert_id();
//-----Если id 1 то ставим level 3-----//
if($uid == 1){
mysql_query("UPDATE `users` SET `level` = '3' WHERE `id` = '1'");
}
		
echo '<div class="ok" style="margin-top: 20px;"><center>Вы успешно зарегистрировались!</center></div>
<a class="link" href="'.$HOME.'/autolog.php?ulog='.$login.'&amp;upas='.$pass.'" style="margin-top: 10px; border: 1px solid #303030; border-radius: 7px;"><center>На главную</center></a>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
exit();
}

//-----Форма ввода-----//
echo '<div class="menu" style="border-bottom: 0px; padding-bottom: 0px;">';
echo '<form method="POST" action="">
<input placeholder="Логин" type="text" name="login" maxlength="13" /><br />
<input placeholder="Пароль" type="password" name="pass" maxlength="25" /><br />
<input placeholder="Повторите пароль" type="password" name="r_pass" maxlength="25" /><br />
<input placeholder="Имя" type="text" name="name" maxlength="30" /><br />
<select name="sex"><option value="1">Мужской</option><option value="2">Женский</option></select><br/>
<input placeholder="Email" type="text" name="email" maxlength="40" /><br /><br />
<center><input type="submit" name="reg" value="Создать аккаунт" style="margin-left: 3px; font-color: #d2d2d2; width: 175px; margin-top: 10px; margin-bottom: 0px; border-bottom: 0px;" /></center>
</form>';
echo '</div>';

//-----Подключаем низ-----//

include ('../CGcore/footer.php');

?>