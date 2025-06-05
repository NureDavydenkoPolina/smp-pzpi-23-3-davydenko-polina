<?php

$db = new PDO('sqlite:products.db'); 

$products = [];
$stmt = $db->query("SELECT * FROM products");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[$row['id']] = $row;
}

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
    header("Location: index.php?page=cart");
    exit;
}
?>

<main>
    <h1>Welcome to our store!</h1>
    <p>We offer the best products at affordable prices.</p>

    <h2>Products</h2>
    <form method="POST">
        <table>
            <tr style="background-color:powderblue;"><th>Name</th><th>Price</th><th>Amount</th></tr>
            <?php foreach ($products as $id => $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?> грн</td>
                <td><input type="number" name="count_<?= $id ?>" min="0" value="0"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Add</button>
    </form>
</main>

