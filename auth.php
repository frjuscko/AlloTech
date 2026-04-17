<?php
    require('config/database.php');
    $competences = $pdo->query("SELECT * FROM competences")->fetchAll();
    $villes = $pdo->query("SELECT * FROM villes")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/auth.css">
        <script src="js/auth.js" defer></script>
        <title>Document</title>
    </head>
    <body>
        <main>
            <div class="part left">
                <div class="login">
                    <h1>Accédez à votre <span
                            class="blue-txt">espace</span></h1>
                    <p class="body">Connectez-vous pour gérer votre profil,
                        recevoir des
                        demandes et développer votre activité sur notre
                        plateforme.</p>
                    <form action="login.php" method="post">
                        <div class="input-box">
                            <input type="email" name="email" required>
                            <label for>Email</label>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" required>
                            <label for>Mot de passe</label>
                        </div>
                        <div class="btns">
                            <button type="submit" class="valid" name="submit">Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="register">
                    <h1>Rejoignez <span class="blue-txt">AlloTech</span></h1>
                    <p class="body">Nous accompagnons les techniciens dans la
                        mise en valeur
                        de leurs compétences et dans la recherche de nouvelles
                        opportunités. Rejoignez une communauté qui vous aide à
                        évoluer.</p>
                    <form action="authTraitement.php" method="post">
                        <div class="slides">
                            <div class="slide">
                                <div class="input-zone">
                                    <div class="input-box">
                                        <input type="text" name="nom" required>
                                        <label for>Nom</label>
                                    </div>
                                    <div class="input-box">
                                        <input type="text" name="prenom" required>
                                        <label for>Prénom</label>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <input type="email" name="email" required>
                                    <label for>Email</label>
                                </div>
                                <div class="input-zone">
                                    <div class="input-box">
                                        <input type="number" name="telephone" required>
                                        <label for>Téléphone</label>
                                    </div>
                                    <div class="input-box">
                                        <input type="number" name="whatsapp" required>
                                        <label for>WhatsApp</label>
                                    </div>
                                </div>
                                <div class="btns">
                                    <button type="button" class="btn next"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg></button>
                                </div>
                            </div>
                            <div class="slide">
                                <div class="select-box">
                                    <label for>Compétence</label>
                                    <select name="competence" id>
                                        <option value>Votre competence</option>
                                        <?php foreach ($competences as $competence): ?>
                                            <option value="<?= htmlspecialchars($competence['id']) ?>"><?= htmlspecialchars($competence['libelle']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="input-box">
                                    <input type="text" name="titre" required>
                                    <label for>Titre (Travail)</label>
                                </div>
                                <div class="select-box">
                                    <label for>Ville</label>
                                    <select name="ville" id>
                                        <option value>Votre ville</option>
                                        <?php foreach ($villes as $ville): ?>
                                            <option value="<?= htmlspecialchars($ville['id']) ?>"><?= htmlspecialchars($ville['nom']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="input-box">
                                    <input type="text" name="adresse" required>
                                    <label for>Adresse</label>
                                </div>
                                <div class="btns">
                                    <button type="button" class="btn prev"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg></button>
                                    <button type="button" class="btn next"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg></button>
                                </div>
                            </div>
                            <div class="slide">
                                <div class="input-box">
                                    <input type="password" id="pass" required>
                                    <label for>Mot de passe</label>
                                </div>
                                <div class="input-box">
                                    <input type="password" name="password" id="passConfirm" required>
                                    <label for>Confirmez votre mot de
                                        passe</label>
                                </div>
                                <div class="btns">
                                    <button type="button" class="btn prev"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"><path
                                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg></button>
                                    <button type="submit" name="submit" class="valid" id="submit">S'inscrire</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <a href="index.php" class="back"><svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="currentColor"><path
                            d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
            </div>
            <div class="part right">
                <div class="top">
                    <a href>
                        <div class="logo"></div>
                    </a>
                    <div class="links">
                        <p class="link" id="logLink">Vous avez déjà un compte ? <a
                                href="#">Se connecter</a></p>
                        <p class="link" id="regLink">Vous n'avez pas encore de compte
                            ? <a
                                href="#">S'inscrire</a></p>
                    </div>
                </div>
                <div class="bottom">
                    <h1>Développez votre activité</h1>
                    <p class="body">Cette plateforme est mise en place par notre
                        entreprise
                        pour valoriser le savoir-faire des techniciens et
                        faciliter leur mise en relation avec des clients. En
                        vous inscrivant, vous intégrez un réseau structuré et
                        gagnez en visibilité.</p>
                    <a href="https://cliffaservices.com" target="_blank">
                        <div class="cliffa">
                            <div class="photo">
                                <img src="imgs/logoCliffa.png" alt>
                            </div>
                            <div class="infos">
                                <p class="name">Cliffa Service</p>
                                <p class="titre">Concepteur de site web</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </body>
</html>