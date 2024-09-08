<?php

/****** Создаем переменную адреса *****/

$HOME = 'https://'.$_SERVER['HTTP_HOST'];

/******* Запускаем сессии ******/

session_start();
ob_start();

/////////////////////////////////
////// Подключение стиля ///////
///////////////////////////////

//echo '<style>
//@import url('.$HOME.'/design/theme/default/style-in-forum-groveteam-1.css?php-st-css1-cg);
//@import url('.$HOME.'/design/theme/default/style-in-forum-groveteam-2.css?php-st-css2-cg);
//</style>';//

////////////////////////////////
///////// Фильтрация //////////
//////////////////////////////

function strong($msg){
$msg = trim($msg);
$msg = htmlspecialchars($msg);
$msg = mysql_escape_string($msg);
return $msg;
}

////////////////////////////////
//////// Подключаем БД ////////
//////////////////////////////

require_once ('config.gt'); //Подключаем конфиг с параметрами
$sql = mysql_connect(dbhost, dbuser, dbpass) or die(include 'non-db.gt');
mysql_query('SET NAMES `utf8`', $sql);
mysql_select_db(dbname, $sql) or die (include 'non-connect-db.gt');

$index = mysql_fetch_assoc(mysql_query("SELECT * FROM `index` WHERE `id` = '1'"));

////////////////////////////////
///// Проверяем сылку гет /////
//////////////////////////////

foreach ($_GET as $links) {
if (!is_string($links) || !preg_match('#^(?:[a-z0-9_\-/]+|\.+(?!/))*$#i', $links)) {
header ('Location: '.$HOME.'');
exit;
} 
} 
unset($links);

///////////////////////////////
//////////// Куки ////////////
/////////////////////////////

if (isset($_COOKIE['uslog']) and isset($_COOKIE['uspass'])) {
$uslog = strong($_COOKIE['uslog']);
$uspass = strong($_COOKIE['uspass']);
$dbs = mysql_query("SELECT * FROM `users` WHERE `login` = '".$uslog."' and `pass` = '".$uspass."' LIMIT 1");
$user = mysql_fetch_assoc($dbs);
if (isset($user['id'])) {
if ($user['login'] != $uslog or $user['pass'] != $uspass) {
setcookie('uslog', '', time() - 86400*31);
setcookie('uspass', '', time() - 86400*31);
}
}
 $config = mysql_fetch_assoc(mysql_query("SELECT * FROM `config` WHERE `id` = '1'"));
$users = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `login` = '".$uslog."' and `pass`='".$uspass."' LIMIT 1"));           
mysql_query("UPDATE `users` SET `viz`='".time()."', `ip`='".strong($_SERVER['REMOTE_ADDR'])."',`browser`='".strong($_SERVER['HTTP_USER_AGENT'])."',`gde`='".strong($_SERVER['REQUEST_URI'])."',`gdeon`='".strong($_SERVER['SCRIPT_NAME'])."' WHERE `id`='".$users['id']."'");
$vremja = time() - $users['viz'];
if($vremja < 120) {
$newtime = $user['online'] + $vremja;
mysql_query("UPDATE `users` SET `online` ='".$newtime."'  WHERE `id`='".$users['id']."'");
}

if(isset($user['id']) && $users['login']!=$uslog or $users['pass']!=$uspass) {
setcookie('uslog', '', time() - 86400*31);
setcookie('uspass', '', time() - 86400*31); 
}
}

///////////////////////////////
///////////  Ошибка //////////
/////////////////////////////

function err($tit, $err = NULL){
if(!$err) 
$m = '<div class="errors"><div class="err">'.$tit.'</div></div>';
else 
$m = '<div class="errors"><div class="title">'.$tit.'</div><div style="text-align: center; line-height: 20px; border-bottom: 0px;" class="menu"><div class="error_banner">Упс...</div></br>'.$err.'</div></div>';
return $m; 
}

///////////////////////////////
//////// Размер файла ////////
/////////////////////////////

function fsize($file){
if(!file_exists($file)) return "Файл не найден";
$filesize = filesize($file);
$size = array('б', 'Кб', 'Мб', 'Гб');
if($filesize > pow(1024,3)){$n=3;}
elseif($filesize > pow(1024,2)){$n=2;}
elseif($filesize > 1024){$n=1;}
else{$n=0;}
$filesize = ($filesize/pow(1024,$n));
$filesize = round($filesize, 1);
return $filesize.' '.$size[$n];
}

