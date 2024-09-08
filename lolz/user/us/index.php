<?
include ('../../CGcore/core.php');
include ('../../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="title">'.$title.'</div>';
echo '<a class="link" href="color_nick.php"><span class="icon"><i class="fas fa-palette"></i></span> Цвет ника</a>
<a class="link" href="new_nick.php"><span class="icon"><i class="fas fa-user-edit"></i></span> Смена ника</a>
<a class="link" href="vip.php"><span class="icon"><i class="fas fa-star"></i></span> Купить VIP</a>';

include ('../../CGcore/footer.php');

?>