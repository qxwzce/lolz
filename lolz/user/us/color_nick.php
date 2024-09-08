<?
include ('../../CGcore/core.php');
include ('../../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="menu" style="color: #d6d6d6; font-size: 15px;">Смена дизайна никнейма</div>';

if (isset($user) & $user['prev'] == 0 & $user['money']<=90){
echo "<div class='err'>Извините, но у вас не хватает денег для смены дизайна ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>";
include ('../../CGcore/footer.php');
exit();
}
elseif($user['prev'] == 1 & $user['money']<=0){ echo '<div class="err" style="display: none;">Извините, но у вас не хватает денег для смены дизайна ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>'; }
elseif($user['prev'] == 2 & $user['money']<=0){ echo '<div class="err" style="display: none;">Извините, но у вас не хватает денег для смены дизайна ника, нужно <b>100</b> ₽<br/>У вас <b>$user[money]</b> ₽</div>'; }

if(isset($_REQUEST['ok'])) {

$color_nick = strong($_POST['color_nick']);
if($user['prev'] == 0) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-100)."' WHERE `id` = '$user[id]' LIMIT 1"); }
elseif($user['prev'] == 1) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-0)."' WHERE `id` = '$user[id]' LIMIT 1"); }
elseif($user['prev'] == 2) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-0)."' WHERE `id` = '$user[id]' LIMIT 1"); }
mysql_query('UPDATE `users` SET `color_nick` = "'.$color_nick.'" WHERE `id` = "'.$user['id'].'"');
echo '<div class="ok">Вы успешно изменили цвет ника</div>';

}

if($user['prev'] == 0) { echo '<div class="menu" style="border-bottom: 0px;">Стоимость смены дизайна ника 100 ₽</div>'; }
elseif($user['prev'] == 1) { echo '<div class="menu" style="border-bottom: 0px;">Для вас стоимость смены дизайна ника составляет 0 ₽</div>'; }
elseif($user['prev'] == 2) { echo '<div class="menu" style="border-bottom: 0px;">Для вас стоимость смены дизайна ника составляет 0 ₽</div>'; }

echo '<div class="menu" style="border-bottom: 0px;">'; 
echo '<form name="form" action="?act=set&amp;ok=1" method="post">

<center><textarea name="color_nick" placeholder="Введите css стиль" style="height: 150px;" id="color-nick-css"></textarea></center>

<div class="spoiler-block" style="margin: 13px 0px 0px 0px; background: rgb(34, 34, 34, 0.85); padding: 7px 10px; border-radius: 10px;">
<a href="#" class="spoiler-title" style="color :#d6d6d6; padding: 6px 6px 7px; background: #303030; margin: 0px; max-width: 200px;"><center>Выбрать стиль</center></a>
<div class="spoiler-content" style="padding: 0px; background: none; border-radius: 10px; margin-top: 10px; border: 0px;">';

include 'styles_name.php';

echo '</div>
</div>

<center><input type="submit" name="ok" value="Изменить" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
</form></div>';

//-----Подключаем низ-----//
include ('../../CGcore/footer.php');
?>

<script type="text/javascript">
$('.Item').click(function(e){
  document.getElementById('color-nick-css').value += $(this).element.style();
});
</script>