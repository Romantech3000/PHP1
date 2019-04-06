<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homework</title>
    <style type="text/css">
        .task {
            padding: 5px 10px;
            margin: 10px 0;
            color: #fff;
            background-color: #888;
        }
        .res {
            color: #fff;
            background-color: #222;
            padding: 15px 20px;
        }
        pre {
            background-color: #e1e1ea;
            padding: 10px 0;
        }
        .xdebug-var-dump {
            background-color: #000;
            color: #fff;
            padding-left: 20px;
        }
    </style>
</head>
<body>
<p class="task">1. Установить программное обеспечение: веб-сервер, базу данных, интерпретатор, текстовый редактор. Проверить, что все работает правильно.</p>
    <p>Установлен OpenServer. Интерпретатор PHP сразу работал в консоли OpenServer.<br>
    Для работы php в Терминале PhpStorm добавлен путь в переменные окружения Windows.</p>
    <p>Добавлен CLI в настройках, как показывалось на лекции. Хотя в документе по Отладке PhpStorm поле CLI Interpreter оставлено пустым.</p>
    <p>Отладчик заработал</p>
    <p>Открытие php файла проекта через встроенный сервер работает некорректно.<br>
        Php Storm вызывает адрес вида http://localhost:63342/<папка проекта>/index.php даёт Bad Gateway</p>
<p>Отдельно интерпретатор не ставил, т.к. не вполне понятно, в данном окружении надо ставить TS или NTS вариант.
В Терминале использовал PHP 7.1 из поставки OpenServer в режиме interactive shell</p>
<p class="task">2. Выполнить примеры из методички и разобраться, как это работает.</p>
<p>"Примеры из методчки", это, видимо, вставки кода в ней:</p>

<p class="code-title">Код:</p>
<pre>
    echo ​"Hello, World!";
</pre>
<p>Результат:</p>
<p class="res">
    <?php
        echo "Hello, World!";
        ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $name​= "GeekBrains user";
    echo ​"Hello, $name!";
</pre>
<p>Результат:</p>
<p class="res">
    <?php
        $name = "GeekBrains user";
        echo "Hello, $name!";
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    define​(​'MY_CONST'​,​ ​100​);
    echo MY_CONST;
</pre>
<p>Результат:</p>
<p class="res">
    <?
        define('MY_CONST', 100);
        echo MY_CONST;
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $int10 = 42;
    $int2  = 0b101010;
    $int8  = 052;
    $int16 = 0x2A;
    echo ​"Десятеричная система 42 = $int10";
    echo ​"Двоичная система 0b101010 = $int2";
    echo ​"Восьмеричная система 052 = $int8";
    echo ​"Шестнадцатеричная система 0x2A = $int16"
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $int10 = 42;
        $int2 = 0b101010;
        $int8 = 052;
        $int16 = 0x2A;
        echo "Десятеричная система 42 = $int10<br>";
        echo "Двоичная система 0b101010 = $int2<br>";
        echo "Восьмеричная система 052 = $int8<br>";
        echo "Шестнадцатеричная система 0x2A = $int16<br>";
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $precise1 ​=​ ​1.5;
    $precise2 ​=​ ​1.5e4;
    $precise3 ​=​ ​6E-8;
    echo ​"$precise1 | $precise2 | $precise3"
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $precise1 = 1.5;
        $precise2 = 1.5e4;
        $precise3 = 6E-8;
        echo "$precise1 | $precise2 | $precise3";
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $a = 1;
    echo "$a&lt;br&gt;";
    echo '$a&lt;br&gt;';
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $a = 1;
        echo "$a<br>";
        echo '$a<br>';
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $a = 10;
    //$b = ( boolean ) $b; похоже на ошибку
    $b = ( boolean ) $a;
    echo var_dump($b); //чтобы был какой-то вывод
</pre>
<p>Результат:</p>
    <?php
        $a = 10;
        $b = (boolean) $a;
        var_dump($b);
    ?>

<p class="code-title">Код:</p>
<pre>
    $a = 'Hello,';
    $b = ' world';
    $c = $a . $b;
    echo $c;
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $a = 'Hello,';
        $b = ' world';
        $c = $a . $b;
        echo $c;
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $a = 4;
    $b = 5;
    echo $a + $b . '&lt;br&gt;';    // сложение
    echo $a * $b . '&lt;br&gt;';    // умножение
    echo $a -­ $b . '&lt;br&gt;';    // вычитание
    echo $a / $b . '&lt;br&gt;';  // деление
    echo $a % $b . '&lt;br&gt;'; // остаток от деления
    echo $a ** $b . '&lt;br&gt;'; // возведение в степень
