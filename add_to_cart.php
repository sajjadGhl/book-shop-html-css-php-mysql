<?php
require_once "database.php";
startSession();
$info = getInfo();
$id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : -1;
$back_url = $_POST['back'] ?: './';
$quantity = isset($_POST['increase']) ? $_POST['quantity'] : (isset($_POST['decrease']) ? -1 * $_POST['quantity'] : 1);
$book = getBook($id);
if (!$book) header("Location: ./404.php");


if (empty($_SESSION['user'])) header("Location: ./login.php?error=login+first");

addToCart($_SESSION['user'], $id, $quantity);

header("Location: $back_url");
