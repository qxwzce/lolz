<?php
$locate = 'in_cabinet';
if(isset($user)) {
if(isset($_POST['save_email']) && $_GET['act']== 'change_mail') {
$email = input($_POST['nemail']);
if (!empty($email) && (mb_strlen($email, 'UTF-8') < 3 || mb_strlen($email, 'UTF-8') > 72)) $err .= $lang->word('b_mail').'<br />';
 if (!empty($email) && !preg_match('|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})$|ius', $email)) $err .= $lang->word('e_email').'<br />'; 
if(crypto($_POST['pass']) == $user['password'] && $_POST['cemail'] == $user['email']) {
if($db->query("SELECT * FROM `users` WHERE `email` = '$email'")->rowCount() == 0) {
$db->query("UPDATE `users` SET `email` = '". $email."' WHERE `id` = '". $user['id']."' ");
// print_r($db->errorInfo());
	}
	} else { $err .= $lang->word('ex_mail').'<br/>'; }
}

if(isset($_POST['save_pass']) && $_GET['act']== 'change_pass') {
$pass1 = $_POST['npass'];
$pass = $_POST['pass'];
 if (!empty($pass1) && (mb_strlen($pass1, 'UTF-8') < 5 || mb_strlen($pass1, 'UTF-8') > 64)) $err .= $lang->word('e_pass').'<br />';        
if (!empty($pass1) && !empty($pass) && $pass1 != $pass) $err .= $lang->word('e_pass2').'<br />';
if(crypto($_POST['cpass']) == $user['password']) {
$db->query("UPDATE `users` SET `password` = '". crypto($pass)."' WHERE `id` = '". $user['id']."' ");
// print_r($db->errorInfo());
	} else { $err .= $lang->word('ex_mail').'<br/>'; }
}

include('../CGcore/head.php');

if($_GET['act']=='edited') {$tpl->div('block', $lang->word('succ_save'));}
$tpl->div('title', $lang->word('security'));
if(isset($err)) $tpl->div('error', $err);
$tpl->div('menu', $lang->word('security_t'));
$tpl->div('title',  $lang->word('change_mail'));
echo '<form action="?act=change_mail" method="post">
		<div class="post">
		<b>'. $lang->word('current') .' E-Mail</b>:<br/>
		<input type="text" name="cemail" value="'. $user['email'] .'" /><br/>
		<b>'. $lang->word('new_e') .' E-Mail:</b><br/>
		<input type="text" name="nemail"/><br/>
		<b>'. $lang->word('current') .' '. $lang->word('password') .'</b>:<br/>
		<input type="password" name="pass"/><br/>
		<input type="submit" name="save_email" value="'. $lang->word('save') .'" /><br/>
		</div>
		</form>';
$tpl->div('title',  $lang->word('change_pass'));
echo '<form action="?act=change_pass" method="post">
		<div class="post">
		<b>'. $lang->word('current') .' '. $lang->word('password') .'</b>:<br/>
		<input type="text" name="cpass" /><br/>
		<b>'. $lang->word('new_e') .' '. $lang->word('password') .'</b>:<br/>
		<input type="text" name="npass"/><br/>
		<b>'. $lang->word('confirm') .' '. $lang->word('password') .'</b>:<br/>
		<input type="text" name="pass"/><br/>
		<input type="submit" name="save_pass" value="'. $lang->word('save') .'" /><br/>
		</div>
		</form>';
$tpl->div('block', NAV.'<a href="/user/panel/">'.$lang->word('user_panel').'</a></div>'
.'<div class="block"><img src="/template/icons/home.png"> <a href="/">'. $lang->word('home').'</a></div>');
include('../CGcore/head.php');
?>