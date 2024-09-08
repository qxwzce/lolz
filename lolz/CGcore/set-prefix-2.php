<?
if($forum_k['id'] == 1 | $forum_k['id'] == 2 | $forum_k['id'] == 5 | $forum_k['id'] == 7 | $forum_k['id'] == 16 | $forum_k['id'] == 19 | $forum_k['id'] == 20 | $forum_k['id'] == 34) {
echo '<span class="label">Префикс 2:</span>';
echo '<select name="prefix2" style="margin-left: 10px; margin-right: 10px; border-bottom: 0px; width: 45%;">';
$prefix2 = mysql_query("SELECT * FROM `forum_prefix2` ORDER BY `id` LIMIT 999");
while($pr2 = mysql_fetch_assoc($prefix2)) {
echo '<option value="'.$pr2['id'].'">'.$pr2['name'].'</option>';
}
echo '</select>';
} else { echo '<span></span>'; }
?>