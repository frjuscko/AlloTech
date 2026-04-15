<?php

class AvatarGenerator {

    private $avatarDir = __DIR__ . '/../avatars/';

    public function generateAvatar($prenom, $size = 200) {
        // Sécuriser le prénom
        $prenom = trim($prenom);
        $initial = strtoupper(substr($prenom, 0, 1));

        if (empty($initial)) {
            $initial = '?';
        }

        // Générer 2 couleurs pour le dégradé
        [$color1, $color2] = $this->generateGradientColors($prenom);

        // Créer le SVG
        $svg = $this->createSVG($initial, $color1, $color2, $size);

        // Nom unique du fichier
        $filename = 'avatar_' . uniqid() . '.svg';

        // Chemin complet
        $filePath = $this->avatarDir . $filename;

        // Créer dossier si n'existe pas
        if (!file_exists($this->avatarDir)) {
            mkdir($this->avatarDir, 0777, true);
        }

        // Sauvegarder le fichier
        file_put_contents($filePath, $svg);

        // Retourner chemin relatif pour la DB
        return 'avatars/' . $filename;
    }

    private function generateGradientColors($seed) {
        // Générer couleurs basées sur le prénom
        $hash = md5($seed);

        $color1 = '#' . substr($hash, 0, 6);
        $color2 = '#' . substr($hash, 6, 6);

        return [$color1, $color2];
    }

    private function createSVG($letter, $color1, $color2, $size) {
        return '
        <svg width="'.$size.'" height="'.$size.'" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="grad">
                    <stop offset="0%" stop-color="'.$color1.'"/>
                    <stop offset="100%" stop-color="'.$color2.'"/>
                </linearGradient>
            </defs>

            <rect width="200" height="200" fill="url(#grad)" rx="20"/>

            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                font-size="80" fill="#ffffff" font-family="Arial, sans-serif" font-weight="bold">
                '.$letter.'
            </text>
        </svg>
        ';
    }
}