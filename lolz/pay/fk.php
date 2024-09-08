<?php
    $merchant_id = "41480";
    $secret_word = "grotermsan";
    $order_id = "HackLair";
    $order_amount = "250";
    $currency = "RUB";
    $sign = md5($merchant_id.":".$order_amount.":".$secret_word.":".$currency.":".$order_id);

echo '<div class="menu" style="font-size: 16px; font-weight: 600; border-bottom: 0px;">Ваш баланс: <span class="bb-info" style="color: #d6d6d6;">'.bb($user['money']).' ₽</span></div><div class="pay" style="color: #d6d6d6; font-weight: bold; background: #303030; border-radius: 7px; margin: 10px 5px 0px 5px; padding: 15px;">
  <form method="get" action="https://pay.freekassa.ru/" style="margin: 0px;">
    <input type="hidden" name="m" value="'.$merchant_id.'">
    <input type="hidden" name="oa" value="'.$order_amount.'">
    <input type="hidden" name="o" value="'.$order_id.'">
    <input type="hidden" name="s" value="'.$sign.'">
    <input type="hidden" name="currency" value="'.$currency.'">
    <input type="hidden" name="lang" value="ru">
    <input type="hidden" name="us_login" value="'.$user["login"].'">

<div class="text_pod_but" style="font-size: 20px; margin-bottom: 10px;">250 ₽</div>
<div class="min_text_pod_but" style="margin-bottom: 10px;">После успешной оплаты, ваш баланс будет пополнен на 250 рублей.</div>

    <center><input class="but_pay" type="submit" name="pay" value="Оплатить"></center>
  </form>

</div>';
?>