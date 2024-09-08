<?php
// ============ KOTOFF.NET ============== //


// БИБЛИОТЕКИ ПРИ НЕОБХОДИМОСТИ
require_once('../CGcore/core.php');
require_once('../CGcore/head.php');
// =============================

$project_id = '12505'; // ID магазина
$secret_key = 'NLmx0woAqrgHYnMbDSVLChCJ77R8adf'; // Секретное слово


$sign = md5($project_id.':'.$_REQUEST['AMOUNT'].':'.$secret_key.':'.$_REQUEST['MERCHANT_ORDER_ID']);

//Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена
//Оплата прошла успешно, можно проводить операцию.


$amount = $_REQUEST['AMOUNT'];// Сумма прихода
$pay_id = $_REQUEST['MERCHANT_ORDER_ID'];

mysql_query("UPDATE `users` SET `money` = `money`+ 250 WHERE `id` = '".$user['id']."'"); // Пополняем баланс юзера, переписать под свой запрос!


die('YES');
require_once('../CGcore/footer.php');