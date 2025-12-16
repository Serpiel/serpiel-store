<?php

// Local Version (Wamp)
$servername = "localhost";
$dbname = "bdd_serpiel";
$dbusername = "root";
$dbpassword = "";

// Online Version (Hostinger)
/*
$servername = "127.0.0.1";
$dbname = "u448959582_serpiel";
$dbusername = "u448959582_serpiel";
$dbpassword = "Darkikoololdu48!";
*/
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>