///////////////////////////////
/////////// BB Коды //////////
/////////////////////////////

function bb($mes){
$mes = stripslashes($mes);
$mes = preg_replace('#\[img\](.*?)\[/img\]#si', '<img class="bbimg" src="\1">', $mes);
$mes = preg_replace('#\[video\](.*?)\[/video\]#si', '<video style="margin: 10px 0; border-radius: 10px;" controls width="80%" max-height="100%" loop muted><source src="\1" type="video/mp4"></video>', $mes);
$mes = preg_replace('#\[cit\](.*?)\[/cit\]#si', '<div class="cit">\1</div>', $mes);
$mes = preg_replace('#\[spoiler](.*?)\[/spoiler\]#si', '<div class="spoiler-block" style="margin: 7px 0px 0px 0px;"><a href="#" class="spoiler-title" style="color: #d6d6d6; display: inline-block; padding: 5px 15px; background: #2d2d2d; border: none;"><div class="sp_name" style="display: inline-block; margin-bottom: 3px; padding-right: 20px;">Спойлер </div><span class="sp_icon" style="margin: 2px 0px 0px 7px; display: inline-block;"><i class="fas fa-circle-info" style="color: #7d7d7d;"></i></span></a><br /><div class="spoiler-content" style="padding: 3px 15px 4px; background: rgb(39, 39, 39); border-radius: 5px; margin-top: 7px; border: 0px;">$1</div></div>', $mes);
$mes = preg_replace('#\[code\](.*?)\[/code\]#si', '<div class="bb_code" style="background: #272727; display: inline-block; padding: 7px 10px; margin-top: 7px; border-radius: 10px;"><b>Код:<hr style="background: #666; color: #666;"></b><code>\1</code></div>', $mes);
$mes = preg_replace('#\[stat\](.*?)\[/stat\]#si', '<div style="background-color: #2d2d2d; border-radius: 10px; padding: 0 2px 0 2px;"><div class="php"><div style="padding: 10px;"><center><span style="color: #a586dc;"><div class="prefix"><b>Статья</b></div><br /><span style="color: #d6d6d6; font-size: 12px;">\1</span></div></div></center>', $mes);
$mes = preg_replace('#\[b\](.*?)\[/b\]#si', '<span style="font-weight: bold;"> \1 </span>', $mes);
$mes = preg_replace('#\[center\](.*?)\[/center\]#si', '<span style="text-align: center;"</span><center><span style="font-weight;">\1</span></pre></div></center>', $mes);
$mes = preg_replace('/\[url\s?=\s?([\'"]?)(?:https:\/\/)?(.*?)\1\](.*?)\[\/url\]/', ' <a href="https://$2"> $3 </a> ', $mes);
$mes = preg_replace('#\[i\](.*?)\[\/i\]#si', '<i>\1</i>', $mes);
$mes = preg_replace('#\[u\](.*?)\[\/u\]#si', '<u>\1</u>', $mes);
$mes = preg_replace('#\[s\](.*?)\[\/s\]#si', '<s>\1</s>', $mes);
$mes = preg_replace('#\[h1\](.*?)\[/h1\]#si', '<h1>\1</h1>', $mes);

//Цвета

$mes = preg_replace('#\[red\](.*?)\[\/red\]#si', '<span style="color:#c15656">\1</span>', $mes);
$mes = preg_replace('#\[green\](.*?)\[\/green\]#si', '<span style="color:#1ea96d">\1</span>', $mes);
$mes = preg_replace('#\[black\](.*?)\[\/black\]#si', '<span style="color:#000000;">\1</span>', $mes);
$mes = preg_replace('#\[blue\](.*?)\[\/blue\]#si', '<span style="color:#1ea1a9">\1</span>', $mes);
$mes = preg_replace('#\[orange\](.*?)\[\/orange\]#si', '<span style="color:#b9a26d">\1</span>', $mes);

$mes = preg_replace("~(^|\s|-|:| |\()(http(s?)://|(www\.))((\S{25})(\S{5,})(\S{15})([^\<\s.,>)\];'\"!?]))~i", "\\1<a href=\"http\\3://\\4\\5\">\\4\\6...\\8\\9</a>", $mes);
$mes = preg_replace("~(^|\s|-|:|\(| |\xAB)(http(s?)://|(www\.))((\S+)([^\<\s.,>)\];'\"!?]))~i", "\\1<a href=\"http\\3://\\4\\5\">\\4\\5</a>", $mes);
 
return $mes; 

}

