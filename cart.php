<?php
require_once "database.php";
startSession();
$info = getInfo();
if (empty($_SESSION['user'])) header("Location: ./");

$pay = false;
$error = false;
$error_msg = "";
$cart = getCart($_SESSION['user']);
if (isset($_POST['empty-cart'])) {
    emptyCart($_SESSION['user']);
    $cart = [];
} else if (isset($_POST['pay'])) {
    if (empty($cart)) {
        $error = true;
        $error_msg = "سبد خرید شما خالی است";
    } else {
        payCart($_SESSION['user']);
        $pay = true;
        $cart = [];
    }
}

$totalPrice = 0;

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/cart.css">
    <title>سبد خرید</title>
</head>
<body>

<?php
include_once "header.php";
?>

<section class="cart container">
    <div class="left">
        <?php
        if ($pay) {
            echo "<h3 class='success'>پرداخت شما با موفقیت انجام شد!</h3>";
        }
        if ($error) {
            echo "<h3 class='error'>$error_msg</h3>";
        }
        ?>
        <div class="items">
            <?php
            foreach ($cart as $item) {
                $book = getBook($item['book_id']);
                $total = $book['price'] * $item['quantity'];
                $totalPrice += $total;
                ?>
                <div class="item">
                    <img src="<?= $book['image'] ?>" alt="5 AM">
                    <div class="item-info">
                        <h3><?= $book['title'] ?></h3>
                        <div class="item-price">قیمت واحد: <span><?= number_format($book['price']) ?></span></div>
                        <div>تعداد: <span><?= $item['quantity'] ?></span></div>
                        <div class="item-total-price">قیمت کل:
                            <span><?= number_format($total) ?></span>
                        </div>
                        <form action="./add_to_cart.php" method="post" class="buttons">
                            <input type="text" name="back" value="./cart.php" hidden>
                            <input type="number" name="quantity" hidden value="1">
                            <input type="text" name="id" hidden value="<?= $book['id'] ?>">
                            <button type="submit" name="increase">+</button>
                            <button type="submit" name="decrease">-</button>
                        </form>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <div class="right">
        <div>تعداد محصولات: <span><?= cartCount($_SESSION['user']) ?></span></div>
        <div class="cart-total-price">قیمت نهایی: <span><?= number_format($totalPrice) ?></span></div>
        <div class="buttons">
            <form action="" method="post">
                <button type="submit" name="empty-cart">پاک کردن سبد خرید</button>
                <button type="submit" name="pay">پرداخت</button>
            </form>
        </div>
    </div>
</section>


<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>