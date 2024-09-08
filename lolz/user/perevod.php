<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

$id = abs(intval($_GET['id']));
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."'"));

if($ank == 0) $err = '<b>Такого пользователя не существует!</b>';
if($id == $user['id']) $err = '<b>Вы не можете самому себе перевести деньги</b>';
if($user['money'] == 0) $err = '<b>Недостаточно средств на балансе</b>';

if($err) {
echo err($title, $err);
include ('../CGcore/footer.php'); exit;
} 

echo '<title>Перевод</title>';

echo '<div class="menu"><a href="'.$HOME.'/user_'.$id.'">Анкета '.$ank['login'].'</a> | Перевод</div>';

if(isset($_POST['summ'])){
    
$summ = abs(intval($_POST['summ']));
if(empty($summ)) {
echo err('Вы не ввели сумму перевода!');
include ('../CGcore/footer.php'); exit;
}

if($user['money'] < $summ){
echo err('Недостаточно средств на балансе');
include ('../CGcore/footer.php'); exit;
} 
 
mysql_query("UPDATE `users` SET `money` = `money` + ".$summ." WHERE `id` = '".$id."'");
mysql_query("UPDATE `users` SET  `money` =  `money` - ".$summ." WHERE  `id` = '".$user['id']."'");

echo '<div class="ok">Перевод успешно выполнен</div>';
include ('../CGcore/footer.php'); exit;
}
echo '<div class="menu" style="border-bottom: 0px;">';
echo '<form action="" method="POST">
Сумма превода:<br/>
<input type="text" name="summ" /> <br />
<center><input type="submit" name="submit" value="Перевести" style="margin-left: 3px; font-color: #d2d2d2; width: 175px; margin-top: 10px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form>
</div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>