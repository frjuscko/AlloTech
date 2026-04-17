<?php
require('config/database.php');
// ✅ Ajoutez ces requêtes après require('config/database.php')
$competences = $pdo->query("SELECT * FROM competences")->fetchAll();
$villes = $pdo->query("SELECT * FROM villes")->fetchAll();

$search = $_GET['search'] ?? '';
$ville = $_GET['ville'] ?? '';
$competence = $_GET['competence'] ?? '';

$sql = "SELECT 
                t.id,
                t.adresse,
                t.titre,
                u.nom,
                u.prenom,
                u.photo,
                v.nom AS ville,
                c.libelle AS competence
            FROM techniciens t
            JOIN users u ON t.user = u.id
            LEFT JOIN villes v ON t.ville = v.id
            LEFT JOIN competences c ON t.competence = c.id
            WHERE 1=1";

$params = [];

// Recherch
if (!empty($search)) {
    $sql .= " AND (u.nom LIKE :search OR u.prenom LIKE :search)";
    $params[':search'] = "%" . $search . "%";;
}

if (!empty($ville)) {
    $sql .= " AND t.ville = :ville";
    $params[':ville'] = $ville;
}

if (!empty($competence)) {
    $sql .= " AND t.competence = :competence";
    $params[':competence'] = $competence;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$techs = $stmt->fetchAll();
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
        <link rel="stylesheet" href="css/footer.css">
        <script src="js/navbar.js" defer></script>
        <script src="js/search.js" defer></script>
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
                        <li class="logList"><a href="admin.php" class="link logLink"><svg
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
                <p class="chemin"><a href="index.html">accueil /</a>
                    techniciens</p>
                <h1 class="header">Trouvez un technicien</h1>
                <p>Parcourez notre réseau de techniciens qualifiés selon vos
                    besoins et votre localisation.</p>
            </div>
            <div class="section">
                
                    <form method="GET" class="search-zone" id="searchForm">

                        <!-- Compétence -->
                        <select class="blanc" name="competence">
                            <option value="">Compétence</option>
                            <?php foreach ($competences as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($competence == $c['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['libelle']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <!-- Ville -->
                        <select class="blanc" name="ville">
                            <option value="">Adresse</option>
                            <?php foreach ($villes as $v): ?>
                                <option value="<?= $v['id'] ?>" <?= ($ville == $v['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($v['nom']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <!-- Barre de recherche -->
                        <div class="search-bar">
                            <input 
                                type="text" 
                                name="search" 
                                class="blanc" 
                                placeholder="Rechercher un technicien..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                                required
                            >

                            <button type="submit" class="blanc">
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"><path
                                    d="M12 14V16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM21.4462 20.032L22.9497 21.5355L21.5355 22.9497L20.032 21.4462C19.4365 21.7981 18.7418 22 18 22C15.7909 22 14 20.2091 14 18C14 15.7909 15.7909 14 18 14C20.2091 14 22 15.7909 22 18C22 18.7418 21.7981 19.4365 21.4462 20.032ZM18 20C19.1046 20 20 19.1046 20 18C20 16.8954 19.1046 16 18 16C16.8954 16 16 16.8954 16 18C16 19.1046 16.8954 20 18 20Z"></path></svg>
                            </button>
                        </div>

                    </form>
                <p class="section-title">Nous répertorions <?= count($techs) ?> techniciens</p>
                <div class="techs-grid">
                    <?php foreach($techs as $tech): ?>
                        <a href="tech.php?id=<?= $tech['id'] ?>">
                            <div class="tech">
                                <div class="image">
                                    <div class="photo">
                                        <img src="<?= htmlspecialchars($tech['photo']) ?>" alt>
                                    </div>
                                </div>
                                <div class="texte">
                                    <p class="name"><?= htmlspecialchars($tech['prenom']) ?> <?= htmlspecialchars($tech['nom']) ?></p>
                                    <p class="infos blue-clr"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M18.001 20.0026V14.6693H20.001V22.0026H4.00098V14.6693H6.00098V20.0026H18.001ZM7.59977 14.7359L7.913 12.7566L16.75 14.456L16.6367 16.0421L7.59977 14.7359ZM8.79937 10.2041L9.53245 8.60463L17.5298 12.3367L16.7967 13.9362L8.79937 10.2041ZM11.0653 6.27208L12.1982 4.9392L18.9959 10.604L17.863 11.9368L11.0653 6.27208ZM15.3972 2.14014L20.6621 9.20443L19.2625 10.2707L13.9976 3.20645L15.3972 2.14014ZM7.33319 18.6679V16.6686H16.6634V18.6679H7.33319Z"></path></svg>
                                        <?= htmlspecialchars($tech['titre']) ?></p>
                                    <p class="infos"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M18.364 17.364L12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364ZM12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15ZM12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11C14 12.1046 13.1046 13 12 13Z"></path></svg>
                                        <?= htmlspecialchars($tech['adresse']) ?></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
                <!-- Après le foreach, ajoutez : -->
                <?php if (empty($techs)): ?>
                    <div class="no-results">
                        <p>Aucun technicien ne correspond à vos critères.</p>
                    </div>
                <?php endif; ?>
                <div class="pagination">

                </div>
            </div>
        </main>
        <footer>
            <div class="footer_part">
                <a href="index.html"><div class="logo"></div></a>
                <div class="footer_text">
                    <div class="footer_links">
                        <ul>
                            <li><a href>accueil</a></li>
                            <li><a href>techniciens</a></li>
                            <li><a href>contacts</a></li>
                        </ul>
                    </div>
                    <p>© 2026 AlloTech. Tous droits réservés.</p>
                </div>
            </div>
            <div class="footer_part" id="right">
                <a href="https://cliffaservices.com" target="_blank">
                    <div class="cliffa">
                        <img src="imgs/logoCliffa.png" alt>
                    </div>
                </a>
                <div class="footer_reseaux">
                    <ul>
                        <li>
                            <a href="https://wa.me//+2290196797995"
                                target="_blank"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 
                                        20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 
                                        3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 
                                        3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 
                                        5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 
                                        8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 
                                        14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 
                                        20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.
                                        1633 21 16.42Z"></path></svg>
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.facebook.com/cliffaservices/?locale=ml_IN"
                                target="_blank"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47062 14 5.5 16 5.5H17.5V2.1401C17.1743 2.09685 
                                        15.943 2 14.6429 2C11.9284 2 10 3.65686 10 6.69971V9.5H7V13.5H10V22H14V13.5Z"></path></svg>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:contact@cliffaservices.com"
                                target="_blank"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 
                                        2 20V4C2 3.44772 2.44772 3 3 3ZM12.0606 11.6829L5.64722 6.2377L4.35278 7.7623L12.0731 
                                        14.3171L19.6544 7.75616L18.3456 6.24384L12.0606 11.6829Z"></path></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://cliffaservices.com"
                                target="_blank"><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"><path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 
                                        22 12C22 17.5228 17.5228 22 12 22ZM9.71002 19.6674C8.74743 17.6259 8.15732 15.3742 
                                        8.02731 13H4.06189C4.458 16.1765 6.71639 18.7747 9.71002 19.6674ZM10.0307 13C10.1811 
                                        15.4388 10.8778 17.7297 12 19.752C13.1222 17.7297 13.8189 15.4388 13.9693 13H10.0307ZM19.9381 
                                        13H15.9727C15.8427 15.3742 15.2526 17.6259 14.29 19.6674C17.2836 18.7747 19.542 16.1765 
                                        19.9381 13ZM4.06189 11H8.02731C8.15732 8.62577 8.74743 6.37407 9.71002 4.33256C6.71639 
                                        5.22533 4.458 7.8235 4.06189 11ZM10.0307 11H13.9693C13.8189 8.56122 13.1222 6.27025 12 
                                        4.24799C10.8778 6.27025 10.1811 8.56122 10.0307 11ZM14.29 4.33256C15.2526 6.37407 
                                        15.8427 8.62577 15.9727 11H19.9381C19.542 7.8235 17.2836 5.22533 14.29 4.33256Z"></path></svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>