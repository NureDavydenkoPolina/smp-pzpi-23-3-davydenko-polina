<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$success = "";
$profileFile = 'user_profile.php';
$profile = [
    'first_name' => '',
    'last_name' => '',
    'birth_date' => '',
    'about' => '',
    'photo' => ''
];

if (file_exists($profileFile)) {
    $profile = include $profileFile;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $birth_date = $_POST['birth_date'] ?? '';
    $about = trim($_POST['about'] ?? '');

    if (strlen($first_name) < 2) {
        $errors[] = 'Ім’я повинно містити мінімум 2 символи.';
    }

    if (strlen($last_name) < 2) {
        $errors[] = 'Прізвище повинно містити мінімум 2 символи.';
    }

    if (!$birth_date || (strtotime($birth_date) > strtotime('-16 years'))) {
        $errors[] = 'Користувачеві має бути мінімум 16 років.';
    }

    if (strlen($about) < 50) {
        $errors[] = 'Стисла інформація повинна містити щонайменше 50 символів.';
    }

    $photoPath = $profile['photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
            $errors[] = 'Формат фото має бути JPG або PNG.';
        } else {
            if (!is_dir('uploads')) {
                mkdir('uploads');
            }
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $newFileName = 'uploads/' . uniqid('profile_', true) . '.' . $ext;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $newFileName)) {
                $photoPath = $newFileName;
            } else {
                $errors[] = 'Не вдалося зберегти фото.';
            }
        }
    }

    if (empty($errors)) {
        $profile = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_date' => $birth_date,
            'about' => $about,
            'photo' => $photoPath
        ];

        file_put_contents($profileFile, '<?php return ' . var_export($profile, true) . ';');
        $success = "Профіль оновлено успішно!";
    }
}
?>

<h1>Профіль користувача</h1>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php elseif ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Ім’я: <input type="text" name="first_name" value="<?= htmlspecialchars($profile['first_name']) ?>" required></label><br><br>
    <label>Прізвище: <input type="text" name="last_name" value="<?= htmlspecialchars($profile['last_name']) ?>" required></label><br><br>
    <label>Дата народження: <input type="date" name="birth_date" value="<?= htmlspecialchars($profile['birth_date']) ?>" required></label><br><br>
    <label>Про себе:<br>
        <textarea name="about" rows="6" cols="60" required><?= htmlspecialchars($profile['about']) ?></textarea>
    </label><br><br>
    <label>Фото: <input type="file" name="photo" accept="image/png, image/jpeg"></label><br><br>

    <?php if (!empty($profile['photo']) && file_exists($profile['photo'])): ?>
        <img src="<?= $profile['photo'] ?>" alt="Фото користувача" style="max-width:150px; display:block; margin-top:10px;">
    <?php endif; ?>

    <button type="submit">Зберегти</button>
</form>
