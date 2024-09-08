<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<a class="link" href="/user_'.$user['id'].'"><span class="icon"><i class="fas fa-user-circle"></i></span> Профиль</a>
<a class="link" href="/user/red_ank.php"><span class="icon"><i class="fas fa-edit"></i></span> Редактировать анкету</a>';

if($user['level'] >= 1) {
echo '<a class="link" href="/panel"><span class="icon"><i class="fas fa-user-shield"></i></span> Админ панель</a>'; 
}
echo '<a class="link" href="/user/settings.php"><span class="icon"><i class="fas fa-cog"></i></span> Настройки</a>'; 
echo '<a class="link" href="#help"><span class="icon"><i class="fas fa-question"></i></span> Помощь</a>';
echo '<div id="help" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Помощь</h3>
        <a class="close" href="#close"><i class="fas fa-remove" title="Закрыть"></i></a>
      </div>
      <div class="modal-body">    
        Если у вас появились вопросы, связаться с нами вы можете при помощи следующих сервисов:
		<br />
		<br />
		<a class="link" href="https://vk.com/grove.team"><span class="icon"><i class="fab fa-vk"></i></span> Вконтакте</a>
		<a class="link" href="https://t.me/grove_soft"><span class="icon"><i class="fab fa-telegram"></i></span> Телеграм</a>
		<a class="link" href="mailto:grove.soft@bk.ru"><span class="icon"><i class="fas fa-envelope-open"></i></span> Почта</a>
      </div>
    </div>
  </div>
</div>';
echo '<hr><a class="link" href="#exit"><span class="icon"><i class="fas fa-sign-out-alt"></i></span> Выход</a>';

echo '<div id="exit" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Выход</h3>
      </div>
      <div class="modal-body">    
        Вы действительно хотите покинуть сайт?
		<br />
	 <br />
  <br />
		<a class="cenbut" style="background-color: #228e5d; padding: 7px; color: #dfeae5; border-radius: 6px; float: right;" href="/exit.php?okda">Выйти</a>
  <a class="cenbut" style="background-color: #272727; padding: 7px; color: #228e5d; border: 1px solid #303030; border-radius: 6px; float: right; margin-right: 7px;" href="#close">Отмена</a>
      </div>
    </div>
  </div>
</div>';

include ('../CGcore/footer.php');

?>
