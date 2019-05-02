<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic">
    <link rel="stylesheet" href="../../styles.css">

</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="container">
            <h2>PHP1. Lesson 3. Homework</h2>
        </div>
    </header>
    <nav>
    <?=$menu?>
    </nav>
    <main>
        <div class="container">
            <?=$content?>
        </div>
    </main>
</div>
<footer class="footer">
    <p class="copy">
        &copy;2000-<?=date("Y")?>
    </p>
</footer>
</body>
</html>
