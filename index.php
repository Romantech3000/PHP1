<?php

define('TEMPLATES_DIR', 'views/');
define('LAYOUTS_DIR', 'layouts/');
define ('IMG_DIR', 'images/');
define ('TMB_DIR', 'thumbnails/');

define('TMB_SIZE', 200);

// main menu
set_time_limit(10);


if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

function getImageList1($dir) {
    $images = glob($dir . '*.{jpeg,jpg,png}', GLOB_BRACE);
}

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

function getImageList($dir) {
    return preg_grep('/\.(jpg|jpeg|png)$/i', scandir($dir));
}

function names2imgs($name) {
    return ['thumbnail' => TMB_DIR . $name, 'image' => IMG_DIR . $name, 'alt' => $name];
}

$layoutParams = [];
$templateParams = [];
switch ($page) {
    case 'index':
        $layoutParams = ['title' => 'Главная'];
        $template = 'index';
        break;
    case 'gallery':

        if (isset($_POST['upload'])) {
            //https://habr.com/ru/post/44610/ solution
            //$imageInfo = getimagesize($_FILES['img_file']['tmp_name']); $imageInfo['mime']
            //php.net=> Do not use getimagesize() to check that a given file is a valid image.
            // Use a purpose-built solution such as the Fileinfo extension instead.

            //in uploads directory .htaccess: php_flag engine off - don't run php scripts at all (+ forbid re-writing .htaccess file)

            $fExt = '.';
            if ($_FILES['img_file']['size'] > 5000000) {
                echo 'the file size is too large<br>';
                exit;
            };

            $mime = mime_content_type($_FILES['img_file']['tmp_name']); //newer: finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $filename );
            switch ($mime) {
                case 'image/png':
                    $fExt = '.png';
                    break;
                case 'image/jpeg':
                    $fExt = '.jpg';
                    break;
                default:
                    echo 'Unsupported file type. Please upload valid JPEG or PNG image.<br>';
                    exit;
            };
            //to check file extension pathinfo($fileName, PATHINFO_EXTENSION).﻿

            //$fileName = 'upload/'.basename($_FILES['img_file']['name']);
            //TODO make sure the file doesn't exist yet
            $fileName = uniqid('img_', true) . $fExt;
            $fullFileName = 'upload/'. $fileName;

            saveResizedImage($_FILES['img_file']['tmp_name'], IMG_DIR . $fileName, 1024);
            saveResizedImage($_FILES['img_file']['tmp_name'], TMB_DIR . $fileName, 200);

            if ($_FILES['img_file']['error'] === 0) {
                if (move_uploaded_file($_FILES['img_file']['tmp_name'], $fullFileName)) {
                    //echo 'File was successfully uploaded<br>';
                    header('Location: index.php?page=gallery&message=success' ); //$_SERVER['REQUEST_URI']
                } else {
                    echo 'Error: File upload failed<br>';
                }
            } else {
                echo "File upload error code: {$_FILES['img_file']['error']}<br>";
            }

        }

        $imgNames = getImageList(TMB_DIR);

        $layoutParams = ['title' => 'Image Gallery'];
        $templateParams = ['images' => array_map('names2imgs', $imgNames)];
        $template = 'gallery';
        break;
    default:
        $layoutParams = ['title' => '404 Not Found'];
        $template = '404';
}

function saveResizedImage($fileName, $newFileName, $newWidth = TMB_SIZE) {
    require_once 'classSimpleImage.php';
    $image = new SimpleImage();
    $image->load($fileName);
    $image->resizeToWidth($newWidth);
    $image->save($newFileName);
}

echo renderPage($template, $layoutParams, $templateParams);
