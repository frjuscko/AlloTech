<?php
require('config/database.php');
// ✅ Amélioré - Vérifier que l'ID est valide AVANT la requête
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id) || $id <= 0) {
    die("ID de technicien invalide");
}

$sql = "SELECT 
                t.*,
                u.nom,
                u.prenom,
                u.photo
            FROM techniciens t
            JOIN users u ON t.user = u.id
            WHERE t.id = :id";
$stmt = $pdo->prepare($sql);

// ✅ Amélioré - Avec gestion d'exception
try {
    $stmt->execute([':id' => $id]);
} catch (PDOException $e) {
    error_log("Erreur BDD : " . $e->getMessage());
    die("Erreur technique, veuillez réessayer plus tard");
}

// ✅ Amélioré - Explicitement en tableau associatif
$tech = $stmt->fetch(PDO::FETCH_ASSOC);

echo($tech['prenom']);

if (!$tech) {
    die("Technicien introuvable");
}
?>
