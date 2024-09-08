<?
$prt = mysql_fetch_assoc(mysql_query("SELECT * FROM `forum_prefix` WHERE `id` = '".$a['prefix']."'"));
if(empty($a['prefix2'])) {
echo '<span class="prefix_for_them" style="'.$prt['style'].'">'.$prt['name'].'</span>';
} else {
echo '<span class="prefix_for_them2" style="'.$prt['style'].'">'.$prt['name'].'</span><span class="prefix2_plusone">+1</span>';
}
?>