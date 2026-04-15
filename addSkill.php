<?php
    require('config/database.php');
    if (isset($_POST['submit'])) {
        $code = trim($_POST['code'] ?? '');
        $libelle = trim($_POST['libelle'] ?? '');

        try {
            $sql = "INSERT INTO competences (code, libelle) VALUES (:code, :libelle)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':code' => $code,
                ':libelle' => $libelle
            ]);

            $message = "'$libelle' ajouté avec succès !";
            header("Location: competences.php?message=" . urlencode($message));
            exit;

        } catch (PDOException $e) {
            // Gérer les erreurs spécifiques
            $message = "❌ Erreur technique : " . $e->getMessage();
            header("Location: competences.php?message=" . urlencode($message) . "&type=error");
            exit;
        }
        
    
    }



    