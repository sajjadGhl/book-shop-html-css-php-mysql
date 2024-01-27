<?php
$filename = explode('/', $_SERVER['PHP_SELF']);
$filename = end($filename);
$filename = explode('.', $filename)[0];

$list = [
    'index' => ['class' => 'item', 'link' => './index.php', 'msg' => 'صفحه اصلی'],
    'purchases' => ['class' => 'item', 'link' => './purchases.php', 'msg' => 'لیست تراکنش ها'],
    'posts' => ['class' => 'item', 'link' => './posts.php', 'msg' => 'کتاب ها'],
    'add-post' => ['class' => 'item', 'link' => 'add-post.php', 'msg' => 'افزودن کتاب'],
    'logout' => ['class' => 'item', 'link' => './logout.php', 'msg' => 'خروج'],
];

?>
<div class="panel">
    <ul class="items">
        <?php
        foreach ($list as $name => $li) {
            if ($filename == $name) $li['class'] .= ' active';
            echo "<li class='".$li['class']."'><a href='".$li['link']."'>".$li['msg']."</a></li>";
        }
        ?>
    </ul>
</div>