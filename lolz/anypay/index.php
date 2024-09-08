<?php
  $project_id = '13527';
  $pay_id = '1443429';
  $amount = '100';
  $currency = 'RUB';
  $desc = 'Пример оплаты';
  $success_url = 'https://hack-lair.com/anypay/success.php';
  $fail_url = 'https://hack-lair.com/anypay/error.php';
  $secret_key = 'NLmx0woAqrgHYnMbDSVLChCJ77R8adf';

  $arr_sign = array( 
      $project_id, 
      $pay_id,
      $amount, 
      $currency, 
      $desc, 
      $success_url, 
      $fail_url, 
      $secret_key
  );


$sign = md5($project_id.':'.$amount.':'.$secret_key.':'.$currency.':'.$pay_id);

?>

<form action='https://anypay.io/merchant' accept-charset='utf-8' method='get'>
<input type='hidden' name='merchant_id' value='<?php echo $project_id; ?>'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='currency' value='<?php echo $currency; ?>'>
<input type='hidden' name='pay_id' value='<?php echo $pay_id; ?>'>
<input type='hidden' name='desc' value='<?php echo $desc; ?>'>
<input type='hidden' name='email' value='example@mail.com'>
<input type='hidden' name='sign' value='<?php echo $sign; ?>'>
<input type=submit value='Купить'>
</form>