<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .navbar {
        width: 100%;
        background: #2c3e50;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    .navbar a {
        color: #fff;
        text-decoration: none;
        margin-right: 20px;
        font-weight: bold;
    }

    .navbar a:hover {
        text-decoration: underline;
    }

    .nav-right {
        display: flex;
        align-items: center;
    }
</style>

<div class="navbar">
    <div class="nav-left">
        <a href="products.php">Home</a>
        <a href="cart.php">View Cart</a>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION['name'])): ?>
            <span style="margin-right:15px;">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="../src/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>