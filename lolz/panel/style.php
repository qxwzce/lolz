<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');
if(!$user['id'] or $user['level'] < 3) {
header('Location: '.$HOME.'');
exit();
}

$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM `index` WHERE `id` = '1'"));

echo '<div class="title"><a href="'.$HOME.'/panel/">Админ панель</a> | Стиль сайта</div>';

if(isset($_REQUEST['ok'])) {
$maxsize = 1000; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

/* Если не выбрали файл */
if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo '<div class="err">Вы не выбрали файл</div>';
include ('../CGcore/footer.php');
exit();
}

/* Максимальный размер 1 мб */
if ($size > (1000 * $maxsize)) {
echo '<div class="err">Максимальный размер файла '.$maxsize.' мб</div>';
include ('../CGcore/footer.php');
exit();
}

/* Тип файлов которые можно загружать */
$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ); 

$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 
  
/* Если тип файла не подходит */
if(!in_array($upfiletype,$filetype)) {
echo '<div class="err">К загрузке разрешены файлы форматом JPG,GIF,PNG,JPEG,BMP</div>';
include ('../CGcore/footer.php');
exit();
}

/* Если все окей,заливаем файл в папу и делаем запрос */
$files = 'logo-'.rand(1234,5678).'-'.rand(1234,5678).'-'.$_FILES['filename']['name']; 

/* Заливаем */
unlink("../design/logo/min-logo/".$sql['min-logo']."");
move_uploaded_file($_FILES['filename']['tmp_name'], "../design/logo/min-logo/".$files.""); 

/* Делаем запрос */
mysql_query("UPDATE `index` SET `min-logo`='".$files."' WHERE `index`.`id` = '1' limit 1");
header('Location: '.$HOME.'/panel/style.php');
exit();
}








if(isset($_REQUEST['okflogo'])) {
$maxsize = 1000; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

/* Если не выбрали файл */
if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo '<div class="err">Вы не выбрали файл</div>';
include ('../CGcore/footer.php');
exit();
}

/* Максимальный размер 1 мб */
if ($size > (1000 * $maxsize)) {
echo '<div class="err">Максимальный размер файла '.$maxsize.' мб</div>';
include ('../CGcore/footer.php');
exit();
}

/* Тип файлов которые можно загружать */
$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ); 

$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 
  
/* Если тип файла не подходит */
if(!in_array($upfiletype,$filetype)) {
echo '<div class="err">К загрузке разрешены файлы форматом JPG,GIF,PNG,JPEG,BMP</div>';
include ('../CGcore/footer.php');
exit();
}

/* Если все окей,заливаем файл в папу и делаем запрос */
$files = 'full-logo-'.rand(1234,5678).'-'.rand(1234,5678).'-'.$_FILES['filename']['name']; 

/* Заливаем */
unlink("../design/logo/full-logo/".$sql['full-logo']."");
move_uploaded_file($_FILES['filename']['tmp_name'], "../design/logo/full-logo/".$files.""); 

/* Делаем запрос */
mysql_query("UPDATE `index` SET `full-logo`='".$files."' WHERE `index`.`id` = '1' limit 1");
header('Location: '.$HOME.'/panel/style.php');
exit();
}









if(isset($_REQUEST['okfav'])) {
$maxsize = 1000; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

/* Если не выбрали файл */
if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo '<div class="err">Вы не выбрали файл</div>';
include ('../CGcore/footer.php');
exit();
}

/* Максимальный размер 1 мб */
if ($size > (1000 * $maxsize)) {
echo '<div class="err">Максимальный размер файла '.$maxsize.' мб</div>';
include ('../CGcore/footer.php');
exit();
}

/* Тип файлов которые можно загружать */
$filetype = array ( 'ico' ); 

$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 
  
/* Если тип файла не подходит */
if(!in_array($upfiletype,$filetype)) {
echo '<div class="err">К загрузке разрешены файлы форматом ico</div>';
include ('../CGcore/footer.php');
exit();
}

/* Если все окей,заливаем файл в папу и делаем запрос */
$files = $_FILES['filename']['name']; 

/* Заливаем */
unlink("../".$sql['favicon']."");
move_uploaded_file($_FILES['filename']['tmp_name'], "../".$files.""); 

/* Делаем запрос */
mysql_query("UPDATE `index` SET `favicon`='".$files."' WHERE `index`.`id` = '1' limit 1");
header('Location: '.$HOME.'/panel/style.php');
exit();
}

echo '<div class="menu" style="border-bottom: 0px; padding: 10px 27px 0px 27px;">';
echo '<div class="forma" style="display: inline-block;"><span class="form_name" style="width: 100px; display: inline-block;">Логотип: </span><img src="'.$HOME.'/design/logo/min-logo/'.$sql['min-logo'].'" style="width: 50px; height: 50px; margin-left: 10px;"></div>';
echo '<form action="" method="post" enctype="multipart/form-data" style="display: inline;"> 
<div class="block" style="display: inline-block; float: right; margin-top: 5px;"><label class="input-file">
	   	<input type="file" name="filename">        
 	   	<span class="input-file-btn">Выберите файл</span>
 	</label> 
<input type="submit" value="Загрузить" name="ok" style="width: 150px; margin-top: 3px; margin-bottom: 0px; border-bottom: 0px;"/></div>
</form>';
echo '</div>';

echo '<div class="menu" style="border-bottom: 0px; padding: 10px 27px 0px 27px;">';
echo '<div class="forma" style="display: inline-block;"><span class="form_name" style="width: 100px; display: inline-block;">Доп. логотип: </span><img src="'.$HOME.'/design/logo/full-logo/'.$sql['full-logo'].'" style="height: 50px; margin-left: 10px;"></div>';
echo '<form action="" method="post" enctype="multipart/form-data" style="display: inline;"> 
<div class="block" style="display: inline-block; float: right; margin-top: 5px;"><label class="input-file">
	   	<input type="file" name="filename">        
 	   	<span class="input-file-btn">Выберите файл</span>
 	</label> 
<input type="submit" value="Загрузить" name="okflogo" style="width: 150px; margin-top: 3px; margin-bottom: 0px; border-bottom: 0px;"/></div>
</form>';
echo '</div>';

echo '<div class="menu" style="border-bottom: 0px; padding: 10px 27px 0px 27px;">';
echo '<div class="forma" style="display: inline-block;"><span class="form_name" style="width: 100px; display: inline-block;">Favicon: </span><img src="'.$HOME.'/'.$sql['favicon'].'" style="width: 50px; height: 50px; margin-left: 10px;"></div>';
echo '<form action="" method="post" enctype="multipart/form-data" style="display: inline;"> 
<div class="block" style="display: inline-block; float: right; margin-top: 5px;"><label class="input-file">
	   	<input type="file" name="filename">        
 	   	<span class="input-file-btn">Выберите файл</span>
 	</label> 
<input type="submit" value="Загрузить" name="okfav" style="width: 150px; margin-top: 3px; margin-bottom: 0px; border-bottom: 0px;"/></div>
</form>';
echo '</div>';


//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>

<script>
$('.input-file input[type=file]').on('change', function(){
	let file = this.files[0];
	$(this).next().html(file.name);
});
</script>