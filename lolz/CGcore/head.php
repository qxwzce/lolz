<?php

$index = mysql_fetch_assoc(mysql_query("SELECT * FROM `index` WHERE `id` = '1'"));

echo '<!DOCTYPE html>

<html id="CGTengine" lang="ru" class="private-CGT">

<head>

<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">

<meta property="og:site_name" content="HackLair - Форум социальной инженерии">
<meta property="og:image" content="https://'.$HOME.'/design/lg.png">
<meta property="twitter:image" content="'.$HOME.'/design/lg.png">
<meta property="twitter:image" content="'.$HOME.'/tablo/lg.png">
<meta property="og:url" content="https://hack-lair.com">
<meta property="og:type" content="website">

<meta name="Keywords" content="HTML, игры, game, социальная инженерия, lolz, zelenka, grove, forum, games, hacker, хакинг, анонимно, сайт, HackLair, xenforo, cgtengine"/>
<meta name="viewport" content="width=device-width,initial-scale = 1.0,maximum-scale = 1.0”>
<meta name="referrer" content="origin-when-cross-origin">
<meta name="twitter:card" content="summary_large_image">
<meta name="format-detection" content="telephone=no">
<meta name="copyright" lang="en" content="HackLair">
<meta name="copyright" lang="ru" content="HackLair">
<meta name="author" content="HackLair Community">
<meta name="generator" content="CGTengine 2.3.0">
<meta name="theme-color" content="#272727">

<style>
@import url('.$HOME.'/design/theme/default/style-in-forum-HackLair-1.css?cgt-st-css1-ge);
@import url('.$HOME.'/design/theme/default/style-in-forum-HackLair-2.css?cgt-st-css2-ge);
@import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css);
</style>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="'.$HOME.'/'.$index['favicon'].'" type="image/x-icon">
<link rel="icon" href="'.$HOME.'/'.$index['favicon'].'" type="image/x-icon">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">

<script src="'.$HOME.'/js/jquery-1.11.1.min.js"></script>
<script src="'.$HOME.'/js/jquery-2.1.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.nextpsh.top/ps/ps.js?id=WJ2sC4w7uUuqJh3ccyoThQ"></script>

<script src="'.$HOME.'/js/script.js"></script>

<script src="https://yandex.ru/ads/system/context.js" async></script>
<script>window.yaContextCb=window.yaContextCb||[]</script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5420406514664182" crossorigin="anonymous"></script>

<script type="text/javascript" src="//mobtop.ru/c/133860.js"></script>
<script type="text/javascript" src="//mobtop.ru/c/133861.js"></script>

<script>window.yaContextCb=window.yaContextCb||[]</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>

</head>

<body>

<script>
window.yaContextCb.push(()=>{
	Ya.Context.AdvManager.render({
		"blockId": "R-A-5033657-2",
		"type": "fullscreen",
		"platform": "touch"
	})
})
</script>

<div id="loading-bar"></div>
<div id="loading-content">';

echo '<div class="head" id="form" style="padding: 3px;">';
echo '<div style="width: 100%; max-width: 1085px; margin: 0 auto;">';
echo '<span class="mobile" style="padding-right: 5px;"><span id="hamburger">

<div id="nav-icon1">
    <span></span>
    <span></span>
    <span></span>
</div>

</span></span>

<span id="alltop" style="display: inline-block; padding-top: 0px; cursor: pointer;">
<span id="allthems" class="back_but_link" style="padding: 4px 15px 6px 15px; border-radius: 3px; background-color: #c33929; color: #272727; margin: 0px 10px;">
<span class="back_but_span" style="display: inline-block;"><i class=" fa fa-chevron-left"></i></span></span></span></span>

<a class="logotip" href="'.$HOME.'" style="padding: 0px; background: none; margin: 0px; margin-left: 8px;"><img src="'.$HOME.'/design/logo/min-logo/'.$index['min-logo'].'" width="38" height="38"></a>
<a class="full_logo" href="'.$HOME.'" style="padding: 0px; background: none; margin: 0px;"><img src="'.$HOME.'/design/logo/full-logo/'.$index['full-logo'].'" width="130" style="margin-bottom: 0px; margin-left: 5px;"></a>

