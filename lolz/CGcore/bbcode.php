<script src="/js/qbbcodes.js"></script>

<script>
function x () {return;}
function FocusText() {
document.message.msg.focus();
document.message.msg.select();
return true; }
function DoSmilie(addSmilie) {
var revisedmsgage;
var currentmsgage = document.message.msg.value;
revisedmsgage = currentmsgage+addSmilie;
document.message.msg.value=revisedmsgage;
document.message.msg.focus();
return;
}
function DoPrompt(action) { var revisedmsgage; var currentmsgage = document.message.qmsgage.value; }
</script>

<div class="teg" style="padding-right: 10px; padding-left: 10px; cursor: default;">
<div class="menu_bb" style="overflow-y: scroll; display: flex;">
<a class='panel' href="javascript:tag('[h1]Замените на ваш текст', '[/h1]')"><i class="fas fa-font" title="Заголовок"></i></a> 
<a class='panel' href="javascript:tag('[b]Замените на ваш текст', '[/b]')"><i class="fas fa-bold" title="Жирный шрифт"></i></a> 
<a class='panel' href="javascript:tag('[i]Замените на ваш текст', '[/i]')"><i class="fas fa-italic" title="Курсив"></i></a> 
<a class='panel' href="javascript:tag('[u]Замените на ваш текст', '[/u]')"><i class="fas fa-underline" title="Подчёркнутый"></i></a> 
<a class='panel' href="javascript:tag('[s]Замените на ваш текст', '[/s]')"><i class="fas fa-strikethrough" title="Зачёркнутый"></i></a> 
<a class='panel' href="javascript:tag('[center]Замените на ваш текст', '[/center]')"> <i class="fas fa-align-center" title="Выровнять по центру"></i></a> 
<a class='panel' href="javascript:tag('[red]Замените на ваш текст', '[/red]')"><i style="color:#c15656;" class="fas fa-palette" title="Красный"></i></a>  
<a class='panel' href="javascript:tag('[blue]Замените на ваш текст', '[/blue]')"><i style="color:#1ea1a9" class="fas fa-palette" title="Синий"></i></a>  
<a class='panel' href="javascript:tag('[green]Замените на ваш текст', '[/green]')"><i style="color:#1ea96d" class="fas fa-palette" title="Зелёный"></i></a> 
<a class='panel' href="javascript:tag('[orange]Замените на ваш текст', '[/orange]')"><i style="color:#b9a26d" class="fas fa-palette" title="Оранжевый"></i></a> 
<a class='panel' href="javascript:tag('[url=https://ссылка]Название ссылки', '[/url]')"><i class="fas fa-link" title="Ссылка"></i></a> 
<a class='panel' href="javascript:tag('[img]Ссылка на изображение', '[/img]')"><i class="fas fa-image" title="Изображение"></i></a> 
<a class='panel' href="javascript:tag('[video]Ссылка на видео', '[/video]')"><i class="fas fa-video" title="Видео"></i></a> 
<a class='panel' href="javascript:tag('[cit]Замените на ваш текст', '[/cit]')"><i class="fas fa-quote-left" title="Цитата"></i></a> 
<a class='panel' href="javascript:tag('[stat]Замените на ваш текст', '[/stat]')"> <i class="fas fa-align-justify" title="Статья"></i></a> 
<a class='panel' href="javascript:tag('[code]Замените на ваш текст', '[/code]')"> <i class="fas fa-code" title="Код"></i></a> 
<a class='panel' href="javascript:tag('[spoiler]Замените на ваш текст', '[/spoiler]')"> <i class="fas fa-flag" title="Спойлер"></i></a> 
<a class="panel" href="#" onclick="$('.smile').toggle();return false;"><i class="far fa-face-laugh" title="Смайлы"></i></a> 
</div>

<?
echo '<div class="smile">';
echo '<center><div class="menu_smile">';
$sm = mysql_query("SELECT * FROM `smile` WHERE `papka` = '1' ORDER BY `id` DESC");
while($s = mysql_fetch_assoc($sm)){
echo '<a class="smil" href="javascript:%20x()" onclick="DoSmilie(\' '.$s['name'].' \');"><img src="/files/smile/'.$s['icon'].'" style="margin: 0px; padding: 5px; width: 30px; height:30px;"></a>';
}
echo '</div></center>';
echo '</div>';
?>

</div>