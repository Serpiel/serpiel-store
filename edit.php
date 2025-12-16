<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include 'bdd.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $tableName = $_GET['table'];
    $id = $_GET['id'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "<p>Erreur : La ligne avec cet ID n'existe pas.</p>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    echo "<p>Erreur : Table ou ID non spécifié.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateData = [];
    $params = [];

    foreach ($row as $column => $currentValue) {
        if ($column === 'password') {
            continue;
        }

        // 🖼️ Gérer les fichiers image (upload)
        if (in_array($column, ['image', 'image2', 'image_db']) && isset($_FILES[$column]) && $_FILES[$column]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExt = pathinfo($_FILES[$column]['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$column]['tmp_name'], $targetPath)) {
                $updateData[$column] = $targetPath;
            } else {
                $updateData[$column] = $currentValue; // Si erreur, on garde l'ancien
            }
        }
        // Autres champs texte
        elseif (isset($_POST[$column])) {
            $updateData[$column] = $_POST[$column];
        }
    }

    // Construction requête SQL
    $setClause = "";
    foreach ($updateData as $column => $value) {
        $setClause .= "$column = :$column, ";
        $params[":$column"] = $value;
    }
    $setClause = rtrim($setClause, ", ");
    $params[':id'] = $id;

    try {
        $stmt = $conn->prepare("UPDATE $tableName SET $setClause WHERE id = :id");
        $stmt->execute($params);

        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les données</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <h1>Modification des données de la table "<?php echo htmlspecialchars($tableName); ?>"</h1>
    <form action="edit.php?table=<?php echo htmlspecialchars($tableName); ?>&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <?php
        foreach ($row as $column => $data) {
            if ($column === 'password') continue;

            echo "<label for='$column'>" . htmlspecialchars($column) . " :</label>";

            if (in_array($column, ['image', 'image2', 'image_db'])) {
                echo "<input type='file' name='$column' id='$column' accept='image/*'><br>";
                if (!empty($data)) {
                    echo "<img src='" . htmlspecialchars($data) . "' alt='Image actuelle' style='max-width:150px;'><br>";
                }
            } else {
                echo "<input type='text' name='$column' id='$column' value='" . htmlspecialchars($data ?? '') . "' required>";
            }

            echo "<br><br>";
        }
        ?>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    <p><a href="admin_dashboard.php">Retour à l'administration</a></p>
</body>
</html>
=======
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include 'bdd.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $tableName = $_GET['table'];
    $id = $_GET['id'];

    try {
        // Connexion à la base de données avec gestion d'erreurs
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données de la ligne spécifiée
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si la ligne existe
        if (!$row) {
            echo "<p>Erreur : La ligne avec cet ID n'existe pas.</p>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    echo "<p>Erreur : Table ou ID non spécifié.</p>";
    exit();
}

// Gestion de l'envoi du formulaire (mise à jour des données)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données envoyées par le formulaire
    $updateData = [];
    foreach ($_POST as $column => $value) {
        // On ne permet pas de modifier les mots de passe
        if ($column !== 'password') {
            $updateData[$column] = $value;
        }
    }

    try {
        // Préparer la mise à jour
        $setClause = "";
        $params = [];
        foreach ($updateData as $column => $value) {
            $setClause .= "$column = :$column, ";
            $params[":$column"] = $value;
        }

        $setClause = rtrim($setClause, ", "); // Retirer la dernière virgule
        $params[':id'] = $id;

        // Exécuter la requête de mise à jour
        $stmt = $conn->prepare("UPDATE $tableName SET $setClause WHERE id = :id");
        $stmt->execute($params);

        // Redirection après la mise à jour
        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit();
    }
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les données</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <h1>Modification des données de la table "<?php echo htmlspecialchars($tableName); ?>"</h1>
    <form action="edit.php?table=<?php echo htmlspecialchars($tableName); ?>&id=<?php echo $id; ?>" method="POST">
        <?php
        // Dynamique génération du formulaire
        foreach ($row as $column => $data) {
            // Ne pas afficher le champ "password" dans le formulaire
            if ($column === 'password') {
                continue;
            }

            echo "<label for='$column'>" . htmlspecialchars($column) . " :</label>";
            echo "<input type='text' name='$column' id='$column' value='" . htmlspecialchars($data) . "' required>";
            echo "<br><br>";
        }
        ?>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    <p><a href="admin_dashboard.php">Retour à l'administration</a></p>
</body>
</html>
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
