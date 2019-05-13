<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="top-wrapper">
    <header class="header">
        <h2>PHP1. Lesson 4 Homework</h2>
    </header>
    <nav>
        <div class="container"><?=$menu?></div>
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
