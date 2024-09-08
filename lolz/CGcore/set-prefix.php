<?
echo '<span class="label">Префикс:</span>';
echo '<select name="prefix" style="margin-left: 10px; margin-right: 10px; border-bottom: 0px; width: 45%;">';
$prefix = mysql_query("SELECT * FROM `forum_prefix` ORDER BY `id` LIMIT 999");
while($pr = mysql_fetch_assoc($prefix)) {
echo '<option value="'.$pr['id'].'">'.$pr['name'].'</option>';
}
echo '</select>';
?>