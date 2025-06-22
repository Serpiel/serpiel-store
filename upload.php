<?php
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $name = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO products (name, image) VALUES (?, ?)");
    $stmt->execute([$name, $imageData]);

    echo "Product enregistered !";
} else {
    echo "Download error.";
}
?>
