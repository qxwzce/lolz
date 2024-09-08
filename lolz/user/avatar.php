<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="menu"><a href="'.$HOME.'/user/cab.php">Личный кабинет</a> | Сменить аватарку</div>';

if(isset($_REQUEST['submit'])) {

$maxsize = 100; // Максимальный размер файла,в мегабайтах 
$size = $_FILES['filename']['size']; // Вес файла

if(!@file_exists($_FILES['filename']['tmp_name'])) {
echo '<div class="err">Вы не выбрали файл</div>';
include ('../CGcore/footer.php');
exit();
}

/* Максимальный размер 1 мб */
if ($size > (1048576 * $maxsize)) {
echo '<div class="err">Максимальный размер файла '.$maxsize.' мб</div>';
include ('../CGcore/footer.php');
exit();
}

/* Тип файлов которые можно загружать */
if($user['prev'] == 0) {
$filetype = array ( 'jpg', 'png', 'jpeg', 'bmp' ); 
}
if($user['prev'] == 1) {
$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ); 
}
if($user['prev'] == 2) {
$filetype = array ( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ); 
}

$upfiletype = substr($_FILES['filename']['name'],  strrpos( $_FILES['filename']['name'], ".")+1); 
  
/* Если тип файла не подходит */
if(!in_array($upfiletype,$filetype)) {
if($user['prev'] == 0) {
echo '<div class="err">К загрузке разрешены файлы форматом JPG,PNG,JPEG,BMP</div>';
include ('../CGcore/footer.php');
exit();
}
if($user['prev'] == 1) {
echo '<div class="err">К загрузке разрешены файлы форматом JPG,GIF,PNG,JPEG,BMP</div>';
include ('../CGcore/footer.php');
exit();
}
if($user['prev'] == 2) {
echo '<div class="err">К загрузке разрешены файлы форматом JPG,GIF,PNG,JPEG,BMP</div>';
include ('../CGcore/footer.php');
exit();
}
}

/* Если все окей,заливаем файл в папу и делаем запрос */
$files = 'files_'.rand(1234,5678).'_'.rand(1234,5678).'_'.$_FILES['filename']['name']; 

/* Заливаем */
move_uploaded_file($_FILES['filename']['tmp_name'], "../files/ava/".$files.""); 

/* Делаем запрос */
mysql_query("UPDATE `users` SET `avatar`='".$files."' WHERE `id`='".$user['id']."' limit 1");
header('Location: '.$HOME.'/user/avatar.php');
exit();
}

//--Удаление авки--//
if(isset($_REQUEST['delava'])) {
mysql_query("UPDATE `users` SET `avatar` = '' WHERE `id` = '".$user['id']."'");

unlink("../files/ava/".$user['avatar']."");

header('Location: '.$HOME.'/user/avatar.php');
exit();
}

echo '<div class="menu" style="border-radius: 7px; border-bottom: 0px; margin-top: 10px;">';
echo (empty($user['avatar'])?'<center><img src="../files/ava/net.png" alt="*" style="border-radius: 100px; width: 100px; height: 100px;"></center>':'<center><img src="../files/ava/'.$user['avatar'].'" alt="*" style="border-radius: 100px; width: 100px; height: 100px;"></center>');
echo '</div>';

if($user['avatar'] == 'net.png') {
echo '<span></span>';
} else {
echo '<center><a class="link" href="/user/avatar.php?delava" style="margin-top: 10px; border: solid #2d2d2d 1px; border-radius: 7px; margin: 0; padding: 9px 20px 10px 20px; display: inline-block;"><span class="icon"><i class="far fa-trash-alt"></i></span> Удалить аватар</a></center>';
}

echo '<center><div class="menu" style="border-bottom: 0px; padding: 5px 27px;">
<form action="" method="post" enctype="multipart/form-data"> 
<label class="input-file">
	   	<input type="file" name="filename">        
 	   	<span class="input-file-btn">Выберите файл</span>
 	</label> 
<input type="submit" value="Загрузить" name="submit" style="width: 150px; margin-top: 3px; margin-bottom: 0px; border-bottom: 0px;"/>
</form>
</div></center>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>

<script>
$('.input-file input[type=file]').on('change', function(){
	let file = this.files[0];
	$(this).next().html(file.name);
});
</script>