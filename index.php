<?php

define('TEMPLATES_DIR', 'views/');
define('LAYOUTS_DIR', 'layouts/');

// main menu

$menuArray = [
    [
        "name" => "Задания","href" => "#",
        "submenu" => [
            ['id' => '1', 'href' => '?page=task1', 'name' => 'Задание 1'],
            ['id' => '2', 'href' => '?page=task2', 'name' => 'Задание 2'],
            ['id' => '3', 'href' => '?page=task3', 'name' => 'Задание 3'],
            ['id' => '4', 'href' => '?page=task4', 'name' => 'Задание 4'],
            ['id' => '5', 'href' => '?page=task5', 'name' => 'Задание 5'],
            ['id' => '6', 'href' => '?page=task6', 'name' => 'Задание 6'],
            ['id' => '7', 'href' => '?page=task7', 'name' => 'Задание 7'],
            ['id' => '8', 'href' => '?page=task8', 'name' => 'Задание 8'],
            ['id' => '9', 'href' => '?page=task9', 'name' => 'Задание 9']
        ]
    ],
    [
        "name" => "Просто пункт","href" => "#"
    ]
];


$locations = [
    "Саратовская" => ["Аркадак", "Аткарск",  "Балаково", "Берзовский"],
    "Свердловская" => ["Артёмовский", "Асбест"],
    "Амурская" => ["Белогорск", "Благовещенск", "Завитинск", "Зея", "Райчихинск"],
    "Московская" => ["Реутов", "Волоколамск", "Химки", "Монино"],
    "Смоленская" => ["Рудня", "Велиж", "Вязьма"],
    "Волгоградская" => ["Дубовка", "Жирновск", "Калач-На-Дону", "Камышин"],
    "Ленинградская" => ["Кингисепп", "Кириши", "Коммунар", "Лодейное Поле", "Луга"]
];

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

if (substr($page, 0, 4) == 'task') {
    $template = 'task';
    $title = 'Задание ' . substr($page, 4);

    if (function_exists($page)) {
        $content = $page();
    } else {
        $content = $page . ' Error: Task solution is not found';
    }
    $params = [
        'content' => $content,
        'title' => $title
    ];
} else {
    $template = 'default';
}

echo renderPage($template, ['title' => $title, 'menu' => makeMenu($menuArray)], $params);


function renderPage($template, $pageParams, $params = []) {
    extract($pageParams);
    $content = renderTemplate($template, $params);
    return renderTemplate(LAYOUTS_DIR .
        'layout', ['content' => $content, 'title' => $title, 'menu' => $menu]);
}

function renderTemplate($page, $params=[]) {
    ob_start();
    if (!is_null($params)) extract($params);

    $fileName = TEMPLATES_DIR . $page . '.php';

    if (file_exists($fileName)) {
        include $fileName;
    } else {
        die('the page doesn\'t exist');
    }

    return ob_get_clean();
}


//echo "<br><h1 id='top'>Урок 3. ДЗ</h1>";

function task1() {
    ob_start();

    $i = 0;
    while ($i < 101) {
        if (!($i % 3)) echo $i."&nbsp;";
        $i++;
    }

    return ob_get_clean();
}

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



function task3() {
    global $locations;
    ob_start();

    foreach ($locations as $region => $places) {
        echo "{$region} область:<br>";
        $numElems = count($places);
        foreach ($places as $idx => $town) {
            echo "{$town}";
            if ($idx < $numElems - 1) echo ", ";
        }
        echo "<br><br>";
    }

    return ob_get_clean();
}




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


function task6() {
    ob_start();
    echo "меню сгенерировано и отображено в позиции главного меню";
    return ob_get_clean();
}

function task7() {
    ob_start();
        for ($i = 0; $i <= 9; print($i++."&nbsp;")) {}
    return ob_get_clean();
}


function task8() {
    ob_start();

    global $locations;

    foreach ($locations as $region => $places) {
        echo "{$region} область:<br>";
        $numElems = count($places);
        foreach ($places as $idx => $town) {
            if (mb_substr($town, 0, 1) == "К") {
                echo "{$town}";
                if ($idx < $numElems - 1) echo ", ";
            }
        }
        echo "<br><br>";
    }

    return ob_get_clean();
}


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

//<li><a href="task1">Задание 1</a></li>
function makeMenu($arr, $lvl = 0) {
    if ($lvl == 0) $content = "<ul class=\"main-menu\">";
    else $content = "<ul>";
    foreach ($arr as $item) {
        $content .= ($lvl == 0)? "<li class=\"main-menu__top-li\">" : "<li>";
        $content .= "<a href=\"{$item['href']}\">{$item['name']}</a>";
        if (array_key_exists('submenu', $item)) {
            $content .= makeMenu($item['submenu'], $lvl+1);
        }
        $content .= "</li>";
    }
    $content .= "</ul>";
    return $content;
}


