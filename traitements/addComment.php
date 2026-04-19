<?php
// Activation des erreurs (à retirer en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../config/database.php');

if (isset($_POST['submit'])) {
    
    // Récupération et nettoyage des données
    $tech = intval($_POST['tech'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $texte = trim($_POST['texte'] ?? '');
    
    // ========== VALIDATION ==========
    $errors = [];
    
    // Vérifier l'ID du technicien
    if ($tech <= 0) {
        $errors[] = "Technicien invalide";
    }
    
    // Vérifier l'email
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }
    
    // Vérifier le commentaire
    if (empty($texte)) {
        $errors[] = "Le commentaire est obligatoire";
    } elseif (strlen($texte) < 3) {
        $errors[] = "Le commentaire doit contenir au moins 3 caractères";
    } elseif (strlen($texte) > 500) {
        $errors[] = "Le commentaire ne doit pas dépasser 500 caractères";
    }
    
    // Vérifier que le technicien existe vraiment
    if (empty($errors)) {
        $check = $pdo->prepare("SELECT id FROM techniciens WHERE id = :id");
        $check->execute([':id' => $tech]);
        if (!$check->fetch()) {
            $errors[] = "Le technicien n'existe pas";
        }
    }
    
    // Si erreurs, rediriger avec le message d'erreur
    if (!empty($errors)) {
        $error_msg = implode(', ', $errors);
        header("Location: ../tech.php?id=$tech&error=" . urlencode($error_msg));
        exit;
    }
    
    // ========== INSERTION ==========
    try {
        // Vérifier le nom exact de la colonne date
        // Si c'est 'date_creation' au lieu de 'date_comment', adaptez :
        $sql = "INSERT INTO commentaires (email, texte, date_comment, tech) 
                VALUES (:email, :texte, NOW(), :tech)";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':email' => $email,
            ':texte' => nl2br(htmlspecialchars($texte)), // Optionnel : conserver les sauts de ligne
            ':tech' => $tech
        ]);
        
        if ($result) {
            $message = "Commentaire ajouté avec succès !";
            header("Location: ../tech.php?id=$tech&message=" . urlencode($message) . "&type=success");
            exit;
        } else {
            throw new PDOException("Erreur lors de l'insertion");
        }
        
    } catch (PDOException $e) {
        error_log("Erreur ajout commentaire : " . $e->getMessage());
        $message = "Erreur technique lors de l'ajout du commentaire";
        header("Location: ../tech.php?id=$tech&error=" . urlencode($message));
        exit;
    }
}

// Redirection si accès direct
header('Location: ../tech.php');
exit;
?>