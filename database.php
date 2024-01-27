<?php

include_once "functions.php";

$host = 'localhost';
//$username = 'usefull2_book_shop';
//$password = '&GL?Yl&E$uXV';
//$dbname = 'usefull2_book_shop';
$username = 'root';
$password = '';
$dbname = 'book_shop';

$db = mysqli_connect($host, $username, $password, $dbname);
if (!$db) die("Error, Can't connect to database");

function getInfo()
{
    global $db;
    $query = "SELECT * FROM `info` LIMIT 1";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_assoc($result);
}

function getBooks()
{
    global $db;
    $query = "SELECT * FROM `books`";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getBook($id)
{
    global $db;
    $query = "SELECT * FROM `books` WHERE id=$id";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_assoc($result);
}

function hashPassword($password)
{
    return sha1($password);
}

function insertUser($name, $username, $email, $password)
{
    if (multiple_empty($name, $username, $email, $password)) return false;
    global $db;
    $password = hashPassword($password);
    $query = "INSERT INTO `users` (name, username, email, password) VALUES('$name', '$username', '$email', '$password')";
    $result = mysqli_query($db, $query);
    return $result;
}

function loginCheck($username, $password)
{
    if (empty($username) || empty($password)) return false;
    global $db;
    $password = hashPassword($password);
    $query = "SELECT * FROM `users` WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)['id'] : false;
}

function getName($id)
{
    global $db;
    $query = "SELECT * FROM `users` WHERE id='$id'";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_assoc($result)['name'];
}

function adminLoginCheck($username, $password)
{
    if (empty($username) || empty($password)) return false;
    global $db;
    $username = strtolower($username);
    $password = hashPassword($password);
    $query = "SELECT * FROM `admins` WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result) > 0;
}

function addBook($title, $desc, $author, $publisher, $lang, $year, $price, $image)
{
    if (multiple_empty($title, $desc, $author, $publisher, $lang, $year, $price, $image)) return false;
    global $db;
    $query = "INSERT INTO `books` (title, description, author, publisher, lang, year, price, image) VALUES('$title', '$desc', '$author', '$publisher', '$lang', '$year', '$price', '$image')";
    $result = mysqli_query($db, $query);
    return $result;
}

function editBook($id, $title = "", $desc = "", $author = "", $publisher = "", $lang = "", $year = "", $price = "", $image = "")
{
    if (empty($id)) return false;
    global $db;
    $query = "UPDATE `books` SET ";
    if ($title) $query .= "title='$title',";
    if ($desc) $query .= "description='$desc',";
    if ($author) $query .= "author='$author',";
    if ($publisher) $query .= "publisher='$publisher',";
    if ($lang) $query .= "lang='$lang',";
    if ($year) $query .= "year='$year',";
    if ($price) $query .= "price='$price',";
    if ($image) $query .= "image='$image',";
    $query = rtrim($query, ',');
    $query .= " WHERE id='$id'";
    return mysqli_query($db, $query);
}

function deleteBook($id)
{
    global $db;
    $query = "DELETE FROM `books` WHERE id='$id'";
    return mysqli_query($db, $query);
}

function addToCart($user_id, $book_id, $quantity = 1)
{
    if (multiple_empty($user_id, $book_id)) return false;
    global $db;
    // add quantity if added to cart tbl
    $query = "SELECT * FROM `cart` WHERE user_id='$user_id' AND book_id='$book_id'";
    $res = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($res);
    if ($data != null) {
        $new_quantity = $data['quantity'] + $quantity;
        if ($new_quantity < 1) {
            // Delete from cart
            $query = "DELETE FROM `cart` WHERE user_id='$user_id' AND book_id='$book_id'";
        } else {
            $query = "UPDATE `cart` SET quantity='$new_quantity' WHERE user_id='$user_id' AND book_id='$book_id'";
        }
        return mysqli_query($db, $query);
    }
    // add to cart tbl
    $query = "INSERT INTO `cart` (user_id, book_id, quantity) VALUES('$user_id', '$book_id', '$quantity')";
    return mysqli_query($db, $query);
}

function getCart($user_id)
{
    global $db;
    $query = "SELECT * FROM `cart` WHERE user_id='$user_id'";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function cartCount($user_id)
{
    if ($user_id < 1) return 0;
    global $db;
    $query = "SELECT COUNT(*) as cnt FROM `cart` WHERE user_id='$user_id'";
    $result = mysqli_query($db, $query);
    return mysqli_fetch_assoc($result)['cnt'];
}

function emptyCart($user_id)
{
    global $db;
    $query = "DELETE FROM `cart` WHERE user_id='$user_id'";
    return mysqli_query($db, $query);
}

function addToPurchases($user_id)
{
    global $db;
    $query = "INSERT INTO `purchases` (user_id) VALUES ('$user_id');";
    if (mysqli_query($db, $query))
        return mysqli_insert_id($db);
    return -1;
}

function payCart($user_id)
{
    global $db;
    $cart = getCart($user_id);
    $purchaseID = addToPurchases($user_id);

    if ($purchaseID == -1) return false;

    $query = "INSERT INTO `purchased_books` (purchased_id, book_id, unit_price, quantity) VALUES ";
    foreach ($cart as $book) {
        $book_id = $book['book_id'];
        $book_info = getBook($book_id);
        $price = $book_info['price'];
        $quantity = $book['quantity'];
        $query .= "('$purchaseID', '$book_id', '$price', '$quantity'),";
    }
    $query = substr_replace($query, ";", -1);
    mysqli_query($db, $query);
    emptyCart($user_id);
    return true;
}

function getAllPurchases()
{
    global $db;
    $query = "SELECT * FROM `purchased_books` WHERE `purchased_id` IN (SELECT id FROM `purchases`) ORDER BY id DESC";
    $result = mysqli_query($db, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $finalResult = [];
    foreach ($rows as $row) {
        $finalResult[$row['purchased_id']][] = $row;
    }
    return $finalResult;
//    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPurchase($purchase_id) {
    global $db;
    $query = "SELECT * FROM `purchases` WHERE id='$purchase_id'";
    $purchaseResult = mysqli_query($db, $query);
    $purchaseInfo = mysqli_fetch_assoc($purchaseResult);

    $query = "SELECT book_id, unit_price, quantity FROM `purchased_books` WHERE purchased_id='$purchase_id'";
    $purchaseBooksResult = mysqli_query($db, $query);
    $purchaseBooksInfo = mysqli_fetch_all($purchaseBooksResult, MYSQLI_ASSOC);

    return [
        'user_id' => $purchaseInfo['user_id'],
        'time' => $purchaseInfo['time'],
        'books' => $purchaseBooksInfo,
    ];
}