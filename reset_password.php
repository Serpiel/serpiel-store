<?php
session_start();
include 'bdd.php';

if (!isset($_GET['token'])) {
    echo "<p>Token manquant.</p>";
    exit();
}

$token = $_GET['token'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le token existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<p>Lien invalide ou expiré.</p>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe et supprimer le token
        $stmt = $conn->prepare("UPDATE users SET password = :new_password, reset_token = NULL WHERE id = :id");
        $stmt->bindParam(':new_password', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
        $stmt->execute();

        echo "<p>Votre mot de passe a été réinitialisé avec succès !</p>";
        echo "<p><a href='connection.php'>Retour à la connexion</a></p>";
        exit();
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
</head>
<body>
    <h1>Réinitialiser votre mot de passe</h1>
    <form method="POST">
        <label for="new_password">Nouveau mot de passe :</label><br>
        <input type="password" name="new_password" id="new_password" required><br><br>
        <button type="submit">Changer le mot de passe</button>
    </form>
</body>
</html>
