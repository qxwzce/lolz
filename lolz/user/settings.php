<?
include ('../CGcore/core.php');
include ('../CGcore/head.php');

if(!$user['id']) exit(header('Location: '.$HOME));

echo '<div class="menu"><a href="'.$HOME.'/user/cab.php">Личный кабинет</a> | Личные настройки</div>';

if(isset($_REQUEST['ok'])) {

$style = strong($_POST['style']);
$max = strong($_POST['max']);
$nt = strong($_POST['new_tem']);
$nf = strong($_POST['new_files']);
$ff = strong($_POST['form_file']);
$bp = strong($_POST['bb_panel']);

mysql_query("UPDATE `users` SET `style` = '".$style."', `max` = '".$max."', `new_tem` = '".$nt."', `new_files` = '".$nf."', `form_file` = '".$ff."', `bb_panel` = '".$bp."' WHERE `id` = '".$user['id']."'");
echo '<div class="ok">Настройки успешно изменены</div>';
}

  if (isset($_POST['style'])) {
        if (trim(htmlspecialchars(mysql_real_escape_string($_POST['style'] ))) == 'WEB') setcookie('version', 'web', time()+60*60*24*14);
        elseif (trim(htmlspecialchars(mysql_real_escape_string($_POST['style'] )))== 'WAP') setcookie('version', '');
    } 

echo '<div class="menu" style="border-bottom: 0px;">'; 
    echo '<form name="form" action="?act=set&amp;ok=1" method="post">
            Выбрать стиль: </br><select name="style" style="width: 100%; margin-left: 0px; margin-right: 0px; border-radius: 8px;">';
            $styles = glob('../design/theme/*', GLOB_ONLYDIR);
            foreach ($styles as $style) {
                $selected = ($u['style'] == basename($style)) ? ' selected="selected"' : '';
                echo '<option value="'.basename($style).'"'.$selected.'>'.basename($style).'</option>';
            } 
            echo '</select><hr>';


 
echo 'Пунктов на страницу: </br><select name="max" style="width: 100%; margin-left: 0px; margin-right: 0px; border-radius: 8px;">';
$dat = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $user['max'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><hr>';

echo 'Темы на главной: </br><select name="new_tem" style="width: 100%; margin-left: 0px; margin-right: 0px; border-radius: 8px;">';
$dat = array('Показывать' => '0', 'Скрывать' => '1');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $user['new_tem'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><hr>';

echo 'Панель ВВ кодов: </br><select name="bb_panel" style="width: 100%; margin-left: 0px; margin-right: 0px; border-radius: 8px;">';
$dat = array('Скрывать' => '0', 'Показывать' => '1');
foreach ($dat as $key => $value) { 
echo ' <option value="'.$value.'"'.($value == $user['bb_panel'] ? ' selected="selected"' : '') .'>'.$key.'</option>'; 
}
echo '</select><hr>';

echo '<center><input type="submit" style="margin-top: 5px;" name="ok" value="Изменить" style="width: 150px; margin-top: 15px; margin-bottom: 0px; border-bottom: 0px;"/></center>
</form></div>';

//-----Подключаем низ-----//
include ('../CGcore/footer.php');
?>