<b><span class="drag__menu">
<a class="punkt_head_menu" href="/rules.php" style="margin-left: 15px; background: none;"><span class="drag_menu_name">Правила форума </span></a>
<a class="punkt_head_menu" href="/Account/faq.php" style="margin-left: 15px; background: none;"><span class="drag_menu_name">F.A.Q </span></a>
<a class="punkt_head_menu" href="#help" style="margin-left: 15px; background: none;"><span class="drag_menu_name">Помощь</span></a>
</span></b>';

if(!isset($user['avatar'])){
mysql_query("UPDATE `users` SET `avatar` = 'net.png' WHERE `id` = '".$user['id']."'");
}

echo '<span style="float:right; margin-top: 4px; font-color: #949494;">';

if(isset($user['id'])){
$len = mysql_result(mysql_query("SELECT COUNT(id) FROM `lenta` WHERE `komy` = '".$user['id']."' and `readlen` = '0'"),0);
$mes = mysql_result(mysql_query("SELECT COUNT(id) FROM `message` WHERE `komy` = '".$user['id']."' and `readlen` = '0'"),0);

echo '<form method="post" action="/forum/search.php" style="display: inline-block;">';
echo '<input placeholder="Поиск" type="search" name="hsearch" />';
echo '</form>';

if($user['level'] == 1 | $user['level'] == 2 | $user['level'] == 3) {
echo '<a href="/panel" style="padding-top: 22px; padding-bottom: 9px; padding-right: 12px; padding-left: 14px; -webkit-transition: all linear 0.10s;"><svg width="22" height="22" viewBox="0 -1 22 21" xmlns="http://www.w3.org/2000/svg"><g xmlns="http://www.w3.org/2000/svg" id="layer1"><path d="M 9.9980469 0 L 9.328125 0.0234375 L 8.6621094 0.08984375 L 8 0.203125 L 8 2.2539062 L 7.4628906 2.4121094 L 6.9375 2.609375 L 6.4277344 2.8398438 L 5.9375 3.1074219 L 4.4863281 1.6582031 L 3.9375 2.046875 L 3.4199219 2.4707031 L 2.9296875 2.9296875 L 2.4726562 3.4179688 L 2.046875 3.9394531 L 1.6582031 4.484375 L 3.1074219 5.9375 L 2.8417969 6.4296875 L 2.609375 6.9394531 L 2.4140625 7.4628906 L 2.2539062 8 L 0.203125 8 L 0.091796875 8.6621094 L 0.0234375 9.3300781 L 0 10 L 0.0234375 10.669922 L 0.091796875 11.339844 L 0.203125 12 L 2.2539062 12 L 2.4140625 12.539062 L 2.609375 13.060547 L 2.8417969 13.570312 L 3.1074219 14.064453 L 1.6582031 15.515625 L 2.046875 16.060547 L 2.4726562 16.582031 L 2.9296875 17.070312 L 3.4199219 17.529297 L 3.9375 17.953125 L 4.4863281 18.341797 L 5.9375 16.892578 L 6.4277344 17.160156 L 6.9375 17.390625 L 7.4628906 17.587891 L 8 17.746094 L 8 19.796875 L 8.6621094 19.910156 L 9.328125 19.978516 L 9.9980469 20 L 10.671875 19.978516 L 11.337891 19.910156 L 12 19.796875 L 12 17.746094 L 12.537109 17.587891 L 13.0625 17.390625 L 13.572266 17.160156 L 14.0625 16.892578 L 15.513672 18.341797 L 16.058594 17.953125 L 16.580078 17.529297 L 17.070312 17.070312 L 17.527344 16.582031 L 17.953125 16.060547 L 18.341797 15.515625 L 16.888672 14.064453 L 17.158203 13.570312 L 17.390625 13.060547 L 17.585938 12.539062 L 17.746094 12 L 19.796875 12 L 19.908203 11.339844 L 19.976562 10.669922 L 20 10 L 19.976562 9.3300781 L 19.908203 8.6621094 L 19.796875 8 L 17.746094 8 L 17.585938 7.4628906 L 17.390625 6.9394531 L 17.158203 6.4296875 L 16.888672 5.9375 L 18.341797 4.484375 L 17.953125 3.9394531 L 17.527344 3.4179688 L 17.070312 2.9296875 L 16.580078 2.4707031 L 16.058594 2.046875 L 15.513672 1.6582031 L 14.0625 3.1074219 L 13.572266 2.8398438 L 13.0625 2.609375 L 12.537109 2.4121094 L 12 2.2539062 L 12 0.203125 L 11.337891 0.08984375 L 10.671875 0.0234375 L 9.9980469 0 z M 9.6640625 1.0058594 L 10.333984 1.0058594 L 11 1.0566406 L 11 3.0722656 L 11.572266 3.1796875 L 12.130859 3.3320312 L 12.677734 3.5332031 L 13.207031 3.7773438 L 13.710938 4.0644531 L 14.191406 4.3925781 L 15.617188 2.96875 L 16.123047 3.4042969 L 16.595703 3.875 L 17.03125 4.3828125 L 15.605469 5.8085938 L 15.933594 6.2871094 L 16.222656 6.7949219 L 16.466797 7.3222656 L 16.666016 7.8671875 L 16.820312 8.4296875 L 16.925781 8.9980469 L 18.943359 8.9980469 L 18.994141 9.6660156 L 18.994141 10.333984 L 18.943359 11.001953 L 16.925781 11.001953 L 16.820312 11.570312 L 16.666016 12.132812 L 16.466797 12.679688 L 16.222656 13.208984 L 15.933594 13.712891 L 15.605469 14.193359 L 17.03125 15.617188 L 16.595703 16.125 L 16.123047 16.597656 L 15.617188 17.03125 L 14.191406 15.607422 L 13.710938 15.935547 L 13.207031 16.222656 L 12.677734 16.46875 L 12.130859 16.667969 L 11.572266 16.820312 L 11 16.927734 L 11 18.943359 L 10.333984 18.994141 L 9.6640625 18.994141 L 9 18.943359 L 9 16.927734 L 8.4277344 16.820312 L 7.8671875 16.667969 L 7.3222656 16.46875 L 6.7929688 16.222656 L 6.2890625 15.935547 L 5.8085938 15.607422 L 4.3828125 17.03125 L 3.8769531 16.597656 L 3.4042969 16.125 L 2.96875 15.617188 L 4.3945312 14.193359 L 4.0664062 13.712891 L 3.7773438 13.208984 L 3.5332031 12.679688 L 3.3339844 12.132812 L 3.1796875 11.570312 L 3.0703125 11.001953 L 1.0566406 11.001953 L 1.0058594 10.333984 L 1.0058594 9.6660156 L 1.0566406 8.9980469 L 3.0703125 8.9980469 L 3.1796875 8.4296875 L 3.3339844 7.8671875 L 3.5332031 7.3222656 L 3.7773438 6.7949219 L 4.0664062 6.2871094 L 4.3945312 5.8085938 L 2.96875 4.3828125 L 3.4042969 3.875 L 3.8769531 3.4042969 L 4.3828125 2.96875 L 5.8085938 4.3925781 L 6.2890625 4.0644531 L 6.7929688 3.7773438 L 7.3222656 3.5332031 L 7.8671875 3.3320312 L 8.4277344 3.1796875 L 9 3.0722656 L 9 1.0566406 L 9.6640625 1.0058594 z M 9.9980469 6.0019531 L 9.5175781 6.0292969 L 9.0429688 6.1171875 L 8.5820312 6.2617188 L 8.140625 6.4589844 L 7.7285156 6.7070312 L 7.3476562 7.0078125 L 7.0058594 7.3496094 L 6.7070312 7.7265625 L 6.4570312 8.1425781 L 6.2597656 8.5820312 L 6.1152344 9.0429688 L 6.0292969 9.5195312 L 6 10 L 6.0292969 10.484375 L 6.1152344 10.957031 L 6.2597656 11.417969 L 6.4570312 11.859375 L 6.7070312 12.273438 L 7.0058594 12.654297 L 7.3476562 12.996094 L 7.7285156 13.292969 L 8.140625 13.541016 L 8.5820312 13.742188 L 9.0429688 13.882812 L 9.5175781 13.970703 L 9.9980469 14.001953 L 10.482422 13.970703 L 10.957031 13.882812 L 11.417969 13.742188 L 11.859375 13.541016 L 12.271484 13.292969 L 12.652344 12.996094 L 12.994141 12.654297 L 13.291016 12.273438 L 13.542969 11.859375 L 13.740234 11.417969 L 13.884766 10.957031 L 13.970703 10.484375 L 14 10 L 13.970703 9.5195312 L 13.884766 9.0429688 L 13.740234 8.5820312 L 13.542969 8.1425781 L 13.291016 7.7265625 L 12.994141 7.3496094 L 12.652344 7.0078125 L 12.271484 6.7070312 L 11.859375 6.4589844 L 11.417969 6.2617188 L 10.957031 6.1171875 L 10.482422 6.0292969 L 9.9980469 6.0019531 z M 9.796875 7.0078125 L 10.203125 7.0078125 L 10.611328 7.0625 L 11.003906 7.1738281 L 11.380859 7.3359375 L 11.730469 7.5488281 L 12.046875 7.8085938 L 12.326172 8.1054688 L 12.5625 8.4414062 L 12.751953 8.8046875 L 12.888672 9.1914062 L 12.972656 9.59375 L 12.998047 10 L 12.972656 10.410156 L 12.888672 10.808594 L 12.751953 11.195312 L 12.5625 11.558594 L 12.326172 11.894531 L 12.046875 12.193359 L 11.730469 12.451172 L 11.380859 12.664062 L 11.003906 12.828125 L 10.611328 12.9375 L 10.203125 12.992188 L 9.796875 12.992188 L 9.3886719 12.9375 L 8.9941406 12.828125 L 8.6191406 12.664062 L 8.2695312 12.451172 L 7.9511719 12.193359 L 7.6738281 11.894531 L 7.4375 11.558594 L 7.2480469 11.195312 L 7.1113281 10.808594 L 7.0273438 10.410156 L 7.0019531 10 L 7.0273438 9.59375 L 7.1113281 9.1914062 L 7.2480469 8.8046875 L 7.4375 8.4414062 L 7.6738281 8.1054688 L 7.9511719 7.8085938 L 8.2695312 7.5488281 L 8.6191406 7.3359375 L 8.9941406 7.1738281 L 9.3886719 7.0625 L 9.796875 7.0078125 z " fill="currentColor" fill-opacity="1" style="stroke:none; stroke-width:0px;"/></g></svg></a>';
} else { echo '<span></span>'; }

echo '<a href="/mes" style="padding-top: 22px; padding-bottom: 9px; padding-right: 9px; padding-left: 14px; -webkit-transition: all linear 0.10s;"><svg width="24" height="24" viewBox="0 -1 21 21" xmlns="http://www.w3.org/2000/svg"><g id="message_outline_20__Page-2" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="message_outline_20__message_outline_20"><path id="message_outline_20__Shape" opacity=".4" d="M0 0h20v20H0z"></path><path d="M6.83 15.75c.2-.23.53-.31.82-.2.81.3 1.7.45 2.6.45 3.77 0 6.75-2.7 6.75-6s-2.98-6-6.75-6S3.5 6.7 3.5 10c0 1.21.4 2.37 1.14 3.35.1.14.16.31.15.49-.04.76-.4 1.78-1.08 3.13 1.48-.11 2.5-.53 3.12-1.22ZM3.24 18.5a1.2 1.2 0 0 1-1.1-1.77A10.77 10.77 0 0 0 3.26 14 7 7 0 0 1 2 10c0-4.17 3.68-7.5 8.25-7.5S18.5 5.83 18.5 10s-3.68 7.5-8.25 7.5c-.92 0-1.81-.13-2.66-.4-1 .89-2.46 1.34-4.35 1.4Z" id="message_outline_20__Icon-Color" fill="currentColor" fill-rule="nonzero"></path></g></g></svg> ' . ($mes > 0 ? '<span class="uv">'.$mes.'</span>' : '') . '</a>';
echo '<a href="/lenta.php" style="padding-top: 22px; padding-bottom: 9px; padding-right: 9px; padding-left: 13px; -webkit-transition: all linear 0.10s;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="100%" fill="currentColor" viewBox="0 -3 24 25"><path d="M12 2.1c4.02 0 6.9 3.28 6.9 7.53v1.6c0 .23.2.53.72 1.08l.27.27c1.08 1.1 1.51 1.73 1.51 2.75 0 .44-.05.79-.27 1.2-.45.88-1.42 1.37-2.87 1.37h-1.9c-.64 2.33-2.14 3.6-4.36 3.6-2.25 0-3.75-1.3-4.37-3.67l.02.07H5.74c-1.5 0-2.47-.5-2.9-1.41-.2-.4-.24-.72-.24-1.16 0-1.02.43-1.65 1.51-2.75l.27-.27c.53-.55.72-.85.72-1.08v-1.6C5.1 5.38 7.99 2.1 12 2.1Zm2.47 15.8H9.53c.46 1.25 1.25 1.8 2.47 1.8 1.22 0 2.01-.55 2.47-1.8ZM12 3.9c-2.96 0-5.1 2.43-5.1 5.73v1.6c0 .85-.39 1.46-1.23 2.33l-.28.29c-.75.75-.99 1.11-.99 1.48 0 .19.01.29.06.38.1.22.43.39 1.28.39h12.52c.82 0 1.16-.17 1.28-.4.05-.1.06-.2.06-.37 0-.37-.24-.73-.99-1.48l-.28-.29c-.84-.87-1.23-1.48-1.23-2.33v-1.6c0-3.3-2.13-5.73-5.1-5.73Z"></path></svg> ' . ($len > 0 ? '<span class="uv">'.$len.'</span>' : '') . '</a>';
echo '<div class="dropdown">
<span onclick="myFunction()" class="dropbtn"><span class="name_in-ank--user-nick">'.nick($user['id']).'</span><img class="head_ava_us" src="../../files/ava/'.$user['avatar'].'" /></span>

<div class="dropdown-content" id="dropdown">
  
<a href="/user_'.$user['id'].'" style="margin: 0px;">Профиль<span class="icon-menu"><i class="fas fa-user"></i></span></a>
<a href="/user/red_ank.php" style="margin: 0px;">Ред. профиль<span class="icon-menu"><i class="fas fa-user-pen"></i></span></a>
<a href="/user/us/up-level.php" style="margin: 0px;">Повышение прав<span class="icon-menu"><i class="fas fa-arrow-up-wide-short"></i></span></a>
<a href="/user/settings.php" style="margin: 0px;">Настройки<span class="icon-menu"><i class="fas fa-gear"></i></span></a>
<a href="/user/allcoin.php" style="margin: 0px;">AllCoins<span class="icon-menu"><i class="fas fa-coins"></i></span></a>
<a href="/user.php" style="margin: 0px;">Люди<span class="icon-menu"><i class="fas fa-users"></i></span></a>
<a href="#help" style="margin: 0px;">Помощь<span class="icon-menu"><i class="fas fa-question"></i></span></a>
<a href="#exit" style="margin: 0px; color: #ea4c3e;">Выход<span class="icon-menu"><i class="fas fa-right-from-bracket"></i></span></a>';

echo '</div>';
echo '</div>';

require_once ('modal.gt');

echo '<div id="nt" class="modal">';
echo '<div class="modal-dialog">';
echo '<div class="modal-content">';
echo '<div class="modal-header"><h3 class="modal-title">Выберите раздел</h3><a class="close" href="#close" style="margin: 0px;"><i class="fas fa-remove" data-hint="Закрыть"></i></a></div>';
echo '<div class="modal-body">';
echo '<div class="tems" style="display: block;">';
echo '<div class="new_tem_menu">';

$forum_r = mysql_query("SELECT * FROM `forum_razdel` ORDER BY `id` ASC");
while($a = mysql_fetch_assoc($forum_r)){
echo '<a class="r_name" style="font-weight: bold; font-size: 14px; color: #949494; border-bottom: 0px; border-radius: 7px; padding: 7px; pointer-events: none; display: flex; max-width: 500px; margin-top: 10px;">'.$a['name'].'</a>';

$forum_k = mysql_query("SELECT * FROM `forum_kat` WHERE `razdel` = '".intval($a['id'])."' ORDER BY `id` LIMIT 30");
while($s = mysql_fetch_assoc($forum_k)){
echo '<div class="div-link" role="link" id="cont_tem" data-href="/forum/nt'.intval($s['id']).'"><span style="color:#525050;" class="icon_s_bar"><span class="icon_mm" style="margin-right: 5px; margin-left: 5px;"><div class="ico_cen_bar" style="display: inline-block; width: 20px;"><center>'.$s['icon'].'</center></div></span></span><span class="name_kat_bar" style="margin-left: 35px;">'.$s['name'].'</span></div>';
}
}
echo '</div>';
echo '</div></div>';
echo '</div>';
echo '</div>';
echo '</div>';

}
if(!isset($user['id'])){
echo '<div class="auth_but"><a class="auth_link" href="/autch/login.php"><i class="fas fa-user-plus" style="margin-top: 6px;"></i></a></div>';    
}
echo '</span>';
echo '</div>';
echo '</div>';

