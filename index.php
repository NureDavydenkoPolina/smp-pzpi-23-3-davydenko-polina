<?php
session_start();

$page = $_GET['page'] ?? 'home';

$publicPages = ['login', 'page404'];

ob_start(); 

if (!isset($_SESSION['user']) && !in_array($page, $publicPages)) {
    $contentPage = "page404.php";
} else {
    switch ($page) {
        case "cart":
            $contentPage = "cart.php";
            break;
        case "products":
            $contentPage = "products.php";
            break;
        case "home":
            $contentPage = "products.php";
            break;
        case "profile":
            $contentPage = "profile.php";
            break;
        case "login":
            $contentPage = "login.php";
            break;
        case "logout":
            $contentPage = "logout.php";
            break;
	case "profile":
    	    $contentPage = "profile.php";
    	    break;	
        default:
            $contentPage = "page404.php";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>My Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once("header.php"); ?>

<main>
    <?php require_once($contentPage); ?>
</main>

<?php require_once("footer.php"); ?>

</body>
</html>
<?php
ob_end_flush();
?>

