<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_id'])) {
        $removeId = $_POST['remove_id'];
        unset($_SESSION['cart'][$removeId]);
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
    // Обробка оплати чи скасування (демо)
    if (isset($_POST['pay'])) {
        $_SESSION['cart'] = [];
        header('Location: basket.php');
        exit;
    }
    if (isset($_POST['cancel'])) {
        $_SESSION['cart'] = [];
        header('Location: basket.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav class="top-nav">
        <a href="index.php" class="left">Home</a>
        <a href="index.php" class="center">Products</a>
        <a href="basket.php" class="right">Cart</a>
    </nav>
</header>

<main>
    <h1>Your Cart</h1>
    <?php if (empty($cart)): ?>
        <p><a href="index.php">Go to shopping</a></p>
    <?php else: ?>
        <form method="POST">
            <table>
                <tr style="background-color:powderblue;">
                    <th>ID</th><th>Name</th><th>Price</th><th>Amount</th><th>Sum</th><th>Delete</th>
                </tr>
                <?php $total = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['price'] ?> грн</td>
                        <td><?= $item['count'] ?></td>
                        <td><?= $item['price'] * $item['count'] ?> грн</td>
                        <td>
                            <button type="submit" name="remove_id" value="<?= $item['id'] ?>" class="trash-button">🗑️</button>
                        </td>
                    </tr>
                    <?php $total += $item['price'] * $item['count']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td><strong><?= $total ?> грн</strong></td>
                    <td></td>
                </tr>
            </table>

            <div class="button-group">
                <button type="submit" name="pay">Pay</button>
                <button type="submit" name="cancel">Cancel</button>
            </div>
        </form>
    <?php endif; ?>
</main>

<footer>
    <div class="bottom-nav">
        <a href="index.php">Home</a> |
        <a href="index.php">Products</a> |
        <a href="basket.php">Cart</a> |
        <a href="#">About Us</a>
    </div>
</footer>
</body>
</html>

