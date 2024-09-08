<?php

$description = 'Настройки безопасности анкеты | Халява, скрипты, схемы заработка, сливы, торговля, скам проекты, общение, чат, социальная инженерия, сливы LolzTeam. А также множество других услуг предоставлены только на нашем форуме GROVE!';

include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<title>Безопасность</title>';

# закрываем от гостей
if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="navigationSideBar ToggleTriggerAnchor">

<div class="menuVisible">

<a class="side_link" href="../user/red_ank.php">Персональная информация</a>
<a class="side_link" href="../Account/faq.php">F.A.Q</a>
<a class="selected" href="../Account/security.php">Безопасность</a>
</div>
</div>';

echo '<div class="menu">Личный кабинет | Редактировать анкету</div>';

echo '<div class="menu" style="padding: 15px; font-color: #d6d6d6; border-bottom: 0px; padding-bottom: 10px;">
<form action="" method="POST">
<div class="setting_punkt">Почта: <span class="mail_user">'.bb($ank['email']).'</span></div></br><a class="log" href="https://hack-lair.com/user/updatemail.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">Изменить почту</a></br><br />
<body style="font-size: 13px;">Почта вводится при регистрации, используется для восстановления учётной изаписи если забыли пароль.</body>
</br></br><hr></br>
<div class="setting_punkt">Пароль</div></br><a class="log" href="https://hack-lair.com/user/updatepass.php" style="border-radius: 6px; padding: 8px; padding-left: 15px; padding-right: 15px; font-size: 13px;">Изменить пароль</a></br></br>
</div>
</div>';

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
<a class="side_link" href="../Account/faq.php">F.A.Q</a>
<a class="selected" href="../Account/security.php">Безопасность</a>
</div>
</div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>