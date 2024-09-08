<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if(!$user['id']) {
header('Location: '.$HOME);
exit();
}

if(isset($_REQUEST['okda'])) {
setcookie('uslog', '', time() - 86400*31);
setcookie('uspass', '', time() - 86400*31);
header('location: '.$HOME);
}

echo '<div class="title">'.$title.'</div>';
echo '<div class="ok">Вы действительно хотите покинуть сайт?</div></br>';
echo '<table style="text-align:center;" cellspacing="0" cellpadding="0">';
echo '<td><a style="border-right:none;" class="link" href="/exit.php?okda">Да</a></td>';
echo '<td><a class="link" href="/index.php">Нет</a></td>';
echo '</table>';

include ('CGcore/footer.php');

?>