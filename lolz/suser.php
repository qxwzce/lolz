<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<title>Поиск пользователей</title>';

echo '<div class="menu">Поиск пользователей</div>';

echo '<form method="post" action="suser.php?">';
echo '<div class="menu" style="border-bottom: 0px;">';
echo '<input placeholder="Введите ник" style="border-radius: 15px; margin-left: 5px; margin-right: 0px;" name="login" /><br />';
echo '<input type="submit" style="border-radius: 100px; margin-left: 3px;" name="ok" value="Найти" />';
echo '</form>';
echo '</div>';

if (isset($_REQUEST['ok'])){
    
$login = strong($_POST['login']);

if(empty($login) or mb_strlen($login) > 20) {
echo err('Ошибка ввода ,макс. 20 симв.');
include ('CGcore/footer.php'); exit;
}

$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `login` like '%".$login."%'"),0);
if ($k_post==0)
echo '<div class="podmenu"><center><font color="red">По вашему запросу ничего не найдено</font><center></div>';


$q = mysql_query("SELECT * FROM `users` WHERE `login` like '%".$login."%' ORDER BY id DESC");
while ($ank = mysql_fetch_array($q)){

echo '<a class="link">'.nick($ank['id']).'<span class="icon"><i class="fas fa-user-circle"></i></span> </a>
<div class="menu">Зарегистрирован: ('.vremja($ank['datareg']).')
<br/>Последнее посещение: '.vremja($ank['viz']).'</div>';
}

}

              
include ('CGcore/footer.php');
?>