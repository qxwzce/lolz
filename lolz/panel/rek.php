<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id'] or $user['level'] != 3) {
exit(header('Location: '.$HOME));
}

$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act)
{
default:

echo '<div class="title"><a href="'.$HOME.'/panel/">Админ панель</a> | '.$title.'</div>
<div class="menudiv"><a href="?act=add_rek" class="k_menu"> Добавить рекламную ссылку</div></a> ';


if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `ads`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$qwerty = mysql_query("SELECT * FROM `ads` ORDER BY `id` DESC LIMIT $start, $max");

while($sql = mysql_fetch_assoc($qwerty)){
    
$color = isset($sql['color']) ?  $sql['color'] : '#3c3c3c';
    
echo '<div class="podmenu">
<b>Название ссылки:';
 echo '<font color="'.$color.'">'; 
if($sql['b'] == 1) echo '<b>'; 
if($sql['i'] == 1) echo '<i>';
 echo $sql['name'];
if($sql['i'] == 1) echo '</i>';
if($sql['b'] == 1) echo '</b>'; 
 echo '</font>';
 
 
echo '<br />
<b>Ссылка (url):</b> <big><a href="'.$sql['url'].'">'.$sql['url'].'</a></big> <br/ >
<b>Время добавления:</b> <big>'.vremja($sql['kogda']).'</big> <br />';

if($sql['tip'] == 0) echo '<b>Расположение:</b> <big>Сверху</big> <br />';
if($sql['tip'] == 1) echo '<b>Расположение:</b> <big>Внизу</big> <br />';


if($sql['time_srok'] > time()) {
echo '<b>Истекает:</b> <big>'.vremja($sql['time_srok']).'</big>';
} else {
echo '<b>Истекло:</b> <big>'.vremja($sql['time_srok']).'</big>';
}
echo '</div>
<div class="links">
Действия: <a href="/panel/rek.php?act=set&id='.$sql['id'].'">Редактировать</a> | <a href="/panel/rek.php?act=del&id='.$sql['id'].'">Удалить</a>
</div>';
}

if($k_post < 1) echo '<div class="podmenu"><center><b>Пусто!</b></center></div>';
if($k_page>1) echo str(''.$HOME.'/panel/rek.php',$k_page,$page); // Вывод страниц


break;
case 'add_rek':

echo '<div class="title"><a href="'.$HOME.'/panel/rek.php">'.$title.'</a> | Добавить</div>';

if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$url = strong($_POST['url']);
$time_srok = strong($_POST['time_srok']);
$color = strong($_POST['color']);

$color = isset($_POST['color']) ?  strong($_POST['color']) : '#3c3c3c';
$b = isset($_POST['b']) ? abs(intval($_POST['b'])) : 0;
$i = isset($_POST['i']) ? abs(intval($_POST['i'])) : 0;
$tip = isset($_POST['tip']) ? abs(intval($_POST['tip'])) : 0;


$times = $time_srok * 86400;
$time_end = time() + $times;

if(empty($name)) {
echo err('Введите название рекламной ссылки!');
include ('../CGcore/footer.php'); exit;
}

if(empty($url)) {
echo err('Введите ссылку!');
include ('../CGcore/footer.php'); exit;
}

if(empty($time_srok)) {
echo err('Введите время активности ссылки!');
include ('../CGcore/footer.php'); exit;
}

if(!is_numeric($time_srok)) {
echo err('Вводить можно только цифры!');
include ('../CGcore/footer.php'); exit;
}

if(mb_strlen($name,'UTF-8') < 3 or mb_strlen($name,'UTF-8') > 30) {
echo err('Введите название рекламной ссылки от 3 до 30 символов!');
include ('../CGcore/footer.php'); exit;
}

$sql = mysql_fetch_array(mysql_query('select * from `ads` where  `name` = "'.$name.'" and `url` = "'.$url.'"'));
if($sql != 0) {
echo err('Такая рекламная ссылка уже есть!');
include ('../CGcore/footer.php'); exit;
}

mysql_query("INSERT INTO `ads` SET 
            `name` = '".$name."',
            `url` = '".$url."',
            `time_srok` = '".$time_end."',
            `kogda` = '".time()."',
            `color` = '".$color."',
            `b` = '".$b."',
            `i` = '".$i."',
            `tip` = '".$tip."'");
echo '<div class="podmenu"><center><b>Рекламная ссылка успешно добавлена!</b></center></div>';
}

echo '<div class="podmenu"><form action="" method="POST">
*Название ссылки: <br /> <input type="text" name="name" maxlength="30" /><br />
*Ссылка (с http://): <br /> <input type="text" name="url" maxlength="25" /><br />
*Время активности (в днях): <br /> <input type="text" name="time_srok" maxlength="3" /><br />
Цвет: <br />
<select name="color">
<option value="FF0000">Красный</option>
<option value="DC143C">Розовый</option>
<option value="FF4500">Оранжевый</option>
<option value="4B0082">Фиолетовый</option>
<option value="008000">Зелёный</option>
<option value="0000FF">Синий</option>
<option value="8B4513">Коричневый</option>
<option value="#FFD700">Золотой</option>
<option value="#CDC9C9">Серый</option>
<option value="#00B2EE">Голубой</option>
<option value="#C0FF3E">Салатный</option>
<option value="#000000">Черный</option>
<option value="#FFFAFA">Белый</option>
</select><br />
Расположение: <br />
<select name="tip">
<option value="0">Сверху</option>
<option value="1">Внизу</option>

</select><br />
Жирный: <input type="radio" name="b" value="1" /><br />
Курсив: <input type="radio" name="i" value="1" /><br />
<input type="submit" name="submit" value="Добавить">
</form></div>';

break;

case 'set':

$id = abs(intval($_GET['id']));
$rek = mysql_fetch_assoc(mysql_query("SELECT * FROM `ads` WHERE `id` = '".$id."'"));

if($rek == 0) {
header('Location: '.$HOME.'/panel/rek.php?act=rek_set');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/rek.php">'.$title.'</a> | Редактировать</div>';

if(isset($_REQUEST['submit'])) {

$name = strong($_POST['name']);
$url = strong($_POST['url']);
$time_srok = strong($_POST['time_srok']);


$times = $time_srok * 86400;
$time_end = time() + $times;

if(empty($name)) {
echo '<div class="podmenu"><center><b>Введите название рекламной ссылки!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(empty($url)) {
echo '<div class="podmenu"><center><b>Введите ссылку!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

if(mb_strlen($name) < 3 or mb_strlen($name) > 30) {
echo '<div class="podmenu"><center><b>Введите название рекламной ссылки от 3 до 30 символов!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}


mysql_query("UPDATE `ads` SET `name` = '".$name."', `url` = '".$url."', `time_srok` = '".$time_end."' WHERE `id` = '".$id."'");
echo '<div class="podmenu"><center><b>Информация обновлена!</b></center></div>';
}

 
$tm = ceil(($rek['time_srok'] - time()) / 86400); 

echo '<div class="podmenu"><form action="" method="POST">
*Название ссылки: <br /> <input type="text" name="name" value="'.$rek['name'].'" maxlength="30" /><br />
*Ссылка (url сайта): <br /> <input type="text" name="url" value="'.$rek['url'].'" maxlength="25" /><br />
*Время активности (в днях): <br /> <input type="text" name="time_srok" value="'.$tm.'" maxlength="3" /><br />
<input type="submit" name="submit" value="Добавить">
</form></div>';

break;
case 'del':

$id = abs(intval($_GET['id']));
$rek = mysql_fetch_assoc(mysql_query("SELECT * FROM `ads` WHERE `id` = '".$id."'"));

if($rek == 0) {
header('Location: '.$HOME.'/panel/rek.php?act=rek_set');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/panel/">Админ панель</a> | <a href="'.$HOME.'/panel/rek.php">'.$title.'</a> | Удалить</div>';

if(isset($_REQUEST['del'])) {
mysql_query("DELETE FROM `ads` WHERE `id` = '".$id."'");
header('Location: '.$HOME.'/panel/rek.php?act=rek_set');
exit();
}

echo '<div class="podmenu">Вы действительно хотите удалить это рекламное место?
<br />
<a href="'.$HOME.'/panel/rek.php?act=del&id='.$id.'&del">Да</a></div>';

break;
}

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>