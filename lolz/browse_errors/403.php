<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<style>
.content {
margin: 65px 0px 25px 0px;
padding: 40px 0;
}
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content {
margin: 65px 0px 25px 0px;
}
</style>';

echo '<center><div class="ntf">403</div></center><br />';
echo '<center><div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;">Отказано в доступе</div></center>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Администратор форума запретил переход на данную страницу</center><br />
</div>
<center><a class="log" href="https://hack-lair.com" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">На главную</a></center>
<br /><hr><br />
<div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;"><center>Найти нужную страницу</center></div>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Воспользуйтесь кнопкой ниже чтобы перейти на форму поиска.</center></div><br />
<center><a class="log" href="https://hack-lair.com/forum/search.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">Поиск</a></center><br /><hr><br />
<div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;"><center>Дополнительные действия</center></div>
<div class="menu" style="background-color: #222; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Проверьте правильность написания ссылки в адресной строке.</center></div>';


include ('../CGcore/footer.php');

?>