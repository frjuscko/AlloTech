<?php
require('config/database.php');
require('includes/AvatarGenerator.php');

if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $passwd = trim($_POST['password'] ?? '');

    // Validation des champs obligatoires
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire.";
    }
    
    if (empty($prenom)) {
        $errors[] = "Le prénom est obligatoire (pour l'avatar).";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    
    if (empty($passwd)) {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($passwd) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: create_user.php?message=" . urlencode($message) . "&type=error");
        exit;
    }

    // Fonction pour générer un username unique
    function generateUniqueUsername($pdo, $prenom, $nom) {
        // Nettoyer et normaliser
        $base = '';
        
        if (!empty($prenom)) {
            $base = strtolower($prenom) . '.' . strtolower($nom);
        } else {
            $base = strtolower($nom);
        }
        
        // Supprimer les accents et caractères spéciaux
        $base = iconv('UTF-8', 'ASCII//TRANSLIT', $base);
        $base = preg_replace('/[^a-z0-9.-]/', '', $base);
        
        // Si le base est vide (ex: que des caractères spéciaux), utiliser "user"
        if (empty($base)) {
            $base = 'user';
        }
        
        // Ajouter des chiffres aléatoires
        $random = rand(100, 999);
        $username = $base . $random;
        
        // Vérifier si l'username existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $count = $stmt->fetchColumn();
        
        // Si existe, regénérer avec un nouveau nombre aléatoire
        $attempts = 0;
        while ($count > 0 && $attempts < 10) {
            $random = rand(100, 999);
            $username = $base . $random;
            $stmt->execute([':username' => $username]);
            $count = $stmt->fetchColumn();
            $attempts++;
        }
        
        // Si toujours pas unique après 10 tentatives, ajouter timestamp
        if ($count > 0) {
            $username = $base . time() . rand(10, 99);
        }
        
        return $username;
    }

    try {
        // Générer l'username unique
        $username = generateUniqueUsername($pdo, $prenom, $nom);
        
        // 🎨 Générer l'avatar (basé sur le prénom)
        $avatarGenerator = new AvatarGenerator();
        $avatarPath = $avatarGenerator->generateAvatar($prenom);
        
        // 🔐 Hacher le mot de passe (NE JAMAIS stocker les mots de passe en clair !)
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);
        
        // Vérifier que la table a bien une colonne 'photo'
        // Si ce n'est pas le cas, exécutez cette commande SQL dans pgAdmin :
        // ALTER TABLE users ADD COLUMN photo VARCHAR(255);
        $sql = "INSERT INTO users (nom, prenom, email, username, passwd, photo, date_creation) 
                VALUES (:nom, :prenom, :email, :username, :passwd, :photo, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':username' => $username,
            ':passwd' => $hashedPassword,
            ':photo' => $avatarPath
        ]);
        
        // Récupérer l'ID du nouvel utilisateur
        $userId = $pdo->lastInsertId();
        
        // Message de succès avec les infos
        $message = "✅ Utilisateur '$prenom $nom' créé avec succès ! (ID: $userId)<br>
                    🔑 Username : <strong>$username</strong><br>
                    🖼️ Avatar généré automatiquement !";
        
        // Rediriger avec l'avatar pour l'afficher
        session_start();

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_nom'] = $nom;
        $_SESSION['user_prenom'] = $prenom;
        $_SESSION['user_email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['photo'] = $avatarPath;

        header("Location: admin.php?message=" . urlencode($message) . "&type=success&avatar=" . urlencode($avatarPath));
        exit;
        
    } catch (PDOException $e) {
        // Gérer les erreurs spécifiques
        if (strpos($e->getMessage(), 'duplicate key') !== false) {
            if (strpos($e->getMessage(), 'email') !== false) {
                $message = "❌ Cet email est déjà utilisé. Veuillez en choisir un autre.";
            } elseif (strpos($e->getMessage(), 'username') !== false) {
                $message = "❌ Ce username existe déjà. Veuillez réessayer.";
            } else {
                $message = "❌ Un utilisateur avec ces informations existe déjà.";
            }
        } else {
            $message = "❌ Erreur technique : " . $e->getMessage();
        }
        
        header("Location: auth.php?message=" . urlencode($message) . "&type=error");
        exit;
    }
} else {
    // Si quelqu'un accède directement à ce fichier sans soumettre le formulaire
    header("Location: create_user.php");
    exit;
}
?>