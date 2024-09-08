<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id'] or $user['level'] < 1) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); 
exit;
}
if($user['level'] > 4) {
echo err($title, 'У вас не достаточно прав для просмотра данной страницы!');
include ('../CGcore/footer.php'); exit;
}
echo '<div class="title">Адм-панель / Рассылка писем</div>';
if(isset($_REQUEST['ok'])) {
$text = strong($_POST['text']);
$group = strong($_POST['group']);
if($group == 1)
{
$query = mysql_query("SELECT * FROM `users` WHERE `level` > '0'");
while($fp = mysql_fetch_array($query))
{
$con = mysql_result(mysql_query("SELECT COUNT(id) FROM `lenta` WHERE `kogo` = '12' and `kto` = '".$fp['id']."' LIMIT 1"),0);
if($con == 0) {
mysql_query("INSERT INTO `lenta` SET `kto` = '".$fp['id']."', `kogo` = '12', `time` = '".time()."', `posl_time` = '".time()."'");
mysql_query("INSERT INTO `lenta` SET `kto` = '12', `kogo` = '".$fp['id']."', `time` = '".time()."', `posl_time` = '".time()."'");
}
mysql_query("INSERT INTO `message` SET `kto` = '12', `komy` = '".$fp['id']."', `readlen` = '44', `text` = '" . $text . "', `time` = '".time()."'");
mysql_query("UPDATE `lenta` SET `posl_time`='".time()."' WHERE `kogo` = '12' and `kto`='".$fp['id']."' limit 1");
$i++;
}
}
if($group == 2)
{
$query = mysql_query("SELECT * FROM `users` WHERE `level` < '1'");
while($fp = mysql_fetch_array($query))
{
$con = mysql_result(mysql_query("SELECT COUNT(id) FROM `lenta` WHERE `kogo` = '44' and `kto` = '".$fp['id']."' LIMIT 1"),0);
if($con == 0) {
mysql_query("INSERT INTO `lenta` SET `kto` = '".$fp['id']."', `kogo` = '44', `time` = '".time()."', `posl_time` = '".time()."'");
mysql_query("INSERT INTO `lenta` SET `kto` = '44', `kogo` = '".$fp['id']."', `time` = '".time()."', `posl_time` = '".time()."'");
}
mysql_query("INSERT INTO `lenta` SET `kto` = '44', `komy` = '".$fp['id']."', `readlen` = '0', `text` = '".$text."', `time` = '".time()."'");
mysql_query("UPDATE `lenta` SET `posl_time`='".time()."' WHERE `kogo` = '44' and `kto`='".$fp['id']."' limit 1");
$i++;
}
}
echo '<div class="menu">Отправлено!</div>';
}
echo '<div class="menu" style="border-bottom: 0px;"><form action="" method="post" enctype="multipart/form-data"> 
<center><textarea name="text" placeholder="Текст письма"></textarea></center> <br />
<center><select name="group" style="margin: 0px;">
<option value="1">Админам</option>
<option value="2">Юзерам</option>
</select></center><br/ >
<input type="submit" name="ok" value="Отправить" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px; margin: 0px;" />
</form></div>';
include ('../CGcore/footer.php'); 