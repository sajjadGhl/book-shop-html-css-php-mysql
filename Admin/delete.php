<?php
include_once "checkLogin.php";
include_once "../functions.php";
include_once "../database.php";

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;
$book = getBook($id);
if (!$book) {
    header("Location: ./404.php?delete=error");
}

if (deleteBook($id)) {
    header("Location: ./posts.php?delete=success");
} else {
    header("Location: ./posts.php?delete=error");
}