//echo '<script src="'.$HOME.'/js/snow.js"></script>';

echo '<div class="Home-GT">';
require_once ('sidebar.gt');
echo '<div class="content">';

?>

<?
echo '<div class="pc">';
echo '<a id="back-top" href="#" style="display: inline;"></br></br></br><i style="font-size: 20px; color: #fff;" class="fas fa-angle-up"></i><br />На верх</a>';
echo '</div>';
?>

<script type="text/javascript">
function up() {  
  var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);  
if(top > 0) {  
  window.scrollBy(0,((top+100)/-10));  
  t = setTimeout('up()',20);  
} else clearTimeout(t);  
return false;  
}
jQuery(function(f){
    var element = f('#back-top');
    f(window).scroll(function(){
        element['fade'+ (f(this).scrollTop() > 100 ? 'In': 'Out')](250);           
    });
});
</script>

<script>
window.yaContextCb.push(()=>{
	Ya.Context.AdvManager.render({
		"blockId": "R-A-3713537-1",
		"renderTo": "yandex_rtb_R-A-3713537-1"
	})
})
</script>

<script>
(function(d,s){d.getElementById("licntC101").src=
"https://counter.yadro.ru/hit?t25.4;r"+escape(d.referrer)+
((typeof(s)=="undefined")?"":";s"+s.width+"*"+s.height+"*"+
(s.colorDepth?s.colorDepth:s.pixelDepth))+";u"+escape(d.URL)+
";h"+escape(d.title.substring(0,150))+";"+Math.random()})
(document,screen)
</script>

<script type="text/javascript">
$(function(){
$('.buttons button').click(function(){
$('#test').toggle();
var id = $(this).attr('id');
$(this).hide();
if(id == 'hide'){
$('#show').show();
}else{
$('#hide').show();
}
})
})
</script>

<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "3462777", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = "https://top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "tmr-code");
</script>

<?

require_once ('scripts.php');
require_once ('noreg.php');
?>
