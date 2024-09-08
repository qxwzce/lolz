<?php 
require 'config.php';  // Подключаем файл управление базой данных

$colh = R::count('forum_tema'); // Достаем количество сообщений в 

echo $colh;  // Отправляем обратно

?>