<?php
include_once "./checkLogin.php";
include_once "../database.php";
$books = getBooks();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/posts.css">
    <title>Posts</title>
</head>
<body>
    <section class="container">
        <?php
        include_once "right_panel.php"
        ?>
        <div class="content">
            <?php
            if (@$_GET['delete'] && $_GET['delete'] == "success") {
                echo "<h1 class='success'>کتاب مورد نظر با موفقیت حذف شد.</h1>";
            } else if (@$_GET['delete'] && $_GET['delete'] == "error") {
                echo "<h1 class='error'>خطا در حذف کتاب شما</h1>";
            }
            ?>
            <div class="posts">
                <?php
                foreach ($books as $book) { ?>
                    <div class="post">
                        <p class="id"><?= $book['id'] ?></p>
                        <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>">
                        <h3 class="title"><?= $book['title'] ?></h3>
                        <p class="desc"><?= $book['description'] ?></p>
                        <a href="./edit.php?id=<?= $book['id'] ?>">ویرایش</a>
                        <a href="./delete.php?id=<?= $book['id'] ?>">حذف</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>