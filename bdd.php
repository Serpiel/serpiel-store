<?php


$servername = "localhost";
$dbname = "bdd_serpiel";
$dbusername = "root";
$dbpassword = "";
/*
$servername = "127.0.0.1";
$dbname = "u448959582_serpiel";
$dbusername = "u448959582_serpiel";
$dbpassword = "Darkikoololdu48!";
*/
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>