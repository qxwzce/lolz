<?
include ('../../CGcore/core.php');
include ('../../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<style>
.content {
	padding: 0px;
	background: none;
}
</style>';

echo '<title>Повышение прав</title>';
echo '<div class="menu" style="border-radius: 10px; border-bottom: 10px; padding: 10px 20px 11px;">Повышение прав</div>';

echo '<div class="preves">';

include ('uplevel/vip.php');
include ('uplevel/prime.php');

echo '</div>';

include ('../../CGcore/footer.php');
?>