<?php
session_start();
require('config/database.php');

// Vérifier que les champs sont envoyés
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: auth.php?error=missing_fields');
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

// Vérifier que les champs ne sont pas vides
if (empty($email) || empty($password)) {
    header('Location: auth.php?error=empty_fields');
    exit;
}

try {
    // Récupérer l'utilisateur par son email
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si l'utilisateur existe
    if (!$user) {
        header('Location: auth.php?error=user_not_found');
        exit;
    }
    
    // Vérifier le mot de passe
    if (!password_verify($password, $user['passwd'])) {
        header('Location: auth.php?error=wrong_password');
        exit;
    }
    
    // Connexion réussie - Stocker les infos de base
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nom'] = $user['nom'] ?? '';
    $_SESSION['prenom'] = $user['prenom'] ?? '';
    $_SESSION['email'] = $user['email'];
    
    // Récupérer le rôle de l'utilisateur
    // Supposons que la table 'users' a une colonne 'role_id'
    if (isset($user['role_id']) && !empty($user['role_id'])) {
        $sql = "SELECT * FROM roles WHERE id = :role_id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':role_id' => $user['role_id']]);  // ← Correction
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($role) {
            $_SESSION['role'] = $role['libelle'];
            $_SESSION['role_id'] = $user['role_id'];
        } else {
            $_SESSION['role'] = 'Utilisateur';
            $_SESSION['role_id'] = null;
        }
    } else {
        $_SESSION['role'] = 'Utilisateur';
        $_SESSION['role_id'] = null;
    }
    
    // Rediriger selon le rôle
    switch ($_SESSION['role']) {
        case 'Administrateur':
        case 'Admin':
            header('Location: dashboard.php');
            break;
        case 'Technicien':
            header('Location: techs.php');
            break;
        default:
            header('Location: techs.php');
            break;
    }
    exit;
    
} catch (PDOException $e) {
    // Erreur de base de données
    error_log("Erreur de connexion : " . $e->getMessage());
    header('Location: auth.php?error=technical_error');
    exit;
}
