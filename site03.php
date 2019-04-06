<?
 $info = 'Информация обо мне';
 $title = 'Главная страница - страница обо мне';
 $year = date("Y");

 $content = file_get_contents('site03.tmpl');
 $hooks = ['{{TITLE}}', '{{INFO}}', '{{YEAR}}'];
 $values = [$title, $info, $year];

 $content = str_replace($hooks, $values, $content);
 echo $content;