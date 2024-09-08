<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

echo '<title>Правила форума</title>';
echo '<div class="title">Правила форума</div>';
echo '<meta name="description" content="Общий свод правил для пользователей форума">';

$rule = mysql_fetch_assoc(mysql_query("SELECT `forum` FROM `rules`"));

echo '<div class="menu">'.nl2br(smile(bb($rule['forum']))).'</div>';

include ('../CGcore/footer.php');
?>