</pre>
<p>Результат:</p>
<p class="res">
    <?php
        $a = 4;
        $b = 5;
        echo $a + $b . '<br>';    // сложение
        echo $a * $b . '<br>';    // умножение
        echo $a - $b . '<br>';    // вычитание
        echo $a / $b . '<br>';  // деление
        echo $a % $b . '<br>'; // остаток от деления
        echo $a ** $b . '<br>'; // возведение в степень
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $a = 4;
    $b = 5;
    $a += $b;
    echo 'a = ' . $a;
    $a = 0;
    echo $a++;     // Постинкремент
    echo ++$a;    // Преинкремент
    echo $a­­--;     // Постдекремент
    echo ­­--$a;    // Предекремент
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $a = 4;
        $b = 5;
        $a += $b;
        echo 'a = ' . $a. '<br>';
        $a = 0;
        echo $a++. '<br>';     // Постинкремент
        echo ++$a. '<br>';    // Преинкремент
        echo $a--. '<br>';     // Постдекремент
        echo --$a. '<br>';    // Предекремент
    ?>
</p>

<p class="code-title">Код:</p>
<pre>
    $a = 4;
    $b = 5;
    var_dump ( $a == $b ); // Сравнение по значению
    var_dump ( $a === $b ); // Сравнение по значению и типу
    var_dump ( $a > $b ); // Больше
    var_dump ( $a < $b ); // Меньше
    var_dump ( $a <> $b ); // Не равно
    var_dump ( $a != $b ); // Не равно
    var_dump ( $a !== $b ); // Не равно без приведения типов
    var_dump ( $a <= $b ); // Меньше или равно
    var_dump ( $a >= $b ); // Больше или равно?>
</pre>
<p>Результат:</p>
<p class="res">
    <?
        $a = 4;
        $b = 5;
        ob_start();
        var_dump ( $a == $b ); // Сравнение по значению
        var_dump ( $a === $b ); // Сравнение по значению и типу
        var_dump ( $a > $b ); // Больше
        var_dump ( $a < $b ); // Меньше
        var_dump ( $a <> $b ); // Не равно
        var_dump ( $a != $b ); // Не равно
        var_dump ( $a !== $b ); // Не равно без приведения типов
        var_dump ( $a <= $b ); // Меньше или равно
        var_dump ( $a >= $b ); // Больше или равно
        echo ob_get_clean();
    ?>
</p>


<p class="task">3. Объяснить, как работает данный код:</p>
<pre>
    &lt;?php
    $a = 5;
    $b = '05';
    var_dump($a == $b);         // Почему true? Приведенные при сравнении значения переменных одинаковые (5)
    var_dump((int)'012345');     // Почему 12345? При приведении строки к целочисленному типу ноль отбрасывается парсером.
    var_dump((float)123.0 === (int)123.0); // Почему false? Значение одинаковое, но для строгого сравнения должен совпадать и тип.
    var_dump((int)0 === (int)'hello, world'); // Почему true? Данная строка преобразуется к целому числу 0, т.к. в ней нет цифр.
    ?&gt;
</pre>
<p class="res">
    <?php
        $a = 5;
        $b = '05';
        ob_start();
        var_dump($a == $b);         // Почему true? Приведенные при сравнении значения переменных одинаковые (5)
        var_dump((int)'012345');     // Почему 12345? При приведении строки к целочисленному типу ноль отбрасывается парсером.
        var_dump((float)123.0 === (int)123.0); // Почему false? Значение одинаковое, но для строгого сравнения должен совпадать и тип.
        var_dump((int)0 === (int)'hello, world'); // Почему true? Данная строка преобразуется к целому числу 0, т.к. в ней нет цифр.
        echo ob_get_clean();
    ?>
</p>
<p class="task">4. Используя имеющийся HTML-шаблон, сделать так, чтобы главная страница генерировалась через PHP.
    Создать блок переменных в начале страницы. Сделать так, чтобы h1, title и текущий год генерировались в блоке контента из созданных переменных.
</p>
<p><a href="site01.php">Шаблон со вставками php</a></p>
<p class="task">
    5. *Используя только две переменные, поменяйте их значение местами. Например, если a = 1, b = 2, надо, чтобы получилось b = 1, a = 2.
    Дополнительные переменные использовать нельзя.
</p>
<pre>
    $a = 1;
    $b = 2;
    $a += $b;
    $b = $a - $b;
    $a -= $b;
</pre>
<p class="task">6. Задание 4 сделать 3-я способами, как в лекции в конце.</p>
<p><a href="site01.php">Вариант с активным шаблоном</a></p>
<p><a href="site02.php">Вариант с вынесенным в отдельный файл кодом</a></p>
<p><a href="site03.php">Вариант с пассивным шаблоном</a></p>
</body>
</html>

