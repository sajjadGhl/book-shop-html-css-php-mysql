<?php
require_once "database.php";
$info = getInfo();

startSession();
if (isset($_SESSION['user']) && $_SESSION['user']) {
    header("Location: ./");
}

// Sign up data
$error = [
    'name' => null,
    'username' => null,
    'email' => null,
    'password' => null,
    'confirm-password' => null,
];
$success = false;
$submit = false;
if (isset($_POST['submit'])) {
    $submit = true;
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password != $confirmPassword) $error['confirm-password'] = 'رمزهای وارد شده مطابقت ندارند';
    else $success = insertUser($name, $username, $email, $password);
}

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <title>فروشگاه کتاب | ثبت نام</title>
</head>
<body>

<?php
include_once "header.php";
?>

<form class="container form" action="" method="post">
    <?php
    if ($submit) { ?>
        <h1 class="<?= $success ? 'success' : 'failure' ?>"><?= $success ? 'ثبت نام موفقیت آمیز بود' : 'مشکلی در ثبت نام وجود داشت' ?></h1>
    <?php }
    ?>

    <div class="form-item">
        <label for="name">نام:</label>
        <input type="text" id="name" placeholder="نام" name="name">
    </div>
    <div class="form-item">
        <label for="username">نام کاربری:</label>
        <input type="text" id="username" placeholder="نام کاربری" name="username">
    </div>
    <div class="form-item">
        <label for="email">ایمیل:</label>
        <input type="text" id="email" placeholder="ایمیل" name="email">
    </div>
    <div class="form-item">
        <label for="password">رمز:</label>
        <input type="password" id="password" placeholder="رمز" name="password">
    </div>
    <div class="form-item">
        <label for="confirm-password">تایید رمز:</label>
        <input type="password" id="confirm-password" placeholder="تایید رمز" name="confirm-password">
    </div>

    <input type="submit" value="ثبت نام" name="submit">
</form>

<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>