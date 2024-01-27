<?php
require_once "./database.php";
startSession();
$info = getInfo();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/404.css">
    <title>404 | صفحه شما پیدا نشد :(</title>
</head>
<body>

<?php
include_once "header.php";
?>

<section class="container">
    <div class="info">
        <h1 class="error">صفحه مورد نظر شما پیدا نشد :((</h1>
        <a href="./" class="link">بازگشت به فروشگاه</a>
    </div>

</section>


<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>