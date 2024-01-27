<header class="header">
    <div>
        <div class="top-header">
            <div class="logo">
                <img src="./assets/images/logo.png" alt="Book Store">
            </div>
            <a href="./" class="top-header-title">فروشگاه کتاب</a>
            <div class="cart">
                <a href="./cart.php" class="btn cart-btn">
                    <img src="./assets/images/basket.png" alt="Basket">
                    <p>سبد خرید</p>
                    <span><?= cartCount(isset($_SESSION['user']) ? $_SESSION['user'] : -1) ?></span>
                </a>
                <?php
                if (isset($_SESSION['user']) && $_SESSION['user']) {
                    echo "<p class='welcome'>خوش آمدید <span>" . getName($_SESSION['user']) . "</span></p>";
                }
                ?>
            </div>
        </div>
        <ul class="header-list">
            <li><a href="./">خانه</a></li>
            <li><a href="./cart.php">سبد خرید</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) {
                echo <<<EOL
            <li><a href="./logout.php">خروج</a></li>
EOL;
            } else {
                echo <<<EOL
            <li><a href="./signup.php">ثبت نام</a></li>
            <li><a href="./login.php">ورود</a></li>
EOL;
            }
            ?>
        </ul>
    </div>
</header>