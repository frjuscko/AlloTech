<?php
require('config/database.php');

// Récupérer les compétences et villes pour les selects
$competences = $pdo->query("SELECT * FROM competences")->fetchAll();
$villes = $pdo->query("SELECT * FROM villes")->fetchAll();
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
                                class="link">Techniciens</a></li>//
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
            <div class="hero-section">
                <div class="part left">
                    <h1 class="header">Trouvez facilement un technicien près de
                        chez vous</h1>
                    <p class="title">Accédez à des professionnels qualifiés
                        selon leur
                        compétence et leur localisation.</p>
                    <!-- Nouveau formulaire de recherche -->
                    <form action="techs.php" method="GET" class="search-zone" id="searchForm">
                        <!-- Compétence -->
                        <select name="competence" class="transparent">
                            <option value="">Compétence</option>
                            <?php foreach ($competences as $c): ?>
                                <option value="<?= $c['id'] ?>">
                                    <?= htmlspecialchars($c['libelle']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <!-- Ville -->
                        <select name="ville" class="transparent">
                            <option value="">Adresse</option>
                            <?php foreach ($villes as $v): ?>
                                <option value="<?= $v['id'] ?>">
                                    <?= htmlspecialchars($v['nom']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <!-- Barre de recherche texte -->
                        <div class="search-bar">
                            <input 
                                type="text" 
                                name="search" 
                                class="transparent" 
                                placeholder="Rechercher un technicien..."
                                value=""
                                required
                            >
                            <button type="submit" class="transparent">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 14V16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM21.4462 20.032L22.9497 21.5355L21.5355 22.9497L20.032 21.4462C19.4365 21.7981 18.7418 22 18 22C15.7909 22 14 20.2091 14 18C14 15.7909 15.7909 14 18 14C20.2091 14 22 15.7909 22 18C22 18.7418 21.7981 19.4365 21.4462 20.032ZM18 20C19.1046 20 20 19.1046 20 18C20 16.8954 19.1046 16 18 16C16.8954 16 16 16.8954 16 18C16 19.1046 16.8954 20 18 20Z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="part right">
                    <div class="container">
                        <p class="header2">Recherchez, contactez, travaillez</p>
                        <p class="body">Notre plateforme met en relation les
                            techniciens et les
                            clients en simplifiant la recherche de services.
                            Trouvez
                            rapidement le professionnel qu'il vous faut selon
                            vos
                            besoins et votre localisation.</p>
                        <div class="vues">
                            <div class="vueD">
                                <div class="top">
                                    <div class="dots">
                                        <div class="dot dot1"></div>
                                        <div class="dot dot2"></div>
                                        <div class="dot dot3"></div>
                                    </div>
                                </div>
                                <div class="contents">
                                    <p class="vueTitle1">Trouvez un
                                        technicien</p>
                                    <p class="vueText1">Parcourez notre réseau
                                        de techniciens qualifiés selon vos
                                        besoins et votre localisation.</p>
                                    <div class="vueBar">
                                        <div class="vueInput">
                                            <div class="vueBtn"></div>
                                        </div>
                                    </div>
                                    <div class="vueFilters">
                                        <p class="filter">Compétence</p>
                                        <p class="filter">Adresse</p>
                                    </div>
                                </div>
                            </div>
                            <div class="vueM">
                                <div class="top"></div>
                            </div>
                        </div>
                        <div class="invite-section">
                            <p class="header2">Tu possèdes une compétence
                                technique ?</p>
                            <p>Rejoins la plateforme et fais toi connaitre !</p>
                            <hr>
                            <img src="imgs/invitImg.jpg" alt srcset>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer></footer>
    </body>
</html>