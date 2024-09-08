<?php
// ============ KOTOFF.NET ============== //

// БИБЛИОТЕКИ ПРИ НЕОБХОДИМОСТИ
require_once('../../CGcore/core.php');
require_once('../../CGcore/head.php');
// =============================

$merchant_id = '41480'; // ID магазина
$merchant_secret = 'grotermsan'; // Секретное слово


$sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

//Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена
//Оплата прошла успешно, можно проводить операцию.


$amount = $_REQUEST['AMOUNT'];// Сумма прихода
$pay_id = $_REQUEST['MERCHANT_ORDER_ID'];


mysql_query("UPDATE `users` SET `money` = `money`+ 250 WHERE `id` = '".$user['id']."' LIMIT 1"); // Пополняем баланс юзера, переписать под свой запрос!


echo '<div class="pay_ok">
<center><div class="block_info_pay_ok" style="background: #303030; border-radius: 7px; margin: 5px; padding: 15px;">
<img src="../../images/ok.png" width="50px"  style="width: 50px;" />
<div class="text_info_pay_ok" style="font-weight: bold; margin-top: 10px; color: #d6d6d6;"><span class="plus_money_pay_text" style="font-size: 17px;">+250 ₽</span><br />Оплата прошла успешно! </div>
</div></center>
</div>';

echo '<script>
let stateObj = {
  foo: "bar",
};

history.pushState(stateObj, "page 2", "https://hack-lair.com");
</script>';

require_once('../../CGcore/footer.php');

?>