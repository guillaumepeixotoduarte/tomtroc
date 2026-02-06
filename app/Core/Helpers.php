<?php

    /**
     * Fonction pour print une variable et arrêter l'exécution (pour le debug)
     */
    function dd($variable) {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        die();
    }

    /**
     * Nettoie une entrée utilisateur pour éviter les failles XSS et autres problèmes de sécurité
     */
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    /**
     * Construit une URL complète à partir d'un chemin relatif
     */
    function url($path) {
        // On s'assure que le chemin commence par un /
        $path = '/' . ltrim($path, '/');
        
        // On redirige vers l'URL complète
        return BASE_URL . $path;
    }

    /**
     * Redirige vers une URL construite à partir du chemin donné
     */
    function redirect($path) {
        header('Location: ' . url($path));
        exit();
    }

    /**
     * Indique si la route ou se trouve l'utilisateur est la même que celle passée en paramètre, pour activer la classe CSS "active" dans la navbar
     */
    function navBarIsActive($pagePath) {
        // On récupère l'URL actuelle depuis le GET (définie dans ton index.php)
        $currentPath = $_GET['url'] ?? 'home';
        
        // On nettoie les slashs pour comparer proprement
        return trim($currentPath, '/') === trim($pagePath, '/') ? 'active fw-semibold' : '';
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    function isLogged(): bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    /**
     * Vérifie si la route demandée est publique ou nécessite une authentification, et redirige si nécessaire
     */
    function checkAccessNotLogged(string $controller, string $action) {

        $public_routes = [
            'home' => ['index'],
            'nos-livres' => ['index'],
            'book' => ['detail'], // book/detail/{id}
            'profile' => ['index'], // profile/{id}
            'login' => ['index'],
            'login-user' => ['index'],
            'register' => ['index'],
            'inscription-save' => ['index']
        ];

        $isPublic = isset($public_routes[$controller]) && in_array($action, $public_routes[$controller]);
    

        if (!$isPublic && !isLogged()) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
            header('Location: ' . url('/login'));
            exit;
        }
    }

    /**
     * Renvoie l'URL vers l'image d'un livre
     */
    function getBookImageUrl($imagePath) {
        return url('uploads/book_cover/' . $imagePath);
    }

    /**
    * Renvoie l'URL vers l'image de profil d'un utilisateur
    */
    function getProfileImageUrl($imagePath) {
        return url('uploads/profile_images/' . $imagePath);
    }

    /**
     * Coupe un texte à une longueur donnée sans couper les mots
     */
    function truncate(string $text, int $limit = 50): string 
    {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        // On coupe à la limite
        $text = mb_substr($text, 0, $limit);

        // On cherche le dernier espace pour ne pas couper un mot
        $lastSpace = mb_strrpos($text, ' ');
        if ($lastSpace !== false) {
            $text = mb_substr($text, 0, $lastSpace);
        }

        return $text . '...';
    }

?>