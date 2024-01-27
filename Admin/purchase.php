<?php
include_once "./checkLogin.php";
include_once "../database.php";
if (empty($_GET['id'])) {
    header("Location: ./");
}
$id = $_GET['id'];
$purchaseInfo = getPurchase($id);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/purchase.css">
    <title>Purchase | <?= $id ?></title>
</head>
<body>
<section class="container">
    <?php
    include_once "right_panel.php"
    ?>
    <div class="content">
        <div class="purchases">
            <div class="purchase info">
                <p class="id">شناسه کتاب</p>
                <p>عکس</p>
                <h3 class="title">عنوان کتاب</h3>
                <p class="price">قیمت واحد</p>
                <p>تعداد</p>
                <p class="price">قیمت کل</p>
            </div>
            <?php
            $totalPrice = 0;
            foreach ($purchaseInfo['books'] as $purchaseBook) {
                $book = getBook($purchaseBook['book_id']);
                $totalPrice += $purchaseBook['unit_price'] * $purchaseBook['quantity'];
                ?>
                <div class="purchase">
                    <p class="id"><?= $book['id'] ?></p>
                    <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>">
                    <h3 class="title"><?= $book['title'] ?></h3>
                    <p class="price"><?= number_format($purchaseBook['unit_price']) ?></p>
                    <p><?= number_format($purchaseBook['quantity']) ?></p>
                    <p class="price"><?= number_format($purchaseBook['unit_price'] * $purchaseBook['quantity']) ?></p>
                </div>
                <?php
            }
            ?>
            <div class="purchase report">
                <?php
                $user_id = $purchaseInfo['user_id'];
                $name = getName($user_id);
                ?>
                <div>
                    <h3>خریدار: </h3>
                    <p><?= " ($user_id) " . $name ?></p>
                </div>
                <div>
                    <h3 class="title"> قیمت کل: </h3>
                    <p class="price"><?= number_format($totalPrice) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>