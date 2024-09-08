<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

session_start();
$_SESSION['logged_in_user_id'] = '1';
$_SESSION['logged_in_user_name'] = 'Tutsplus';
echo $_SESSION['logged_in_user_id'];
echo $_SESSION['logged_in_user_name'];

include ('../CGcore/footer.php');
?>