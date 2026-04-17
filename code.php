<?php
require('config/database.php');

$search = $_GET['search'] ?? '';
$ville = $_GET['ville'] ?? '';
$competence = $_GET['competence'] ?? '';

$sql = "SELECT 
            t.id,
            u.nom,
            u.prenom,
            u.photo,
            v.nom AS ville,
            c.libelle AS competence
        FROM techniciens t
        JOIN users u ON t.user_id = u.id
        LEFT JOIN villes v ON t.ville_id = v.id
        LEFT JOIN competences c ON t.competence_id = c.id
        WHERE 1=1";

$params = [];

// 🔍 Recherche
if (!empty($search)) {
    $sql .= " AND (u.nom LIKE :search OR u.prenom LIKE :search)";
    $params[':search'] = "%$search%";
}

// 📍 Ville
if (!empty($ville)) {
    $sql .= " AND t.ville_id = :ville";
    $params[':ville'] = $ville;
}

// 🔧 Compétence
if (!empty($competence)) {
    $sql .= " AND t.competence_id = :competence";
    $params[':competence'] = $competence;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$techniciens = $stmt->fetchAll();
?>


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