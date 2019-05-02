<?php

define('TEMPLATES_DIR', 'views/');
define('LAYOUTS_DIR', 'layouts/');

define('TASKS_NUMBER', 10);

set_time_limit(10); // since using some (potentially) endless loops

$menuArray = [
    [
        "name" => "Главная","href" => "/"
    ],
    [
        "name" => "Задания","href" => "#",
        "submenu" => []
    ],
    [
        "name" => "Подменю 1","href" => "#",
        "submenu" => [
            [
                "name" => "Подменю 2","href" => "#",
                "submenu" => [
                    ['id' => "1", 'href' => "?page=task 1", 'name' => "Задание 1"],
                    ['id' => "2", 'href' => "?page=task 2", 'name' => "Задание 2"],
                    ['id' => "3", 'href' => "?page=task 3", 'name' => "Задание 3"]
                ]
            ]
        ]
    ]
];


// main menu
$menuArray[1]['submenu'] = genTasksArray(TASKS_NUMBER);

//var_dump($menuArray['submenu']);

function genTasksArray($tasksNum) {
    $arr = [];

    for ($i = 1; $i <= $tasksNum; $i++) {
        $arr[] = ['id' => "" . $i, 'href' => "?page=task{$i}", 'name' => "Задание {$i}"];
    }
    return $arr;
}

// regions and associated towns
$locations = [
    "Саратовская" => ["Аркадак", "Аткарск",  "Балаково", "Берзовский"],
    "Свердловская" => ["Артёмовский", "Асбест"],
    "Амурская" => ["Белогорск", "Благовещенск", "Завитинск", "Зея", "Райчихинск"],
    "Московская" => ["Реутов", "Волоколамск", "Химки", "Монино"],
    "Смоленская" => ["Рудня", "Велиж", "Вязьма"],
    "Волгоградская" => ["Дубовка", "Жирновск", "Калач-На-Дону", "Камышин"],
    "Ленинградская" => ["Кингисепп", "Кириши", "Коммунар", "Лодейное Поле", "Луга"]
];



// letters match array for the transliteration task
$alphabet = [
    'а' => 'a',   'б' => 'b',   'в' => 'v',
    'г' => 'g',   'д' => 'd',   'е' => 'e',
    'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
    'и' => 'i',   'й' => 'y',   'к' => 'k',
    'л' => 'l',   'м' => 'm',   'н' => 'n',
    'о' => 'o',   'п' => 'p',   'р' => 'r',
    'с' => 's',   'т' => 't',   'у' => 'u',
    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
    'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
    'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
    'э' => 'e',   'ю' => 'yu',  'я' => 'ya'
];

if (isset($_GET['page'])) $page = $_GET['page'];
else $page = 'index';

$params = [];
$title = 'Default Page';
$code = '';

