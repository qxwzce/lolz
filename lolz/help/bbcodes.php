<?
include ('CGcore/core.php');
include ('CGcore/head.php');

if(!$user['id']) {
header('Location: '.$HOME.'');
exit();
}

echo '<div class="title">BB коды</div>
  <div class="podmenu"><div class="cit">Цитировать</div><br /><textarea>[cit]Текст цитаты[/cit]</textarea></div>
  <div class="podmenu"><a href="'.$HOME.'">Ссылка</a><br /><textarea>[url='.$HOME.']Ссылка[/url]</textarea></div>
  <div class="podmenu"><b>Жирный шрифт</b><br /><textarea>[b]Текст[/b]</textarea></div>
  <div class="podmenu"><i>Курсив</i><br /><textarea>[i]Текст[/i]</textarea></div>
  <div class="podmenu"><u>Подчеркнутый</u><br /><textarea>[u]Текст[/u]</textarea></div>
  <div class="podmenu"><s>Зачеркнутый</s><br /><textarea>[s]Текст[/s]</textarea></div>
  <div class="podmenu"><div class="code">Код</div><br /><textarea>[code]Код[/code]</textarea></div>
  <div class="podmenu"><div class="center">Выравнивание по центру</div><br /><textarea>[center]Текст[/center]</textarea></div>
  <div class="podmenu"><span style="color: red">Красный</span><br /><textarea>[red]Красный[/red]</textarea></div>
  <div class="podmenu"><span style="color: green">Зеленый</span><br /><textarea>[green]Зеленый[/green]</textarea></div>
  <div class="podmenu"><span style="color: blue">Синий</span><br /><textarea>[blue]Синий[/blue]</textarea></div>';

include ('CGcore/footer.php');
?>