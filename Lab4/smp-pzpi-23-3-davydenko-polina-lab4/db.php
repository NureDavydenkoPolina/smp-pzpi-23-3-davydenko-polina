<?php
$db = new PDO('sqlite:products.db');

$db->exec("DROP TABLE IF EXISTS products");
$db->exec("
    CREATE TABLE products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        price INTEGER NOT NULL
    )
");

$products = [
    ["🥛 Pasteurized Milk", 12],
    ["🍞 Black Bread", 9],
    ["🧀 White Cheese", 21],
    ["🥣 Sour Cream 20%", 25],
    ["🥤 Kefir 1%", 19],
    ["💧 Sparkling Water", 18],
    ["🍪 Cookies \"Весна\"", 14]
];

$stmt = $db->prepare("INSERT INTO products (name, price) VALUES (?, ?)");

foreach ($products as $product) {
    $stmt->execute($product);
}

echo "Базу даних створено та заповнено!";
?>
