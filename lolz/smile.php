<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if(!$user['id']) {
header('Location: /index.php');
exit();
}

switch($_GET['act'])
{
default:

echo '<div class="title">Смайлы</div>';

if($user['level'] >= 3) {
echo '<a class="link" href="'.$HOME.'/smile/addpapka"><span class="icon"><i class="fas fa-plus"></i></span> Новая папка</a>';
}

if (empty($user['max'])) $user['max']=10;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `smile_p`"),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$s_p = mysql_query("SELECT * FROM `smile_p` ORDER BY `id` DESC LIMIT $start, $max");
while($s = mysql_fetch_assoc($s_p))
{
echo '<a class="link" href="'.$HOME.'/smile/r_'.$s['id'].'"><span class="icon"><i class="far fa-smile"></i></span> '.$s['name'].' <span class="c">'.mysql_result(mysql_query("SELECT COUNT(id) FROM `smile` WHERE `papka` = '".$s['id']."'"),0).'</span></a>';
}

if($k_post < 1) {
echo '<div class="menu">Папок пока нет</div>';
}

if ($k_page>1) {
echo str('/smile/?',$k_page,$page); // Вывод страниц
}

break;
case 'addpapka':

if($user['level'] < 3) {
header('Location: '.$HOME.'/smile.php');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/smile/">Смайлы</a> | Новая папка</div>';

if(isset($_REQUEST['ok'])) {

$name = strong($_POST['name']);

if(empty($name)) {
echo '<div class="menu">Введите название папки</div>';
include ('CGcore/footer.php');
exit();
}

if(mb_strlen($name) > 30 or mb_strlen($name) < 3) {
echo '<div class="menu"><center><b>Введите название папки от 3-х до 30-ти символов!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

$ttte = mysql_fetch_array(mysql_query('select * from `smile_p` where `name` = "'.$name.'"'));
if($ttte != 0) {
echo '<div class="menu"><center><b>Такая папка уже существует!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

mysql_query("INSERT INTO `smile_p` SET `name` = '".$name."'");
echo '<div class="menu"><center><b>Папка успешно создана!</b></center></div>';
}
echo '<div class="menu">Укажите название папки для сохранения смайлов!</div>
<div class="menu"><form action="" method="POST">
*Название:<br /><input type="text" name="name" maxlength="30" /><br />
<input type="submit" name="ok" value="Создать" />
</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/smile/">Назад к смайлам</a></div>';

break;
case 'r':

$id = abs(intval($_GET['id']));
$smile = mysql_fetch_assoc(mysql_query("SELECT * FROM `smile_p` WHERE `id` = '".$id."'"));

if($smile == 0) {
echo '<div class="title">Смайлы| Ошибка</div>
<div class="menu"><center><b>Такой папки не существует!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/smile.php">Смайлы</a> | '.$smile['name'].'</div>';
if($user['level'] == 3)
{
echo '<a class="link" href="'.$HOME.'/smile/newsmile_'.$smile['id'].'"><span class="icon"><i class="fas fa-plus"></i></span> Добавить смайл</a>';
}
$sm = mysql_query("SELECT * FROM `smile` WHERE `papka` = '".$smile['id']."' ORDER BY `id` DESC");
while($s = mysql_fetch_assoc($sm))
{
echo '<div class="menu">'.$s['name'].' - <img src="'.$HOME.'/files/smile/'.$s['icon'].'" alt="'.$s['icon'].'" /></div>';
}

break;
case 'newsmile':

$id = abs(intval($_GET['id']));
$smile = mysql_fetch_assoc(mysql_query("SELECT * FROM `smile_p` WHERE `id` = '".$id."'"));

if($smile == 0) {
echo '<div class="title">Смайлы| Ошибка</div>
<div class="menu"><center><b>Такой папки не существует!</b></center></div>';
include ('CGcore/footer.php');
exit();
}	

if($user['level'] != 3) {
header('Location: '.$HOME.'/smile/');
exit();
}

echo '<div class="title"><a href="'.$HOME.'/smile/">Смайлы</a> | Новый смайл</div>';

if(isset($_REQUEST['ok'])) {

$name = strong($_POST['name']);

$ttte = mysql_fetch_array(mysql_query('select * from `smile` where `name` = "'.$name.'"'));
if($ttte != 0) {
echo '<div class="menu"><center><b>Такая смайл уже существует!</b></center></div>';
include ('CGcore/footer.php');
exit();
}

$maxsize = 1; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

/* Если не выбрали файл */
if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo '<div class="menu"><center><b>Вы не выбрали файл!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

/* Максимальный размер 1мб */
if ($size > (1048576 * $maxsize)) {
echo '<div class="menu"><center><b>Максимальный размер файла '.$maxsize.'мб!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

/* Тип файлов которые можно загружать */
$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ); 
$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 
  
/* Если тип файла не подходит */
if(!in_array($upfiletype,$filetype)) {
echo '<div class="menu"><center><b>К загрузке разрешены файлы форматом JPG,GIF,PNG,JPEG,BMP!</b></center></div>';
include ('../CGcore/footer.php');
exit();
}

/* Если все окей,заливаем файл в папу и делаем запрос */
$files = 'files_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 

/* Заливаем */
move_uploaded_file($_FILES['filename']['tmp_name'], "files/smile/".$files.""); 

/* Делаем запрос */

mysql_query("INSERT INTO `smile` SET `name` = '".$name."', `icon` = '".$files."', `papka` = '".$smile['id']."'");
echo '<div class="menu"><center><b>Новый смайл добавлен!</b></center></div>';
}

echo '<div class="menu">К загрузке допускаются фотографии форматом JPG,GIF,PNG,JPEG,BMP!</div>
<div class="menu"><form action="" method="post" enctype="multipart/form-data">
*Название:<br /><input type="text" name="name" maxlength="30" /><br /> 
Выберите файл:<br><input type="file" name="filename"/><br>   
<input type="submit" value="Загрузить" name="ok"/> 
</form></div>';

echo '<div class="menu">» <a href="'.$HOME.'/smile/r_'.$smile['id'].'">Назад в папку</a></div>';

break;
}

include ('CGcore/footer.php');
?>