<?php
session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $image_id = (int) $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $image_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Video not found");
        }
    } else {
        die("ID video not specified");
    }
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="style/video.css">
    <link rel="stylesheet" href="style/swiper.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <img src="Assets/bg-products.jpg" alt="Background image" class="bg-image">

    <a href="index.php" class="back-button">← Back</a>

    <div class="container">
        <div class="image-details">
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>"></div>
                    <div class="swiper-slide"><img src="<?= htmlspecialchars($product['image2']); ?>" alt="<?= htmlspecialchars($product['name']); ?>"></div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            
            <p>
                <strong>Description :</strong> <?= htmlspecialchars($product['description']); ?>
            </p>
            <div class="details-container">
                <div class="details-left">
                    <p>
                        <strong>Upload Date :</strong> <?= htmlspecialchars($product['upload_date']); ?><br>
                        <strong>Price :</strong> <?= htmlspecialchars($product['price']); ?> €
                    </p>
                </div>
            </div>
            <div class="details-right">
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="Interactions/products_images.js"></script>
</body>
</html>