<?php

ob_start();
$rand10 = function () {
    return rand(-10, 10);
};
$a = $rand10();
$b = $rand10();
echo "<h2>Задание 1</h2>";
echo "a = {$a}, b = {$b}<br>";

if ($a < 0 && $b < 0) echo "a * b =" . ($a * $b);
elseif ($a >= 0 && $b >= 0) echo "a - b =" . ($a - $b);
else echo "a + b = " . ($a + $b);

echo "<br>";

//ternary
if ($a < 0) echo ($b < 0) ? $a * $b : $a + $b;
else echo ($b < 0) ? $a + $b : $a - $b;


echo "<br><hr><h2>Задание 2</h2>";

$a = rand(0, 15);
echo "a = {$a}<br>";

$i = $a;
switch ($a) {
    case 0:
        echo $i++, '&nbsp;';
    case 1:
        echo $i++, '&nbsp;';
    case 2:
        echo $i++, '&nbsp;';
    case 3:
        echo $i++, '&nbsp;';
    case 4:
        echo $i++, '&nbsp;';
    case 5:
        echo $i++, '&nbsp;';
    case 6:
        echo $i++, '&nbsp;';
    case 7:
        echo $i++, '&nbsp;';
    case 8:
        echo $i++, '&nbsp;';
    case 9:
        echo $i++, '&nbsp;';
    case 10:
        echo $i++, '&nbsp;';
    case 11:
        echo $i++, '&nbsp;';
    case 12:
        echo $i++, '&nbsp;';
    case 13:
        echo $i++, '&nbsp;';
    case 14:
        echo $i++, '&nbsp;';
    case 15:
        echo $i++, '&nbsp;';
        break;
    default:
        echo 'Error: the number is out of range';
}

// "сделайте через цикл if". "цикл if" - что бы это значило?.
echo "<br>*<br>";

// т.к. while и for использовать нельзя, использую goto:
begin:
echo $a++, '&nbsp;';
if ($a <= 15) goto begin;


//echo "<br><hr><h2>Задание 3</h2>";

function add($a, $b) {
    return $a + $b;
}

function subtract($a, $b) {
    return $a - $b;
};

function multiply($a, $b) {
    return $a * $b;
};

function divide($a, $b) {
    if ($b == 0) {
        echo "Error: division by zero<br>";
        return INF;
    }
    return $a / $b;
};

echo "<br><hr><h2>Задания 3, 4</h2>";


function mathOperation($arg1, $arg2, $operation)
{
    switch ($operation) {
        case "add":
        case "subtract":
        case "multiply":
        case "divide":
            return $operation($arg1, $arg2);
        default:
            echo "Error: invalid operation";
            return NULL;
    }
}


$a = $rand10();
$b = $rand10();
echo "a = {$a}, b = {$b}<br>";
echo "add: ", mathOperation($a, $b, "add"), "<br>";
echo "subtract: ", mathOperation($a, $b, "subtract"), "<br>";
echo "multiply: ", mathOperation($a, $b, "multiply"), "<br>";
echo "divide: ", mathOperation($a, $b, "divide"), "<br>";

echo "<br><hr><h2>Задание 6</h2>";

function power($val, $pow) {
    if ($pow == 0) return 1;
    if ($pow == 1) return $val;
    if ($pow > 0) return power($val, $pow-1) * $val;
    else return power($val, $pow+1) / $val;
}

$base = rand(5, 50);
$exp = rand(-5, 5);
echo "{$base} to the exponent {$exp} is ".power($base, $exp);

// closure
// the semantics is not exactly clear
$powerClosure = function ($val, $pow) use (&$powerClosure) {
    if ($pow == 0) return 1;
    if ($pow == 1) return $val;
    if ($pow > 0) return $powerClosure($val, $pow-1) * $val;
    else return $powerClosure($val, $pow+1) / $val;
};

echo "<br>{$base} to the exponent {$exp} is ".$powerClosure($base, $exp);

echo "<br><hr><h2>Задание 7</h2>";


function curTimeRus() {
    function wordFormsRus($num, $form1, $form2, $form3) {
        $rem10 = $num % 10;
        if ($rem10 == 0 || $rem10 > 4 || $num == 11 || $num == 12 || $num == 13 || $num == 14) return $form3;
        if ($rem10 == 1) return $form1;
        return $form2;
    }

    $time = time();
    $hrs = +date("H", $time);
    $mins = +date("i", $time);
    return $hrs . ' ' . wordFormsRus($hrs, "час", 'часа', "часов") . ' '
        . $mins . ' ' . wordFormsRus($mins, "минута", 'минуты', "минут");
}

echo '<br>Текущее время: ' . curTimeRus();
$tasksContent = ob_get_clean();

function renderTemplate($template, $content = "", $title = "") {
    ob_start();
    include $template.".php";
    return ob_get_clean();
}

$mainContent = renderTemplate("tasks", $tasksContent);

$title = "Main Page";
echo renderTemplate("layout", $mainContent, $title);