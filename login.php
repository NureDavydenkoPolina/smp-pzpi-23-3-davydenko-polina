<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!$login || !$password) {
        $errors[] = 'Please enter both username and password.';
    } else {
        $credentials = require 'credential.php';

        if ($login === $credentials['userName'] && $password === $credentials['password']) {
            $_SESSION['user'] = $login;
            $_SESSION['login_time'] = date("Y-m-d H:i:s");
            header("Location: index.php?page=products");
            exit;
        } else {
            $errors[] = 'Invalid login or password.';
        }
    }
}
?>

<h1>Login</h1>

<?php foreach ($errors as $error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endforeach; ?>

<form method="POST">
    <label>Username: <input type="text" name="username" required></label><br><br>
    <label>Password: <input type="password" name="password" required></label><br><br>
    <button type="submit">Login</button>
</form>

