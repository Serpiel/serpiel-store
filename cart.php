<<<<<<< HEAD
<?php 
session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, image, image2, price FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection error : " . $e->getMessage();
    exit;
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product_id;
    header("Location: cart.php");
    exit;
}

if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $key = array_search($item_id, $_SESSION['cart']);

        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cart</title>
    <link rel="stylesheet" href="style/cart.css">
</head>
<body>
    <?php include 'navbar.php';?>
    <img src="Assets/bg-products.jpg" alt="Background image" class="bg-image">
    <div class="cart-container">
        <h1>Your Cart</h1>

        <?php if (!empty($cart_items)): ?>
            <div class="cart-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // On va créer un tableau pour compter la quantité de chaque produit
                        $quantities = array_count_values($cart_items); 

                        foreach ($quantities as $item_id => $quantity): 
                            // Trouver le produit dans le tableau des produits
                            $product = array_filter($products, function($prod) use ($item_id) {
                                return $prod['id'] == $item_id;
                            });
                            $product = array_values($product)[0];

                            $total_price = $product['price'] * $quantity; // Calcul du prix total pour ce produit
                            $total += $total_price; // Total global du panier
                        ?>
                        <tr>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>€<?php echo $product['price']; ?></td>
                            <td><?php echo $quantity; ?></td> <!-- Afficher la quantité -->
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" name="add_to_cart">Add</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                                    <button type="submit" name="remove_item">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <p>Total: €<?php echo $total; ?></p>
                <form method="post">
                    <button type="submit" name="clear_cart" class="clear-cart-button">Clear cart</button>
                </form>

                <form method="get" action="checkout.php">
                    <button type="submit" class="submit-cart-button">Submit cart</button>
                </form>
            </div>
        <?php else: ?>
            <p class="cart-message">Your cart is empty.</p>
        <?php endif; ?>

        <div class="return-link">
            <a href="store.php">Return to the catalog</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
=======
<?php 
session_start();

include 'bdd.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, image, image2, price FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection error : " . $e->getMessage();
    exit;
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product_id;
    header("Location: cart.php");
    exit;
}

if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $key = array_search($item_id, $_SESSION['cart']);

        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style/cart.css">
</head>
<body>
    <?php include 'navbar.php';?>
    <img src="Assets/bg-products.jpg" alt="Background image" class="bg-image">
    <div class="cart-container">
        <h1>Your Cart</h1>

        <?php if (!empty($cart_items)): ?>
            <div class="cart-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // On va créer un tableau pour compter la quantité de chaque produit
                        $quantities = array_count_values($cart_items); 

                        foreach ($quantities as $item_id => $quantity): 
                            // Trouver le produit dans le tableau des produits
                            $product = array_filter($products, function($prod) use ($item_id) {
                                return $prod['id'] == $item_id;
                            });
                            $product = array_values($product)[0];

                            $total_price = $product['price'] * $quantity; // Calcul du prix total pour ce produit
                            $total += $total_price; // Total global du panier
                        ?>
                        <tr>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>€<?php echo $product['price']; ?></td>
                            <td><?php echo $quantity; ?></td> <!-- Afficher la quantité -->
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" name="add_to_cart">Add</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                                    <button type="submit" name="remove_item">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <p>Total: €<?php echo $total; ?></p>
                <form method="post">
                    <button type="submit" name="clear_cart" class="clear-cart-button">Clear cart</button>
                </form>

                <form method="get" action="checkout.php">
                    <button type="submit" class="submit-cart-button">Submit cart</button>
                </form>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <div class="return-link">
            <a href="index.php">Return to the catalog</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
