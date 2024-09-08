<?php
include ('../CGcore/core.php');
include ('../CGcore/head.php');


echo '<style>
.content {
margin: 60px 0px 10px 0px;
padding: 40px 0;
}
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content {
margin: 60px auto;
}
</style>';

echo '<center><div class="icon_window"><img src="../design/forum.png" style="width: 100px; height: 100px;"></div></center><br />';
echo '<center><div class="name_window" style="font-size: 19px; font-weight: 600; color: #d6d6d6;">Платный разбан</div></center>
<div class="menu" style="background-color: #272727; padding: 10px; border-radius: 9px; border-bottom: 0px;"><center>Причины и цена: </center><br />
<center><b><span class="news" style="margin-top: 10px; background-color: #2d2d2d; padding: 5px 15px; border-radius: 5px;"">Спам - 30р<br /><br />Оскорбление администрации - 50р<br /><br />Оскорбление пользователя - 100р<br /><br />Распространение информации эротического характера - 300р<br /><br />Мошенничество от лица администрации - 450р<br /><br />Распространение нелегальной информации - 670р<br /><br />Кража учетной записи - 850р<br /><br />Слив персональных данных пользователя - 1280р</center></b></span></div>
';

include ('../CGcore/footer.php');
?>