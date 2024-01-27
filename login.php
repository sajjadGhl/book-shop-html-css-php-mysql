<?php
require_once "database.php";
$info = getInfo();

startSession();
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: ./index.php');
}
$loginStatus = [
    'success' => false,
    'message' => '',
];

if (isset($_POST['btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $loginStatus['success'] = false;
        $loginStatus['message'] = 'نام کاربری و رمز عبور هر دو باید وارد شوند';
    } else {
        $login = loginCheck($username, $password);
        if (!$login) {
            $loginStatus['success'] = false;
            $loginStatus['message'] = 'نام کاربری یا رمز عبور اشتباه است';
        } else {
            $loginStatus['success'] = true;
            $_SESSION['user'] = $login;
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
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <title>فروشگاه کتاب | ورود</title>
</head>
<body>
<?php
include_once "header.php";
?>

<form class="container form" method="post">
    <?php
    if (!$loginStatus['success'] && $loginStatus['message']) {
        echo "<h3 class='failure'>" . $loginStatus['message'] . "</h3>";
    }
    ?>
    <div class="form-item">
        <label for="username">نام کاربری:</label>
        <input type="text" id="username" placeholder="نام کاربری" name="username">
    </div>
    <div class="form-item">
        <label for="password">رمز:</label>
        <input type="password" id="password" placeholder="رمز" name="password">
    </div>

    <input type="submit" value="ورود" name="btn">
</form>

<footer class="footer">
    <p><?= $info['footer'] ?></p>
</footer>

</body>
</html>