///////////////////////////////
//////// Функция ника ////////
/////////////////////////////

function nick($id){
global $HOME;
$users = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '".$id."' LIMIT 1"));

if($users['verified'] == 0)$verified = '';
elseif($users['verified'] == 1)$verified = '<span class="scam_prefix" data-hint-prefix="На данного пользователя поступило много жалоб о мошенничестве">SCAM</span>';

//---Х-статус---//
$pol = '';
if($users['sex'] == 1)$pol = 'man_on';
else
if($users['sex'] == 2)$pol = 'j_on';

//-----Если пол == 1(мужской)-----//
if($users['sex'] == 1)
{ 
//-----Если онлайн-----//
if($users['viz'] > time()-360)
{
$p = $xst;
} else {
$p = '';
}
}
//-----Если пол == 2(жен)-----//
elseif($users['sex'] == 2)
{
if($users['viz'] > time()-360)
{
$p = $xst;
} else {
$p = '';  
}
}

return (empty($users)?'Удален':'<a class="name_in-ank--user" href="/user_'.$users['id'].'" style="'.$users['color_nick'].'">'.$users['login'].'</a> '.$verified.' '.$p.'');
  
}

///////////////////////////////
/////////// Листинг //////////
/////////////////////////////

function page($k_page=1) {
$page = 1;
$page = strong($page);
$k_page = strong($k_page);
if(isset($_GET['selection'])) {
if ($_GET['selection']=='top')
$page = strong(intval($k_page));
elseif(is_numeric($_GET['selection'])) 
$page = strong(intval($_GET['selection']));
}
if ($page<1)$page=1;
if ($page>$k_page)$page=$k_page;
return $page;
}

// Определяем кол-во страниц
function k_page($k_post = 0,$k_p_str = 10) {
if ($k_post != 0) {
$v_pages = ceil($k_post/$k_p_str);
return $v_pages;
}
else return 1;
}

function str($link='?',$k_page=1,$page=1){
if ($page<1)$page=1;
$page = strong($page);
$k_page = strong($k_page);

echo '<div class="mst">';

if ($page != 1)
echo '<a class="page2" href="'.$link.'selection=1" >1</a>';
else echo '<span class="page">1</span>';
for ($ot=-3; $ot<=3; $ot++){
if ($page+$ot>1 && $page+$ot<$k_page){
if ($ot==-3 && $page+$ot>2)echo " ..";
if ($ot!=0)echo '<a class="page2" href="'.$link.'selection='.($page+$ot).'" >'.($page+$ot).'</a>';
else echo '<span class="page">'.($page+$ot).'</span>';
if ($ot==3 && $page+$ot<$k_page-1)echo " |";}}
if ($page!=$k_page)echo '<a class="page2" href="'.$link.'selection=top" >'.$k_page.'</a>';
elseif ($k_page>1)echo '<span class="page">'.$k_page.'</span>';
echo '</div>';
}

///////////////////////////////
//////////// Время ///////////
/////////////////////////////

function vremja($time = NULL) {
if(!$time) $time = time();
$data = date('j.n.y', $time);
if($data == date('j.n.y')) $res = 'Сегодня в '. date('G:i', $time);
elseif($data == date('j.n.y', time() - 86400)) $res = 'Вчера в '. date('G:i', $time);
elseif($data == date('j.n.y', time() - 172800)) $res = 'Позавчера в '. date('G:i', $time);
else {
$m = array('0',
'Янв', 'Фев', 
'Мар', 'Апр', 'Май', 
'Июн', 'Июл', 'Авг', 
'Сен', 'Окт', 'Ноя', 
'Дек');

$res = date('j '. $m[date('n', $time)] .' Y в G:i', $time);
$res = str_replace(date('Y'), '', $res);
}
return $res;
}

