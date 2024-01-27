<?php

define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
//define('SITE_ROOT', $_SERVER['SERVER_NAME']);

function uploadImage($file, $target_dir = "/assets/images/books/")
{
    if (!$file) return false;
    $target_file = SITE_ROOT . $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $uploadOk = getimagesize($file["tmp_name"]); // check for fake image
    $uploadOk = $uploadOk && !file_exists($target_file); // check for existed image
    $uploadOk = $uploadOk && $file["size"] <= 5e6; // 5,000,000 - Less than 5MB
    $uploadOk = $uploadOk && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif']); // valid formats

    $imgUrl = "http://usefull.ir".$target_dir.basename($file['name']);
    return $uploadOk && move_uploaded_file($file["tmp_name"], $target_file) ? $imgUrl : false;
}

function multiple_empty(...$arguments)
{
    foreach ($arguments as $argument)
        if (empty($argument)) return true;
    return false;
}

function startSession() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
        ob_start();
    }
}