<?php
session_start();
include 'bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'utilisateur existe
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Générer un token unique
            $token = bin2hex(random_bytes(16));

            // Stocker le token en base
            $stmt = $conn->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Générer le lien de réinitialisation
            $resetLink = "http://localhost/E-commerce_php/reset_password.php?token=" . $token;

            // En environnement de test local, on n'envoie pas d'email : on affiche le lien directement
            echo "<h2>Lien de réinitialisation généré :</h2>";
            echo "<p>Voici le lien de réinitialisation (copie/colle-le dans ton navigateur) :</p>";
            echo "<a href='$resetLink'>$resetLink</a>";

        } else {
            echo "<p>Aucun utilisateur trouvé avec cet e-mail.</p>";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

} else {
    echo "<p>Formulaire invalide.</p>";
}
?>
