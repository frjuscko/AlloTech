<?php
$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("
    SELECT 
        t.*,
        u.nom,
        u.prenom,
        u.email,
        u.photo,
        v.nom AS ville,
        c.libelle AS competence
    FROM techniciens t
    JOIN users u ON t.user_id = u.id
    LEFT JOIN villes v ON t.ville_id = v.id
    LEFT JOIN competences c ON t.competence_id = c.id
    WHERE t.id = :id
");

$stmt->execute([':id' => $id]);
$tech = $stmt->fetch();

if (!$tech) {
    die("Technicien introuvable");
}
?>
