<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="style/border.css">
</head>

<body>
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    ?>
    <div class="navbar">
        <div class="search-bar">
            <form action="search.php" method="get" style="display: flex; align-items: center;">
                <input type="text" name="query" placeholder="Search a product..." required>
                <button type="submit" style="background: none; border: none; padding: 0; margin-left: 5px;">
                    <img src="Assets/loupe_icon.gif" alt="Search" class="search-icon">
                </button>
            </form> 
        </div>
        <div class="navbar-left">
            <a href ="welcome.php" ><img src="Assets/SERPIEL_logo.png" alt="SERPIEL_logo" class="logo"></a>
        </div>

        <div class="navbar-right">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="welcome.php" class="cart-link">
                    <img src="Assets/home_icon.png" alt="welcome" class="cart-icon" title="Welcome">
                </a>
                <a href="index.php" class="cart-link">
                    <img src="Assets/merch_icon.png" alt="merch" class="cart-icon" title="Merch">
                </a>
                <a href="connection.php" class="cart-link">
                    <img src="Assets/signin_icon.png" alt="connection" class="cart-icon" title="Connection">
                </a>
                <a href="inscription.php" class="cart-link">
                    <img src="Assets/signup_icon.png" alt="inscription" class="cart-icon" title="Inscription">
                </a>
            <?php else: ?>
                <a href="welcome.php" class="cart-link">
                    <img src="Assets/home_icon.png" alt="welcome" class="cart-icon" title="Welcome">
                </a>
                <a href="index.php" class="cart-link">
                    <img src="Assets/merch_icon.png" alt="merch" class="cart-icon" title="Merch">
                </a>
                <a href="account.php" class="cart-link">
                    <img src="Assets/account_icon.png" alt="user" class="cart-icon" title="Account">
                </a>
                <a href="cart.php" class="cart-link">
                    <img src="Assets/cart_icon.png" alt="cart" class="cart-icon" title="Cart">
                </a>
                <a href="logout.php" class="cart-link">
                    <img src="Assets/logout_icon.png" alt="logout" class="cart-icon" title="Logout">
                </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>