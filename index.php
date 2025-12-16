<<<<<<< HEAD

<?php include 'bdd.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Welcome</title>
    <link rel="icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="style/content.css">
</head>
<script src="Interactions/video.js"></script>
<body>
    <?php include 'navbar.php'; ?>
    <!-- Vidéo desktop -->
    <video autoplay muted playsinline id="video-desktop">
        <source src="Assets/serpiel_logo.mp4" type="video/mp4">
    </video>

    <!-- Vidéo mobile -->
    <video autoplay muted playsinline id="video-mobile">
        <source src="Assets/serpiel_logo_mobile.mp4" type="video/mp4">
    </video>
    <?php include 'footer.php'; ?>
</body>
=======
<?php session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, image, image2, price FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection error : " . $e->getMessage();
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product_id;
    header("Location:cart.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products catalog</title>
    <link rel="stylesheet" href="style/products.css">
</head>
<body>
    <?php include 'navbar.php' ?>

    <h1>Main</h1>

    <img src="Assets/bg-products.jpg" alt="Background image" class="bg-image">
    <a href="cart.php"><button class="product-see-cart" type="submit">See the cart</button></a>

    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <div class="product-image-container">
                    <a href="video.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                        <img class="product-image" src="<?= htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <img class="product-image2" src="<?= htmlspecialchars($product['image2']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                </div>
                <h2>
                        <?php echo htmlspecialchars($product['name']); ?>
                </h2>
                
                <p>Price: €<?php echo htmlspecialchars($product['price']); ?></p>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button class="product-add-cart" type="submit" name="add_to_cart">Add to cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    

    <?php include 'footer.php'; ?>
</body>
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
</html>