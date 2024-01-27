<?php
include_once "./checkLogin.php";
include_once "../database.php";
$purchases = getAllPurchases();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/purchases.css">
    <title>Posts</title>
</head>
<body>
<section class="container">
    <?php
    include_once "right_panel.php"
    ?>
    <div class="content">
        <div class="purchases">
            <div class="purchase info">
                <p class="id">شناسه</p>
                <h3 class="price">مبلغ کل</h3>
                <p>لینک جزئیات</p>
            </div>
            <?php
            foreach ($purchases as $index => $purch) {
                $totalPaidPrice = 0;
                foreach ($purch as $item) {
                    $totalPaidPrice += $item['unit_price'] * $item['quantity'];
                }
                ?>
                <div class="purchase">
                    <p class="id"><?= $index ?></p>
                    <h3 class="price"><?= number_format($totalPaidPrice) ?></h3>
                    <a href="./purchase.php?id=<?= $index ?>">جزئیات</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
</body>
</html>