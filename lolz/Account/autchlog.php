<?
$title = 'Логи авторизаций';
include ('../CGcore/core.php');
include ('../CGcore/head.php');
if(!$user['id']){
header('Location: '.$HOME);
exit();
}
echo '<div class="title"><a href="'.$HOME.'/Account/autchlog.php">Кабинет</a> | Логи авторизаций</div>';
if (empty($user['max'])) $user['max']=15;
$max = $user['max'];
$k_post = mysql_result(mysql_query("SELECT COUNT(*) FROM `log_auth` WHERE `us` = '".$user['id']."' "),0);
$k_page = k_page($k_post,$max);
$page = page($k_page);
$start = $max*$page-$max;
$logs = mysql_query("SELECT * FROM `log_auth` WHERE `us` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, $max");
while($a = mysql_fetch_assoc($logs))
{
if($a['type'] == '1'){  
$otv = '<font color="green"><b>удачный</b></font>';}
elseif($a['type'] == '0'){ 
$otv = '<font color="red"><b>неудачный</b></font>';}
echo '<div class="menu">
Логин: '.user($a['id']).'
Время: '.vremja($a['time']).'</p>
Тип: '.$otv.'</p>
IP: '.$a['ip'].'</p>
Софт: '.$a['ua'].'</div>';
}

if($k_post < 1) echo '<div class="menu"><b><center>Пусто!</center></b></div>';
if($k_page>1) echo str(''.$HOME.'/Office/Log/Autch?',$k_page,$page); // Вывод страниц
include ('../CGcore/footer.php');
?>