// using the same task content template for all task pages
if (substr($page, 0, 4) == 'task') {
    $template = 'task';
    $title = 'Задание ' . substr($page, 4);

    // get current task function output and its code
    if (function_exists($page)) {
        $content = $page();
        $code = getFuncBody($page);
        switch ($page) {
            case 'task3':
                $code .= '<br>locations<br>'.json_encode($locations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            case 'task4':
                $code .= '<br><br>'.getFuncBody('transliterate', true);
                $code .= '<br>alphabet<br>'.json_encode($alphabet, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            case 'task5':
                $code .= '<br><br>'.getFuncBody('replaceSpaces', true);
                $code .= '<br><br>'.getFuncBody('replaceSpacesMB', true);
                break;
            case 'task6':
                $code .= '<br><br>'.getFuncBody('makeMenu', true);
                $code .= '<br>menuArray<br>'.json_encode($menuArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            case 'task9':
                $code .= '<br><br>'.getFuncBody('transliterate', true);
                $code .= '<br><br>'.getFuncBody('replaceSpacesMB', true);
                $code .= '<br>alphabet<br>'.json_encode($alphabet, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            default:
        }
    } else {
        $content = $page . ' Error: Task solution is not found';
    }
    $params = [
        'content' => $content,
        'title' => $title,
        'code' => $code
    ];
} else {
    // use the default template for the rest of the pages
    $template = 'default';
}

echo renderPage($template, ['title' => $title, 'menu' => makeMenu($menuArray)], $params);

// Looks quite messy in argument passing part. PhpStorm doesn't like it
function renderPage($template, $pageParams, $params = []) {
    extract($pageParams);
    $content = renderTemplate($template, $params);
    return renderTemplate(LAYOUTS_DIR .
        'layout', ['content' => $content, 'title' => $title, 'menu' => $menu]);
}

function renderTemplate($template, $params=[]) {
    ob_start();
    if (!is_null($params)) extract($params);

    $fileName = TEMPLATES_DIR . $template . '.php';

    if (file_exists($fileName)) {
        include $fileName;
    } else {
        die('the page doesn\'t exist');
    }

    return ob_get_clean();
}



// used to get task functions code for the task pages content
// based on SO answer on how to get function code
function getFuncBody($funcName, $whole = false) {
    if ($whole) {
        $startOffset = -1;
        $endOffset = 0;
    } else {
        $startOffset = 1; // skip the name and ob_start()
        $endOffset = -2; // skip ob_get and closing bracket
    }
    $func = new ReflectionFunction($funcName);
    $filename = $func->getFileName();
    $startLine = $func->getStartLine() + $startOffset;
    $endLine = $func->getEndLine() + $endOffset;
    $length = $endLine - $startLine;

    $source = file($filename);
    $body = implode("", array_slice($source, $startLine, $length));
    return htmlentities($body);
}


// task 1

function task1() {
    ob_start();
    $i = 0;
    while ($i < 101) {
        if (!($i % 3)) echo $i."&nbsp;";
        $i++;
    }

    return ob_get_clean();
}

// task 2

function task2() {
    ob_start();
    $i = 0;
    do {
        if ($i == 0) echo $i." - это ноль<br>";
        elseif ($i & 1) echo $i." - нечётное число<br>";
        else echo $i." - чётное число<br>";
    } while ($i++ < 10);
    return ob_get_clean();
}

// task 3

function task3() {
    global $locations; ob_start();

    foreach ($locations as $region => $places) {
        echo "{$region} область:<br>";
        if (count($places)) {
            echo implode(", ", $places) . '.';
        }
        echo "<br><br>";
    }

    return ob_get_clean();
}


// task 4

function transliterate($str, $alphabet) {
    $strArr = preg_split('//u', $str, NULL, PREG_SPLIT_NO_EMPTY);
    foreach($strArr as $idx => $item) {
        $lowercase = mb_strtolower($item);

        if (array_key_exists($lowercase, $alphabet)) {
            $strArr[$idx] = ($lowercase != $item) ?
                mb_strtoupper(mb_substr($alphabet[$lowercase], 0, 1)) . mb_substr($alphabet[$lowercase], 1, NULL)
                : $alphabet[$item];
        }
    }
    return implode($strArr); // not 100% multibyte safe
}

function task4() {
    ob_start();

    global $alphabet; // to avoid passing any parameters to the function

    $str = 'Мама мыла раму! Чукча жарил щавель.';

    echo $str, '<br>';
    echo transliterate($str, $alphabet), '<br>';

    return ob_get_clean();
}


// task 5

function replaceSpaces($str) {
    return str_replace(' ','_', $str);
}

//str_replace might be not 100% safe with multibyte strings
function replaceSpacesMB($str) {
    return mb_ereg_replace('\s','_', $str);
}

function task5() {
    ob_start();
    echo replaceSpaces('Съешь ещё этих мягких французских булок, да выпей чаю'), '<br>';
    echo replaceSpacesMB('Съешь ещё этих мягких французских булок, да выпей чаю'), '<br>';
    return ob_get_clean();
}

// task 6

function task6() {
    ob_start();
    echo "меню сгенерировано и отображено в позиции главного меню";
    return ob_get_clean();
}

// task 7

function task7() {
    ob_start();
        for ($i = 0; $i <= 9; print($i++."&nbsp;")) {}
    return ob_get_clean();
}

// task 8

function task8() {
    ob_start();

    global $locations;

    foreach ($locations as $region => $places) {
        echo "{$region} область:<br>";
        $numElems = count($places);
        $isFirstItem = true;
        $found = false;
        foreach ($places as $idx => $town) {
            if (mb_substr($town, 0, 1) == "К") {
                if (!$isFirstItem) echo ", ";
                echo "{$town}";
                $found = true;
                $isFirstItem = false;
            }
        }
        if ($found) echo ".<br>";
        echo "<br>";
    }

    return ob_get_clean();
}

// task 9

function task9() {
    ob_start();

    global $alphabet;

    $str1 = 'Мама мыла раму! Чукча жарил щавель.';
    $str2 = 'Съешь ещё этих мягких французских булок, да выпей чаю';

    echo $str1, '<br>';
    echo replaceSpacesMB(transliterate($str1, $alphabet)), '<br><br>';
    echo $str2, '<br>';
    echo transliterate(replaceSpacesMB($str2), $alphabet), '<br><br>';

    return ob_get_clean();
}

// task 10

function task10() {
    ob_start();
    echo '<div class="m-table">';
    for ($i = 0; $i < 10; $i++) {
        echo '<div class="m-table__row">';
        for ($j = 0; $j < 10; $j ++) {
            if ($i === 0) {
                $val =  $j;
            } elseif ($j === 0) {
                $val = $i;
            } else {
                $val = $i * $j;
            }
            echo '<span class="m-table__cell">' . $val . '</span>';
        }
        echo "</div>";
    }
    echo '</div>';

    return ob_get_clean();
}


//<li><a href="task1">Задание 1</a></li>
function makeMenu($arr, $lvl = 0) {
    if ($lvl == 0) $content = "<ul class=\"main-menu\">";
    else $content = "<ul>";
    foreach ($arr as $item) {
        $content .= ($lvl == 0)? "<li class=\"main-menu__top-li\">" : "<li>";
        $content .= "<a href=\"{$item['href']}\">{$item['name']}</a>";
        if (array_key_exists('submenu', $item)) { //isset is faster and returns false if the value = NULL
            $content .= makeMenu($item['submenu'], $lvl+1);
        }
        $content .= "</li>";
    }
    $content .= "</ul>";
    return $content;
}


