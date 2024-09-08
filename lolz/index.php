<?php

include ('CGcore/core.php');
include ('CGcore/head.php');

echo '<script src="/js/offline.js"></script>';

##Выводим форум
$t_f = mysql_result(mysql_query('select count(`id`) from `forum_tema`'),0);
$p_f = mysql_result(mysql_query('select count(`id`) from `forum_post`'),0);
$ntf = mysql_result(mysql_query('select count(`id`) from `forum_tema` where `time` > "'.(time()-((60*60)*24)).'"'),0);

##последние темы форума
if (!isset($user['id'])){
include ('CGcore/thems_core.gt');   
}else{
if ($user['new_tem']== 0)
include ('CGcore/thems_core.gt');
}

include ('CGcore/footer.php');

?>
