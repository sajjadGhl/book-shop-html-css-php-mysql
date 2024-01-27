<?php
require_once "database.php";
startSession();
$info = getInfo();
$books = getBooks();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Book Shop</title>
</head>
<body>

<?php
include_once "header.php";
?>

<div class="header-content container">
    <div class="right">
        <img src="<?= $info['header_img'] ?>" alt="Books">
    </div>
    <div class="left">
        <h1><?= $info['header_title'] ?></h1>
        <p><?= $info['header_desc'] ?></p>

    </div>
</div>

<section class="container books">
    <h3 class="books-title">کتاب ها</h3>
    <div class="carts">
        <?php
        foreach ($books as $book) { ?>
            <div class="cart">
                <a href="./details.php?id=<?= $book['id'] ?>" class="cart-link">
                    <img src="<?= $book['image'] ?>" alt="5 AM" class="cart-img">
                    <div class="cart-details">
                        <h6 class="cart-title"><?= $book['title'] ?></h6>
                        <span class="cart-price"><?= number_format($book['price']) ?></span>
                    </div>
                </a>
                <form action="./add_to_cart.php" class="add-to-cart" method="post">
                    <input type="text" name="id" hidden value="<?= $book['id'] ?>">
                    <input type="text" name="back" hidden value="./">
                    <button class="cart-btn btn" type="submit" name="btn">افزودن به سبد خرید</button>
                </form>
            </div>
        <?php }
        ?>
    </div>
</section>

<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>