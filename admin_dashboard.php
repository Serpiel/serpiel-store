<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include 'bdd.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <h1>Welcome, Emperor</h1>
    <a href="index.php"><button class="product-see-cart" type="submit">Return to website</button></a>


    <!-- Formulaire d'application de taux sur les produits avec filtres -->
<div class="taux-container">
    <h3>Appliquer un taux de modification des prix sur les produits</h3>
    <form action="apply_taux.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir appliquer cette modification ?');">
        <label for="taux">Taux (% positif ou négatif) :</label><br>
        <input type="number" step="0.01" name="taux" id="taux" required placeholder="Ex : 10 ou -5"><br><br>

        <label for="year">Filtrer par année d'achat (facultatif) :</label><br>
        <input type="text" name="year" id="year" placeholder="Ex : 2025"><br><br>

        <label for="country">Filtrer par pays de fabrication (facultatif) :</label><br>
        <input type="text" name="country" id="country" placeholder="Ex : Italie"><br><br>

        <button type="submit">Appliquer le taux</button>
    </form>
</div>

<?php if (isset($_GET['success_taux'])): ?>
    <p style="color: green; font-weight: bold;">✔️ Le taux a bien été appliqué aux produits concernés.</p>
<?php endif; ?>


    <h2>List of the tables of "<?php echo htmlspecialchars($dbname); ?>"</h2>

    <?php 
    if ($tables) {
        foreach ($tables as $table) {
            $tableName = $table['Tables_in_' . $dbname];

            echo "<div class='table-container'>";
            echo "<h3>Table : $tableName</h3>";

            $stmt = $conn->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                echo "<table>";
                echo "<tr>";

                foreach (array_keys($rows[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "<th>Actions</th>";
                echo "</tr>";

                foreach ($rows as $row) {
                    $idColumn = array_keys($rows[0])[0];

                    if ($row[$idColumn] == 0) continue;

                    echo "<tr>";
                    foreach ($row as $column => $data) {
                        if ($column === 'password') {
                            echo "<td>*****</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($data ?? '') . "</td>";
                        }
                    }

                    echo "<td class='actions'>";
                    echo "<a class='edit' href='edit.php?table=$tableName&id={$row[$idColumn]}'>Edit</a><br>";
                    echo "<a class='delete' href='delete.php?table=$tableName&id={$row[$idColumn]}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data available in this table : $tableName.</p>";
            }
            echo "<p><a class='add' href='create.php?table=$tableName'>Add</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No table found in the database.</p>";
    }

    $conn = null;
    ?>
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

try {
    // Connexion à la base de données avec gestion d'erreurs
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les tables de la base de données de manière sécurisée
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <h1>Welcome, Emperor</h1>
    <a href="welcome.php"><button class="product-see-cart" type="submit">Return to website</button></a>
    <h2>List of the tables of "<?php echo htmlspecialchars($dbname); ?>"</h2>

    <?php 
    if ($tables) {
        foreach ($tables as $table) {
            $tableName = $table['Tables_in_' . $dbname];  // Utilisation dynamique du nom de la table

            echo "<div class='table-container'>";
            echo "<h3>Table : $tableName</h3>";

            // Sécurisation de la requête SELECT
            $stmt = $conn->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                echo "<table>";
                echo "<tr>";

                // Affichage des en-têtes des colonnes
                foreach (array_keys($rows[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "<th>Actions</th>";
                echo "</tr>";

                foreach ($rows as $row) {
                    $idColumn = array_keys($rows[0])[0];

                    // Sauter l'ID 0 (si nécessaire, à confirmer selon les spécifications)
                    if ($row[$idColumn] == 0) {
                        continue;
                    }

                    echo "<tr>";
                    foreach ($row as $column => $data) {
                        if ($column === 'password') {
                            echo "<td>*****</td>"; // Masquage des mots de passe
                        } else {
                            echo "<td>" . htmlspecialchars($data) . "</td>";
                        }
                    }

                    echo "<td class='actions'>";
                    echo "<a class='edit' href='edit.php?table=$tableName&id={$row[$idColumn]}'>Edit</a>";
                    echo "<br>";
                    echo "<a class='delete' href='delete.php?table=$tableName&id={$row[$idColumn]}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data available in this table : $tableName.</p>";
            }
            echo "<p><a class='add' href='create.php?table=$tableName'>Add</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No table found in the database.</p>";
    }

    $conn = null;
    ?>
</body>
</html>
>>>>>>> 2fca341a50f4c42f33410b1d0aa0c44a74c8e042
