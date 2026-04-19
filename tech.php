<?php
require('config/database.php');
// ✅ Amélioré - Vérifier que l'ID est valide AVANT la requête
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id) || $id <= 0) {
    die("ID de technicien invalide");
}

$sql = "SELECT 
                t.*,
                u.*,
                v.nom AS ville
            FROM techniciens t
            JOIN users u ON t.user = u.id
            JOIN villes v ON t.ville = v.id
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

if (!$tech) {
    die("Technicien introuvable");
}

$sql = "SELECT * FROM commentaires WHERE tech = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$commentaires = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/navbar.js" defer></script>
        <script src="js/tech.js" defer></script>
        <title>Document</title>
    </head>
    <body>
        <header>
            <div class="desktop">
                <a href="index.php"><div class="logo"></div></a>
                <div class="links">
                    <ul>
                        <li><a href="techs.php"
                                class="link index">Techniciens</a></li>//
                        <li><a href="contacts.php" class="link">Nous
                                contacter</a></li>
                        <li class="logList"><a href="dashboard.php"
                                class="link logLink"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M11 14.0619V20H13V14.0619C16.9463 14.554 20 17.9204 20 22H4C4 17.9204 7.05369 14.554 11 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path></svg></a></li>
                    </ul>
                </div>
            </div>
        </header>
        <main>
            <div class="cover2">
                <p class="chemin"><a href="index.php">accueil /</a> <a
                        href="techs.php">techniciens /</a> <?= htmlspecialchars($tech['prenom']) ?></p>
            </div>
            <div class="section">
                <div class="details_top">
                    <div class="tech_image">
                        <ul>
                            <li><a href="<?= htmlspecialchars($tech['telephone']) ?>" id="tel"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"><path
                                            d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z"></path></svg></a></li>
                            <li><a href="<?= htmlspecialchars($tech['whatsapp']) ?>" id="wht"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"><path
                                            d="M12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2ZM8.59339 7.30019L8.39232 7.30833C8.26293 7.31742 8.13607 7.34902 8.02057 7.40811C7.93392 7.45244 7.85348 7.51651 7.72709 7.63586C7.60774 7.74855 7.53857 7.84697 7.46569 7.94186C7.09599 8.4232 6.89729 9.01405 6.90098 9.62098C6.90299 10.1116 7.03043 10.5884 7.23169 11.0336C7.63982 11.9364 8.31288 12.8908 9.20194 13.7759C9.4155 13.9885 9.62473 14.2034 9.85034 14.402C10.9538 15.3736 12.2688 16.0742 13.6907 16.4482C13.6907 16.4482 14.2507 16.5342 14.2589 16.5347C14.4444 16.5447 14.6296 16.5313 14.8153 16.5218C15.1066 16.5068 15.391 16.428 15.6484 16.2909C15.8139 16.2028 15.8922 16.159 16.0311 16.0714C16.0311 16.0714 16.0737 16.0426 16.1559 15.9814C16.2909 15.8808 16.3743 15.81 16.4866 15.6934C16.5694 15.6074 16.6406 15.5058 16.6956 15.3913C16.7738 15.2281 16.8525 14.9166 16.8838 14.6579C16.9077 14.4603 16.9005 14.3523 16.8979 14.2854C16.8936 14.1778 16.8047 14.0671 16.7073 14.0201L16.1258 13.7587C16.1258 13.7587 15.2563 13.3803 14.7245 13.1377C14.6691 13.1124 14.6085 13.1007 14.5476 13.097C14.4142 13.0888 14.2647 13.1236 14.1696 13.2238C14.1646 13.2218 14.0984 13.279 13.3749 14.1555C13.335 14.2032 13.2415 14.3069 13.0798 14.2972C13.0554 14.2955 13.0311 14.292 13.0074 14.2858C12.9419 14.2685 12.8781 14.2457 12.8157 14.2193C12.692 14.1668 12.6486 14.1469 12.5641 14.1105C11.9868 13.8583 11.457 13.5209 10.9887 13.108C10.8631 12.9974 10.7463 12.8783 10.6259 12.7616C10.2057 12.3543 9.86169 11.9211 9.60577 11.4938C9.5918 11.4705 9.57027 11.4368 9.54708 11.3991C9.50521 11.331 9.45903 11.25 9.44455 11.1944C9.40738 11.0473 9.50599 10.9291 9.50599 10.9291C9.50599 10.9291 9.74939 10.663 9.86248 10.5183C9.97128 10.379 10.0652 10.2428 10.125 10.1457C10.2428 9.95633 10.2801 9.76062 10.2182 9.60963C9.93764 8.92565 9.64818 8.24536 9.34986 7.56894C9.29098 7.43545 9.11585 7.33846 8.95659 7.32007C8.90265 7.31384 8.84875 7.30758 8.79459 7.30402C8.66053 7.29748 8.5262 7.29892 8.39232 7.30833L8.59339 7.30019Z"></path></svg></a></li>
                        </ul>
                        <div class="tech_photo">
                            <img src="<?= htmlspecialchars($tech['photo']) ?>" alt>
                        </div>
                    </div>
                    <div class="tech_name">
                        <h1><?= htmlspecialchars($tech['prenom']) ?> <?= htmlspecialchars($tech['nom']) ?></h1>
                        <p><?= htmlspecialchars($tech['titre']) ?> | <?= htmlspecialchars($tech['ville']) ?></p>
                    </div>
                </div>
                <div class="details_body">
                    <div class="info_box">
                        <label for>Bio</label>
                        <p><?= htmlspecialchars($tech['bio']) ?></p>
                        <?php 
                            if (!$tech['bio']) {
                                echo('<p>Sans description</p>');
                            }
                        ?>   
                    </div>
                    <div class="info_box">
                        <label for>Membre depuis</label>
                        <p><?= date('d M Y', strtotime($tech['date_creation'])) ?></p>
                    </div>

                    <div class="comments_section">
                        <div class="comment_invite">
                            <form action="traitements/addComment.php" method="post">
                                <div class="comment_input">
                                    <input type="hidden" name="tech" value="<?= htmlspecialchars($id) ?>">
                                    <input type="email" placeholder="Votre email" class="commentEmail" name="email" required>
                                    <textarea name="texte" id="" class="commentText" placeholder="Votre commentaire" required></textarea>
                                    <button class="commentBtn" type="submit" name="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10 3H14C18.4183 3 22 6.58172 22 11C22 15.4183 18.4183 19 14 19V22.5C9 20.5 2 17.5 2 11C2 6.58172 5.58172 3 10 3Z"></path></svg></button>
                                </div>
                            </form>
                            <button class="iconBtn"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M10 3H14C18.4183 3 22 6.58172 22 11C22 15.4183 18.4183 19 14 19V22.5C9 20.5 2 17.5 2 11C2 6.58172 5.58172 3 10 3Z"></path></svg></button>
                            <button class="invite_btn">Ajouter un commentaire</button>
                        </div>
                        <div class="comments">
                            <?php foreach($commentaires as $commentaire): ?>
                                <div class="comment">
                                    <div class="photo">
                                        <button class="iconBtn"><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"><path
                                                    d="M10 3H14C18.4183 3 22 6.58172 22 11C22 15.4183 18.4183 19 14 19V22.5C9 20.5 2 17.5 2 11C2 6.58172 5.58172 3 10 3Z"></path></svg></button>
                                    </div>
                                    <div class="info_box">
                                        <label for><?= htmlspecialchars($commentaire['email']) ?> | <?= date('d M Y', strtotime($commentaire['date_comment'])) ?></label>
                                        <p><?= htmlspecialchars($commentaire['texte']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach ?>   
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
