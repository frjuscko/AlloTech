<?php
    require('config/database.php');
    if (isset($_POST['submit'])) {
        $code = trim($_POST['code'] ?? '');
        $nom = trim($_POST['nom'] ?? '');

        try {
            $sql = "INSERT INTO villes (code, nom) VALUES (:code, :nom)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':code' => $code,
                ':nom' => $nom
            ]);

            $message = "'$nom' ajoutée avec succès !";
            header("Location: villes.php?message=" . urlencode($message));
            exit;

        } catch (PDOException $e) {
            // Gérer les erreurs spécifiques
            $message = "❌ Erreur technique : " . $e->getMessage();
            header("Location: villes.php?message=" . urlencode($message) . "&type=error");
            exit;
        }
        
    
    }



    