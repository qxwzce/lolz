<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if($user['level'] != 3) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}

echo '<div class="menu"><a href="'.$HOME.'/panel/">Админ панель</a> | Настройки баннера</div>';

if(isset($_REQUEST['okbanner'])) {

$name = strong($_POST['name']);
$des = strong($_POST['des']);
$cop = strong($_POST['cop']); 
$col = strong($_POST['col']);
$banner_active = abs(intval($_POST['b_on']));  


mysql_query("UPDATE `index` SET `banner-name` = '".$name."', `banner-desc` = '".$des."', `banner-foot` = '".$cop."', `banner-name-color` = '".$col."', `banner-active` = '".$banner_active."' WHERE `index`.`id` = '1'");
echo '<div class="menu"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<a class="link" href="?act=set" style="margin-top: 10px;">Вернуться назад</a>';
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `index` WHERE `id` = '1'"));

echo '<div class="menu">';

if (isset($_REQUEST['onbanner'])) {
mysql_query("UPDATE `index` SET `banner-active` = '0' WHERE `index`.`id` = '1'");

echo '<div class="ok"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<a class="link" href="?act=set" style="margin-top: 10px;">Вернуться назад</a>';
include ('../CGcore/footer.php'); exit;
}

if (isset($_REQUEST['offbanner'])) {
mysql_query("UPDATE `index` SET `banner-active` = '1' WHERE `index`.`id` = '1'");

echo '<div class="ok"><center><b>Изменения успешно сохранены!</b></center></div>';
echo '<a class="link" href="?act=set" style="margin-top: 10px;">Вернуться назад</a>';
include ('../CGcore/footer.php'); exit;
}


if($sql['banner-active'] == 0) {
echo '<form action="" method="POST">
<div class="menu" style="padding: 0px; margin-bottom: 10px; height: 30px;">Активность баннера:<input type="submit" name="offbanner" value="Выключить" style="width: 100px; float: right; margin: -7px 0px 0px 0px;"></div>
</form>';

} else {
	
echo '<form action="" method="POST">
<div class="menu" style="padding: 0px; margin-bottom: 10px; height: 30px;">Активность баннера:<input type="submit" name="onbanner" value="Включить" style="width: 100px; float: right; margin: -7px 0px 0px 0px;"></div>
</form>';
}

echo '<form action="?act=set&amp;ok=1" method="post">
Название баннера:<br /><input type="text" name="name" value="'.$sql['banner-name'].'" maxlength="500" /><br />
Цвет названия баннера:<br /><input type="text" name="col" value="'.$sql['banner-name-color'].'" maxlength="500" /><br />
Текст внутри баннера:<br /><textarea type="text" name="des" maxlength="5000" style="margin: 10px 0px;">'.$sql['banner-desc'].'</textarea>
Подпись баннера:<br /><input type="text" name="cop" value="'.$sql['banner-foot'].'" maxlength="50" /><br />';

echo '<input type="submit" name="okbanner" value="Сохранить" />';
echo '</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/panel/">Назад в админку</a></div>';

include ('../CGcore/footer.php');

