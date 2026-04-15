<?php
// Configuration
$host = 'localhost';
$port = '3306';
$dbname = 'allotech';   // Votre base créée plus tôt
$user = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
