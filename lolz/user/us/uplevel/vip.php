<?
if(isset($_REQUEST['ok'])) { mysql_query("UPDATE `users` SET `money` = '".($user['money']-499)."' WHERE `id` = '$user[id]' LIMIT 1"); mysql_query("UPDATE `users` SET `prev` = '1' WHERE `id` = '$user[id]' LIMIT 1"); echo '<div class="ok"><center>Вы успешно купили ресурс!</center></div>';}

echo '<div class="block_menu_pay" style="color: #d6d6d6; font-weight: bold; background: #222; border-radius: 10px; margin: 10px 0px 0px 0px; padding: 15px;">';
echo '<div class="text_pod_but" style="font-size: 20px; margin-bottom: 10px; display: inline-block;">VIP</div><span class="pay_date" style="font-size: 18px; margin-bottom: 10px; display: inline-block; color: rgb(148,148,148); margin-left: 5px;"> / Навсегда</span><div class="cena" style="float: right; display: inline-block; font-size: 20px;">499 ₽</div>';
echo '<div class="min_text_pod_but" style="margin-bottom: 10px;"><span class="pev_text_title">Преимушества:</span><br />';
echo '<span class="pev_text">Бесплатная смена никнейма<br />Бесплатная смена дизайна никнейма<br />Возможность установить GIF аватар<br />Значек возле никнейма</div>';

if($user['prev'] == 0) { 
echo '<a class="but_search" href="#pay-vip" style="border-radius: 7px; font-family: Open Sans; padding: 7px 20px 8px; margin: 3px 0 0 0; font-size: 13px; color: #f5f5f5; font-weight: bold; display: inline-block">Купить</a>';
}

if($user['prev'] == 1) { 
echo '<a class="but_search_dissable" style="border-radius: 7px; font-family: Open Sans; padding: 7px 20px 8px; margin: 3px 0 0 0; font-size: 13px; color: #424242; font-weight: bold; display: inline-block; background: #292929;">Присудствует</a>';
}

if($user['prev'] == 2) { 
echo '<a class="but_search_dissable" style="border-radius: 7px; font-family: Open Sans; padding: 7px 20px 8px; margin: 3px 0 0 0; font-size: 13px; color: #424242; font-weight: bold; display: inline-block; background: #292929;">Недоступно</a>';
}



echo '</div>';
echo '</div>';

if($user['prev'] == 0 & $user['money']>=500) { 
echo '<div id="pay-vip" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Подтверждение покупки</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Вы действительно хотите купить ресурс VIP?</div>
		<br />
	 <br />
  <br />
  <form name="form" action="?act=set&amp;ok=1" method="post">
		<center><input type="submit" name="ok" value="Купить" style="margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;" /></center>
       </form>
	   <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Отмена</a></center>
      </div>
    </div>
  </div>
</div>'; }

elseif($user['prev'] == 1) { echo '<div id="pay-vip" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Упс...</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Вы уже приобрели этот ресурс</div><br />
        <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Выйти</a></center>
      </div>
    </div>
  </div>
</div>'; }

elseif($user['prev'] == 2) { echo '<div id="pay-vip" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Упс...</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">Ваши возможности уже повышены</div><br />
        <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Выйти</a></center>
      </div>
    </div>
  </div>
</div>'; }

if($user['money']<=500) { echo '<div id="pay-vip" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Упс...</h3>
      </div>
      <div class="modal-body">    
        <div class="text-in-modal">На балансе не хватает денег</div><br />
        <center><a class="cenbut" style="background-color: #272727; padding: 7px; color: #c33929; border: 1px solid #303030; border-radius: 6px; margin: 10px 0px 0 0; display: block; position: relative;" href="#close">Выйти</a></center>
      </div>
    </div>
  </div>
</div>'; }

?>