<?php

$description = ' База знаний GROVE';

include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<title>F.A.Q</title>';
echo '<div class="navigationSideBar ToggleTriggerAnchor">

<div class="menuVisible">

<a class="side_link" href="../user/red_ank.php">Персональная информация</a>
<a class="selected" href="faq.php">F.A.Q</a>
<a class="side_link" href="security.php">Безопасность</a>
</div>
</div>';

echo '<div class="menu">Личный кабинет | F.A.Q</div>';

echo '<style>
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content{
margin: 65px 243px 15px 0px;
border-radius: 7px;
}
}
</style>';

$act = isset($_GET['act']) ? $_GET['act'] : null;
switch($act)
{
default:
echo '<a class="link" href="?act=anketa"><span class="icon"><i class="fas fa-angle-right"></i></span> Анкета</a>';
echo '<a class="link" href="?act=forum"><span class="icon"><i class="fas fa-angle-right"></i></span> Форум</a>';
echo '<a class="link" href="?act=reputation"><span class="icon"><i class="fas fa-angle-right"></i></span> Репутация</a>';
echo '<a class="link" href="?act=ked"><span class="icon"><i class="fas fa-angle-right"></i></span> Список мошенников</a>';
echo '<a class="link" href="?act=level"><span class="icon"><i class="fas fa-angle-right"></i></span> Роли</a>';
echo '<a class="link" href="?act=status"><span class="icon"><i class="fas fa-angle-right"></i></span> Личный статус</a>';
echo '<a class="link" href="?act=moder"><span class="icon"><i class="fas fa-angle-right"></i></span> Как стать модератором?</a>';
break;

case 'anketa':
echo '<div class="menu" style="border-bottom: 0px;">
Анкета - это место где находиться вся информация о пользавателе: Имя, страна, адрес его сайта и т.д.
<p>В анкете есть Фотография пользавателя (Аватарка) - которую можно изменить. </p>
<p>Так же в анкете можно узнать роль пользавателья, репутацию и сколько он просидел на сайте. </p>
<p>У каждого пользавателя есть своя анкета. </p>
<p>Ваша анкета: '.nick($user['id']).'. </p>
</div>';
break;


case 'forum':
echo '<div class="menu" style="border-bottom: 0px;">
Форум - это место где каждый может узнать информацию, получить опыт или попросить о помощи у других пользователей.
<p>Все темы форума отображаются на главной странице сайта </p>
</div>';
break;


case 'reputation':

echo '<div class="menu" style="border-bottom: 0px;">
<p>Репутация - это доска оценки пользователя </p>
<p>Репутацию пользователю задают другие пользователи</p>
<p>Если репутация низкая, а коментарии на доске говорят о том что пользователь мошенник, то пользователю дают префикс SCAM</p>
<p>Если пользователь игнорирует данный префикс и в его репутации продолжают появляться минусы, ему выдаётся бан!
</div>';


break;
case 'level':

echo '<div class="menu" style="border-bottom: 0px;">
Существует 4 роли: Пользователь, Модератор, Администратор и Директор. Каждый из ных иметь свою задачу работы:
<p><b><font color="green">Пользаватель</font></b> - простой мастер который сидить у нас на проекте, получает опыт или помогаеть кому то с проблемами:)</p>
<p><b><font color="red">Модератор</font></b> - человек который следить за порядком в форуме, за пользавателями и их повидением.Так же модераторы могут: банить ,разбанивать и выписивать нарушение.</p>
<p><b><font color="red">Администатор</font></b> - человек у которого есть опыт модерирование. Администраторы могут управлять темами ,банить ,разбанивать и выписивать нарушение.</p>
<p><b><font color="red">Директор</font></b> - человек у которого есть полный доступ ко всей админ панели</p>
</div>';


break;
case 'status':

echo '<div class="menu" style="border-bottom: 0px;">
Личный статус - это текст написаный под аватаркой пользователя.
<p>Каждый пользавател может написать свой статус в редакторе анкеты. </p>
</div>';


break;
case 'moder':

echo '<div class="menu" style="border-bottom: 0px;">
Как стать модератором? - для того чтобы стать модератором вам необходимо быть активным в форуме, иметь хорошую репутацию среди юзверов, не иметь криминального прошлого, и отправить заявку о повышении нам на почту
<p>Дружба и любые другие близкие отношения с администрацией не влияют на повышение</p>
</div>';


break;
case 'ked':
echo '<div class="menu" style="border-bottom: 0px;">
Список мошеников - это раздел где составлен список всех мошенников на форуме
<p>Определить мошенника можно по префиксу SKAM возле никнейма и по записям в репутации</p>
<br />
<p>Список мошенников находится на стадии раздаботки</p>
</div>';
break;

}

echo '<style>
@media all and (min-width: 800px){ 
#sidebar {
	display: none;
}
.content{
margin: 65px 243px 15px 0px;
border-radius: 7px;
}
}
</style>';

echo '<div class="navigationSideBar_Mobile">

<div class="menuVisible_Mobile">

<a class="side_link" href="../user/red_ank.php">Персональная информация</a>
<a class="selected" href="faq.php">F.A.Q</a>
<a class="side_link" href="security.php">Безопасность</a>
</div>
</div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>