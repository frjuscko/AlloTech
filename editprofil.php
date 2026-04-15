<?php
session_start();
require('config/database.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);

$photoPath = null;

if (!empty($_FILES['photo']['name'])) {
    
    $file = $_FILES['photo'];
    
    if ($file['size'] > 2 * 1024 * 1024) {
        die("Image trop lourde");
    }
    // Vérifier erreurs
    if ($file['error'] === 0) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        
        if (in_array($file['type'], $allowedTypes)) {

            // Générer nom unique
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . uniqid() . '.' . $extension;

            $uploadDir = 'avatars/';
            $uploadPath = $uploadDir . $filename;

            // Créer dossier si nécessaire
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Déplacer fichier
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $photoPath = $uploadPath;
            }
        }
    }
}
if ($photoPath) {
    $sql = "UPDATE users 
            SET nom = ?, prenom = ?, email = ?, photo = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $photoPath, $user_id]);

} else {
        $sql = "UPDATE users 
            SET nom = ?, prenom = ?, email = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $user_id]);
}
header("Location: profil.php?success=1");
exit;