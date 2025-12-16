<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include 'bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taux'])) {
    $taux = floatval($_POST['taux']);
    $year = isset($_POST['year']) && $_POST['year'] !== '' ? intval($_POST['year']) : null;
    $country = isset($_POST['country']) && $_POST['country'] !== '' ? trim($_POST['country']) : null;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "UPDATE products SET price = price * (1 + :taux / 100)";
        $conditions = [];
        $params = [':taux' => $taux];

        if ($year !== null) {
            $conditions[] = "YEAR(purchase_date) = :year";
            $params[':year'] = $year;
        }

        if ($country !== null) {
            $conditions[] = "manufacturing_production = :country";
            $params[':country'] = $country;
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);

        header("Location: admin_dashboard.php?success_taux=1");
        exit();

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    echo "Taux non spécifié.";
    exit();
}
?>
