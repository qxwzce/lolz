<?php

require_once ('core.php');


$forum = mysql_query("SELECT * FROM `forum_tema` ORDER BY `up` DESC LIMIT 40");
while($a = mysql_fetch_assoc($forum))
{

if($a['status'] == 0) { 
$icon = '<span style="color: #cc7b2e;" class="icon"><i class="fas fa-caret-right"></i></span>';
}elseif($a['status'] == 1){
$icon = '<span style="color: #abb15b;" class="icon" title="Тема закрыта для обсуждений"><i class="fas fa-lock"></i></span>';
}elseif($a['status'] == 2){
$icon = '<span style="color: #cc7b2e;" class="icon"><i class="fas fa-caret-right"></i></span>';
}
$ank = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '".$a['us']."'"));

echo '<div class="div-link" style="border-radius: 15px;" role="link" id="cont_tem" data-href="/forum/tema'.$a['id'].'">';

echo '<span class="flex_tem">';

echo '<div class="block_ava" role="link" id="cont_tem" style="width: 50px; padding: 0 0 0 10px;" data-href="/user_'.$a['us'].'">';

echo (empty($ank['avatar'])?'<img class="avatar-in-user--ava-block" src="/files/ava/net.png" style="width: 50px; height: 50px; margin-top: 2px;">':'<img class="avatar-in-user--ava-block" src="/files/ava/'.$ank['avatar'].'" style="width: 50px; height: 50px; margin-top: 2px;">');

echo '</div>';

echo '<span class="t_n_for" style="owerflow: hidden; ">'.$icon.' <b style="'.$a['color'].'">'.$a['name'].'</b></span>';


echo '<br /><span class="threadTitle--prefixGroup">';

$prev = '';

echo '<span class="prefix_them">';
include '../CGcore/prefix.php';
echo '</span>';

echo '<style>
    [data-hint-prefix] {
    pointer-events: none;
}
</style>';

echo '<span class="nick_st_us">'.nick($a['us']).'</span><span class="nick_st_usup">'.nick($a['usup']).'</span><span class="info-separator"></span><span class="time-in-them_mobile--threadTitle">'.vremja($a['time']).'</span><span class="time-in-them--threadTitle">'.vremja($a['up']).'</span>';

echo '<span class="com"><i class="fas fa-comment-alt" style="color: #949494; font-size: 12px; margin-right: 6px;"></i>'.mysql_result(mysql_query('select count(`id`) from `forum_post` WHERE `tema` = "'.$a['id'].'"'),0).'<span class="icon" style="margin-left: 0px; margin-right: 0px; margin-top: 20px; padding-right: 3px; font-size: 10px;"></span></span>
<br />
<span class="com_lite"><i class="fas fa-comment-alt" style="color: #949494; font-size: 13px; margin-right: 6px; margin-top: -5px; position: relative; display: inline;"></i><b>'.mysql_result(mysql_query('select count(`id`) from `forum_post` WHERE `tema` = "'.$a['id'].'"'),0).'</b><i class="fas fa-reply fa-rotate-180" style="margin-left: 8px;"></i> <span class="nick-st-com-usup-in-them--com_lite"><b>'.nick($a['usup']).'</b></span> <span class="time_up-in-them--com_lite"><i class="fas fa-caret-right" style="margin-right: 8px;"></i><b>'.vremja($a['up']).'</b></span>';

echo '</span>';

echo '</div>';

}

?>