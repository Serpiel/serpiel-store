<<<<<<< HEAD
<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $product_id;

    header("Location: cart.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
=======
<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $product_id;

    header("Location: cart.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
?>