///////////////////////////////
//////////// Смайлы //////////
/////////////////////////////

function smile($msg) {
global $HOME;
$msg = trim($msg);
$s = mysql_query("SELECT * FROM `smile` ORDER BY `id` DESC");
while($smile = mysql_fetch_array($s)) {
$msg = str_replace($smile['name'],' <img style="padding: 5px;" src="'.$HOME.'/files/smile/'.$smile['icon'].'" alt="'.$smile['name'].'"/> ',$msg);
}
return $msg;
}


///////////////////////////////
//// Определение браузера ////
/////////////////////////////

function user($user = NULL) {
global $HOME;
    // Определение браузера
    $ank = mysql_fetch_array(mysql_query("SELECT * FROM `users`  WHERE `id` = '$user' LIMIT 1"));
    $ua = strtolower($ank['browser']);
    $path_pc = ' <img src="'.$HOME.'/design/imgs/PC.png" /> ';
    $path_mob = ' <img src="'.$HOME.'/design/imgs/phone.png" /> ';


        if (preg_match('#(orca)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/orca.png" alt="" />';
        elseif (preg_match('#(lunascape)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/lunascape.png" alt="" />';
        elseif (preg_match('#(arora)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/arora.png" />';
        elseif (preg_match('#(coolnovo)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/coolnovo.png" alt="" />';
        elseif (preg_match('#(kylo)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/kylo.png" alt="" />';
        elseif (preg_match('#(flock)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/flock.png" alt="" />';
        elseif (preg_match('#(rockmelt)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/rockmelt.png" alt="" />';
        elseif (preg_match('#(cometbird)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/cometbird.png" alt="" />';
        elseif (preg_match('#(seamonkey)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/seamonkey.png" alt="" />';
        elseif (preg_match('#(iron)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/iron.png" alt="" />';
        elseif (preg_match('#(presto)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/opera.png" alt="" />';
        elseif (preg_match('#(yabrowser)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/yabrowser.png" alt="" />';
        elseif (preg_match('#(chrome)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/chrome.png" alt="" />';
        elseif (preg_match('#(msie)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/msie.png" alt="" />';
        elseif (preg_match('#(maxthon)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/maxthon.png" alt="" />';
        elseif (preg_match('#(safari)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/safari.png" alt="" />';
        elseif (preg_match('#(qtweb)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/qtweb.png" alt="" />';
        elseif (preg_match('#(firefox)#ui', $ua)) $browser = $path_pc .'<img src="'.$HOME.'/design/imgs/browsers/firefox.png" alt="" />';
        // Мобильные браузеры
        if (preg_match('#(sonyericsson)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/sony_ericsson.png" alt="" />';
        elseif (preg_match('#(ipod)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/apple.png" alt="" />';
        elseif (preg_match('#(iphone)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/apple.png" alt="" />';
        elseif (preg_match('#(android)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/android.png" alt="" />';
        elseif (preg_match('#(symbian)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/symbian.png" alt="" />';
        elseif (preg_match('#(windowsphone)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/windows.png" alt="" />';
        elseif (preg_match('#(wp7)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/windows.png" alt="" />';
        elseif (preg_match('#(wp8)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/windows.png" alt="" />';
        elseif (preg_match('#(webos)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/hp.png" alt="" />';
        elseif (preg_match('#(blackberry)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/blackberry.png" alt="" />';
        elseif (preg_match('#(htc)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/htc.png" alt="" />';
        elseif (preg_match('#(opera m)#ui', $ua)) $browser = $path_mob .'<img src="'.$HOME.'/design/imgs/browsers/opera.png" alt="" />';

        return $browser;
        $arr = array('nokia',
        'samsung',
        'siemens',
        'fly',
        'motorola',
        'sharp',
        'sony',
        'lg',
        'acer',
        'alcatel',
        'asus',
        'gigabyte',
        'highscreen',
        'huawei',
        'philips',
        'mts',
        'midp-2.0',
        'ucweb');
        foreach ($arr as $value) {
            if (strpos($ua, $value) !== false) {
                $browser = $path_mob;
                return $browser;
            }
        }
   
    
  
}


/////////////////////////////
//////////// Бан ///////////
///////////////////////////

include $_SERVER['DOCUMENT_ROOT'].'/ban/ban.php';

?>