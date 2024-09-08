<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

if (isset($_REQUEST['okpay'])) {

if($user['money'] < $index['cena-allcoin']){
echo err('Недостаточно средств на балансе');
include ('../CGcore/footer.php'); exit;
} 

mysql_query("UPDATE `index` SET `cena-allcoin` = `cena-allcoin` / 1.2 WHERE `index`.`id` = '1'");
mysql_query("UPDATE `users` SET `allcoin` = `allcoin` + 1 WHERE `id` = '".$user['id']."'");
mysql_query("UPDATE `users` SET  `money` =  `money` - ".$index['cena-allcoin']." WHERE  `id` = '".$user['id']."'");

echo '<div class="ok"><center><b>АллКойны приобретены!</b></center></div>';
echo '<a class="link" href="?act=set" style="margin-top: 10px;">Вернуться назад</a>';
include ('../CGcore/footer.php'); exit;
}


if (isset($_REQUEST['okcell'])) {

if($user['allcoin'] < 1){
echo err('Недостаточно АллКойнов на балансе');
include ('../CGcore/footer.php'); exit;
}

mysql_query("UPDATE `users` SET `allcoin` = `allcoin` - 1 WHERE `id` = '".$user['id']."'");
mysql_query("UPDATE `users` SET  `money` =  `money` + ".$index['cena-allcoin']." WHERE  `id` = '".$user['id']."'");
mysql_query("UPDATE `index` SET `cena-allcoin` = `cena-allcoin` * 1.7 WHERE `index`.`id` = '1'");

echo '<div class="ok"><center><b>АллКойны проданы!</b></center></div>';
echo '<a class="link" href="?act=set" style="margin-top: 10px;">Вернуться назад</a>';
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu">';
echo '<center><div class="menu" style="color: #ff6; font-weight: 600; font-size: 20px; padding-top: 0px;">'.$index['cena-allcoin'].' ₽</div></center>';

echo '<form action="?act=set&amp;ok=1" method="post">';
echo '<input type="submit" name="okpay" value="Купить" />';
echo '<input type="submit" name="okcell" value="Продать" />';
echo '</form></div>';

echo '<center><div class="menu">Ваши АллКойны: '.$user['allcoin'].'</div></center>';

echo '</div>';

include ('../CGcore/footer.php');
?>