<?php
include 'bdd.php';

if (isset($_GET['query'])) {
    $search = htmlspecialchars($_GET['query']);

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=$dbname", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error connexion : " . $e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query");
    $stmt->execute(['query' => '%' . $search . '%']);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style/search.css">
    <link rel="stylesheet" href="style/swiper.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <br><br><br><br>
    <img src="Assets/bg-products.jpg" alt="Background image" class="bg-image">
    <h1>Results for "<?= htmlspecialchars($search) ?>"</h1>
    <div class="product-list"> 
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $product): ?>
                <div class="product-item">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>"></div>
                            <div class="swiper-slide"><img src="<?= htmlspecialchars($product['image2']); ?>" alt="<?= htmlspecialchars($product['name']); ?>"></div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    
                    <h2>
                        <a href="video.php?id=<?= htmlspecialchars($product['id']); ?>">
                            <?= htmlspecialchars($product['name']); ?>
                        </a>
                    </h2>
                    <div class="image-details">
                    <p>Price : €<?= htmlspecialchars($product['price']) ?></p>
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No results found for the search.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="Interactions/products_images.js"></script>
</body>
</html>