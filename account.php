<<<<<<< HEAD
<?php
session_start();
include 'bdd.php';

if (!isset($_SESSION['username'])) {
    header("Location: connection.php");
    exit();
}

$username = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newUsername = htmlspecialchars(trim($_POST["username"]));
        $newEmail = htmlspecialchars(trim($_POST["email"]));
        $newPassword = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

        try {
            $sql = "UPDATE users SET username = :username, email = :email" . ($newPassword ? ", password = :password" : "") . " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':email', $newEmail);
            if ($newPassword) {
                $stmt->bindParam(':password', $newPassword);
            }
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();

            $_SESSION['username'] = $newUsername;
            $_SESSION['email'] = $newEmail;
            $_SESSION['success_message'] = "Informations updated successfully.";
            
            header("Location: account.php");
            exit();
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="style/account.css">
</head>
<body>
    <?php include 'navbar.php';?>

    <div class="profile-wrapper">
        <div class="profile-container">
            <h2>My Profile</h2>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <p class="success-message"><?php echo $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <form action="account.php" method="POST">
                <div class="form-group">
                    <label for="username">Username :</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="button-group">
                    <input type="submit" value="Update">
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php';?>
</body>
</html>
=======
<?php
session_start();
include 'bdd.php';

if (!isset($_SESSION['username'])) {
    header("Location: connection.php");
    exit();
}

$username = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newUsername = htmlspecialchars(trim($_POST["username"]));
        $newEmail = htmlspecialchars(trim($_POST["email"]));
        $newPassword = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

        try {
            $sql = "UPDATE users SET username = :username, email = :email" . ($newPassword ? ", password = :password" : "") . " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':email', $newEmail);
            if ($newPassword) {
                $stmt->bindParam(':password', $newPassword);
            }
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();

            $_SESSION['username'] = $newUsername;
            $_SESSION['email'] = $newEmail;
            $_SESSION['success_message'] = "Informations updated successfully.";
            
            header("Location: account.php");
            exit();
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="style/account.css">
</head>
<body>
    <?php include 'navbar.php';?>

    <div class="profile-wrapper">
        <div class="profile-container">
            <h2>My Profile</h2>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <p class="success-message"><?php echo $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <form action="account.php" method="POST">
                <div class="form-group">
                    <label for="username">Username :</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="button-group">
                    <input type="submit" value="Update">
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php';?>
</body>
</html>
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
