<?php
require_once "database.php";
startSession();
$info = getInfo();
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;
$book = getBook($id);
if (!$book) {
    header("Location: ./404.php");
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/details.css">
    <title>جزئیات محصول</title>
</head>
<body>

<?php
include_once "header.php";
?>

<section class="container">
    <div class="info">
        <div class="details">
            <h2 class="title"><?= $book['title'] ?></h2>
            <p class="desc"><?= $book['description'] ?>
            </p>
            <div class="book-info">
                <div>نویسنده: <span><?= $book['author'] ?></span></div>
                <div>انتشارات: <span><?= $book['publisher'] ?></span></div>
                <div>زبان: <span><?= $book['lang'] ?></span></div>
                <div>سال انتشار: <span><?= $book['year'] ?></span></div>
                <div>قیمت: <span><?= number_format($book['price']) ?> ریال </span></div>
            </div>
            <div class="links">
                <form action="./add_to_cart.php" class="add-to-cart" method="post">
                    <input type="text" name="id" hidden value="<?= $book['id'] ?>">
                    <input type="text" name="back" hidden value="./details.php?id=<?= $book['id'] ?>">
                    <button class="btn" type="submit" name="btn">افزودن به سبد خرید</button>
                </form>
                <a href="./" class="link">صفحه اصلی</a>
            </div>
        </div>
        <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>" class="cover">
    </div>

</section>


<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>