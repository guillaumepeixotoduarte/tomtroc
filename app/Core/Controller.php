<?php

namespace App\Core;

abstract class Controller {
    /**
     * Affiche une vue avec des données
     */
    protected function render(string $view, array $data = []) {
        
        // On transforme le tableau de données en variables
        extract($data);
        
        require_once ROOT . '/views/layouts/header.php';
        // On appelle la vue
        $viewFile = ROOT . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("La vue '$view' n'existe pas dans " . $viewFile);
        }

        require_once ROOT . '/views/layouts/footer.php';
    }
}