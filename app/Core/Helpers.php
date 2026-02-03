<?php

    function dd($variable) {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        die();
    }

    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    function url($path) {
        // On s'assure que le chemin commence par un /
        $path = '/' . ltrim($path, '/');
        
        // On redirige vers l'URL complète
        return BASE_URL . $path;
    }

    function redirect($path) {
        header('Location: ' . url($path));
        exit();
    }

    function navBarIsActive($pagePath) {
        // On récupère l'URL actuelle depuis le GET (définie dans ton index.php)
        $currentPath = $_GET['url'] ?? 'home';
        
        // On nettoie les slashs pour comparer proprement
        return trim($currentPath, '/') === trim($pagePath, '/') ? 'active fw-semibold' : '';
    }

?>