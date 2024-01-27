<?php
include_once "../database.php";
$siteInfo = getInfo();
startSession();
if (isset($_SESSION['login']) && $_SESSION['login'] == 'OK') {
    header('Location: ./index.php');
    die;
}
$info = [
    'success' => false,
    'message' => '',
];

if (isset($_POST['btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $info['success'] = false;
        $info['message'] = 'نام کاربری و رمز عبور هر دو باید وارد شوند';
    } else {
        $loginStatus = adminLoginCheck($username, $password);
        if (!$loginStatus) {
            $info['success'] = false;
            $info['message'] = 'نام کاربری یا رمز عبور اشتباه است';
        } else {
            $info['success'] = true;
            $_SESSION['login'] = 'OK';
            header('Location: ./index.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <title>Login</title>
</head>
<body>

<div class="container">
    <h1>ورود</h1>
    <?php
    if ($info['message'] != '' && !$info['success']) {
        echo '<h2 class="error">'.$info['message'].'</h2>';
    }
    ?>
    <form class="form" method="post">
        <label><input type="text" placeholder="نام کاربری" name="username"/></label>
        <label><input type="password" placeholder="رمز عبور" name="password"/></label>
        <div>
            <button type="submit" name="btn">Login</button>
            |
            <a href="../">بازگشت به صفحه اصلی</a>
        </div>
    </form>
</div>

<footer class="footer">
    <p>
        <?= $siteInfo['footer'] ?>
    </p>
</footer>

</body>
</html>