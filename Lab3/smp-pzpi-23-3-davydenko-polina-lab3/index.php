<?php
session_start();

$products = [
    1 => ["name" => "🥛 Pasteurized Milk", "price" => 12],
    2 => ["name" => "🍞 Black Bread", "price" => 9],
    3 => ["name" => "🧀 White Cheese", "price" => 21],
    4 => ["name" => "🥣 Sour Cream 20%", "price" => 25],
    5 => ["name" => "🥤 Kefir 1%", "price" => 19],
    6 => ["name" => "💧 Sparkling Water", "price" => 18],
    7 => ["name" => "🍪 Cookies \"Весна\"", "price" => 14],
];

// Обробка покупки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($products as $id => $product) {
        $count = (int)($_POST["count_$id"] ?? 0);
        if ($count > 0) {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'count' => $count,
            ];
        }
    }
    header('Location: basket.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
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
    <h1>Welcome to our store!</h1>
    <p>We offer the best products at affordable prices.</p>

    <h2>Products</h2>
    <form method="POST">
        <table>
            <tr style="background-color:powderblue;"><th>Name</th><th>Price</th><th>Amount</th></tr>
            <?php foreach ($products as $id => $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?> грн</td>
                <td><input type="number" name="count_<?= $id ?>" min="0" value="0"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Add</button>
    </form>
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

