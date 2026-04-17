<?php
/**
 * Script de déconnexion simple
 * 
 * Ce script détruit la session et redirige l'utilisateur vers la page de connexion
 */

// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vider toutes les variables de session
$_SESSION = [];

// Détruire le cookie de session si présent
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),           // Nom du cookie de session
        '',                       // Valeur vide
        time() - 42000,          // Date dans le passé (expiration immédiate)
        $params["path"],         // Chemin
        $params["domain"],       // Domaine
        $params["secure"],       // Sécurisé (HTTPS)
        $params["httponly"]      // Accessible uniquement via HTTP
    );
}

// Détruire complètement la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: auth.php");
exit(); // Toujours appeler exit après une redirection
?>