<?php

require '../config/conf.php';
require '../engine/functions.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}



logData(date('Y-m-d H:i:s ') . $_SERVER['REQUEST_URI'] . ' | ' . $_SERVER['HTTP_USER_AGENT']);

$layoutParams = [];
$templateParams = [];
$menu = renderTemplate('menu');





switch ($page) {
    case 'index':
        $layoutParams = ['title' => 'Главная', 'menu' => $menu];
        $template = 'index';
        break;
    case 'gallery':

        if (isset($_GET['message'])) {
            $message = getUploadErrorMessage($_GET['message']);
        } else {
            $message = '';
        }

        if (isset($_POST['upload'])) {

            function uploadImgFile() {
                //https://habr.com/ru/post/44610/ solution
                //$imageInfo = getimagesize($_FILES['img_file']['tmp_name']); $imageInfo['mime']
                //php.net=> "Do not use getimagesize() to check that a given file is a valid image.
                // Use a purpose-built solution such as the Fileinfo extension instead."

                //Security measures: MIME type checked, the images are renamed and the extension is changed according to the type
                // atm upload/ folder is left un public/ folder,
                //in uploads directory .htaccess: php_flag engine off - don't run php scripts at all (+ forbid re-writing .htaccess file)
                // upload (original images) should be probably moved outside www zone

                $mime = mime_content_type($_FILES['img_file']['tmp_name']); //newer: finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $filename );

                switch ($mime) {
                    case 'image/png':
                        $fExt = '.png';
                        break;
                    case 'image/jpeg':
                        $fExt = '.jpg';
                        break;
                    default:
                        return  ERR_UNSUPPORTED_IMG;
                };

                //to check file extension pathinfo($fileName, PATHINFO_EXTENSION).﻿

                if ($_FILES['img_file']['size'] > 5000000) {
                    return ERR_IMG_TOO_LARGE;
                };

                //$fileName = 'upload/'.basename($_FILES['img_file']['name']);
                //TODO make sure the file doesn't exist yet
                $fileName = uniqid('img_', true) . $fExt;
                $fullFileName = 'upload/'. $fileName;

                saveResizedImage($_FILES['img_file']['tmp_name'], IMG_DIR . $fileName, 1024);
                saveResizedImage($_FILES['img_file']['tmp_name'], TMB_DIR . $fileName, 200);

                if ($_FILES['img_file']['error'] === 0) {
                    if (move_uploaded_file($_FILES['img_file']['tmp_name'], $fullFileName)) {
                        return MSG_IMG_UPLOAD_SUCCESS;
                    } else {
                        //$message = 'Error: File upload failed';
                        return ERR_FILE_UPLOAD_FAILED;
                    }
                } else {
                    //echo  "File upload error code: {$_FILES['img_file']['error']}";
                    header('Location: index.php?page=gallery&message=' . ERR_FILE_UPLOAD_FAILED);  //$_SERVER['REQUEST_URI']
                }

            }

            header('Location: index.php?page=gallery&message='. uploadImgFile());

        }

        $imgNames = getImageList(TMB_DIR);

        $layoutParams = ['title' => 'Image Gallery', 'menu' => $menu];
        $templateParams = ['images' => array_map('names2imgs', $imgNames), 'message' => $message];
        $template = 'gallery';
        break;
    default:
        $layoutParams = ['title' => '404 Not Found'];
        $template = '404';
}



echo renderPage($template, $layoutParams, $templateParams);
