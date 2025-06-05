<header>
    <nav class="top-nav">
        <a href="index.php?page=home" class="left">Home</a>
        <a href="index.php?page=products" class="center">Products</a>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?page=cart" class="right">Cart</a>
            <a href="index.php?page=profile" class="right">Profile</a>
            <a href="index.php?page=logout" class="right">Logout</a>
        <?php else: ?>
            <a href="index.php?page=login" class="right">Login</a>
        <?php endif; ?>
    </nav>
</header>
