<?php
// À placer ABSOLUMENT au début du fichier, avant tout autre code
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    require('../config/database.php');
    
    if (isset($_POST['submit'])) {
        $code = trim($_POST['code'] ?? '');
        $libelle = trim($_POST['libelle'] ?? '');

        /* Gestion du fichier */
        $photo_path = null;
        $uploadDir = '../uploads/competences/';  // ✅ Ajout du slash à la fin
        
        // ✅ CORRECTION 1 : Créer le dossier s'il N'EXISTE PAS
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Vérifier qu'un fichier a bien été uploadé
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            
            $file = $_FILES['photo'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size'];
            
            // Vérifier le type de fichier
            $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $file_tmp);
            finfo_close($finfo);
            
            if (!in_array($file_type, $allowed_types)) {
                header('Location: ../skilladd.php?error=type_invalide');
                exit;
            }
            
            // Vérifier la taille (max 2Mo)
            $max_size = 2 * 1024 * 1024;
            if ($file_size > $max_size) {
                header('Location: ../skilladd.php?error=fichier_trop_grand');
                exit;
            }
            
            // Générer un nom unique pour l'image
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_filename = 'skill' . uniqid() . '_' . time() . '.' . $extension;
            
            // ✅ CORRECTION 2 : Utiliser $uploadDir (pas $upload_dir)
            $destination = $uploadDir . $new_filename;
            
            // Déplacer le fichier uploadé
            if (move_uploaded_file($file_tmp, $destination)) {
                $photo_path = 'uploads/competences/' . $new_filename;
            } else {
                header('Location: ../skilladd.php?error=upload_echoue');
                exit;
            }
            
        } elseif (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Une erreur est survenue lors de l'upload
            $upload_errors = [
                UPLOAD_ERR_INI_SIZE => 'Fichier trop grand (php.ini)',
                UPLOAD_ERR_FORM_SIZE => 'Fichier trop grand (formulaire)',
                UPLOAD_ERR_PARTIAL => 'Fichier partiellement uploadé',
                UPLOAD_ERR_NO_FILE => 'Aucun fichier sélectionné',
                UPLOAD_ERR_CANT_WRITE => 'Erreur d\'écriture sur le disque',
                UPLOAD_ERR_EXTENSION => 'Extension PHP bloquée'
            ];
            $error_msg = $upload_errors[$_FILES['photo']['error']] ?? 'Erreur inconnue';
            header('Location: ../skilladd.php?error=' . urlencode($error_msg));
            exit;
        }

        try {
            $sql = "INSERT INTO competences (code, libelle, photo, date_creation) VALUES (:code, :libelle, :photo, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':code' => $code,
                ':libelle' => $libelle,
                ':photo' => $photo_path
            ]);

            $message = "'$libelle' ajoutée avec succès !";
            header("Location: ../skills.php?message=" . urlencode($message) . "&type=success");
            exit;

        } catch (PDOException $e) {
            // Si erreur BDD, supprimer l'image uploadée
            if ($photo_path && file_exists('../' . $photo_path)) {
                unlink('../' . $photo_path);
            }
            
            $message = "❌ Erreur technique : " . $e->getMessage();
            header("Location: ../skills.php?message=" . urlencode($message) . "&type=error");
            exit;
        }
    }
    
    // ✅ CORRECTION 3 : Redirection si accès direct
    header('Location: ../skilladd.php');
    exit;
?>