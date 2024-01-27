<?php
include_once "checkLogin.php";
include_once "../functions.php";
include_once "../database.php";

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;

$result = [
    'success' => false,
    'error' => '',
    'msg' => '',
];

if (isset($_POST['submit'])) {
    $file = uploadImage($_FILES['image']);

    if (!$file && $_FILES['image']['name']) {
        $result['success'] = false;
        $result['error'] = 'خطا در آپلود عکس';
    } else {
        $res = editBook($id, $_POST['title'], $_POST['desc'], $_POST['author'], $_POST['publisher'], $_POST['lang'], $_POST['year'], $_POST['price'], $file);
        if ($res) {
            $result['success'] = true;
            $result['msg'] = 'کتاب با موفقیت ویرایش شد';
        } else {
            $result['success'] = false;
            $result['error'] = 'خطا در ویرایش کتاب';
        }
    }
}

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
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/add-post.css">
    <title>Admin Page</title>
</head>
<body>
<section class="container">
    <div></div>
    <?php
    include_once "right_panel.php";
    ?>
    <div class="content">
        <?php
        if ($result['success'] && $result['msg']) {
            echo '<h3 class="success">' . $result['msg'] . '</h3>';
        } elseif (!$result['success'] && $result['error']) {
            echo '<h3 class="error">' . $result['error'] . '</h3>';
        }
        ?>
        <form class="add-post" method="post" enctype="multipart/form-data">
            <input type="text" class="title" placeholder="نام کتاب" name="title" value="<?= $book['title'] ?>">
            <textarea name="desc" id="" cols="30" rows="10" class="desc" placeholder="توضیحات کتاب ..."><?= $book['description'] ?></textarea>
            <input type="text" class="author" placeholder="نویسنده" name="author" value="<?= $book['author'] ?>">
            <input type="text" class="publisher" placeholder="انتشارات" name="publisher"
                   value="<?= $book['publisher'] ?>">
            <label for="" class="lang">زبان:
                <select name="lang" id="">
                    <option value="fa" <?= $book['lang'] == 'fa' ? "selected" : "" ?>>فارسی</option>
                    <option value="en" <?= $book['lang'] == 'en' ? "selected" : "" ?>>انگلیسی</option>
                </select>
            </label>
            <input type="number" class="year" placeholder="سال" name="year" value="<?= $book['year'] ?>">
            <input type="text" class="price" placeholder="قیمت (ریال)" name="price" value="<?= $book['price'] ?>">
            <img src="<?= $book['image'] ?>" alt="<?= $book['publisher'] ?>">
            <input type="file" class="image" placeholder="تصویر جدید" name="image">
            <input type="submit" class="btn" value="ویرایش کتاب" name="submit">
        </form>
    </div>
</section>
</body>
</html>