<?php

function saveResizedImage($fileName, $newFileName, $newWidth = TMB_SIZE) {
    require_once '../engine/classSimpleImage.php';
    $image = new SimpleImage();
    $image->load($fileName);
    $image->resizeToWidth($newWidth);
    $image->save($newFileName);
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


function getUploadErrorMessage($messageCode) {
    switch ($_GET['message']) {
        case MSG_IMG_UPLOAD_SUCCESS:
            $message = 'Изображение успешно загружено';
            break;
        case ERR_IMG_LOADING:
            $message = 'Ошибка загрузки изображения';
            break;
        case ERR_UNSUPPORTED_IMG:
            $message = 'Неподдерживаемый тип изображения. Загрузите изображение формата JPEG or PNG.';
            break;
        case ERR_IMG_TOO_LARGE:
            $message = 'Превышен максимальный размер изображения';
            break;
        case ERR_FILE_UPLOAD_FAILED:
            $message = 'Ошибка загрузки файла';
            break;
        default:
            $message = 'Ошибочное сообщение';
    };
    return $message;
}