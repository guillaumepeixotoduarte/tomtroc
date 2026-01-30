<?php
// app/Controllers/HomeController.php

class HomeController {
    public function index() {
        // Données à transmettre à la vue
        $title = "Page d'accueil";
        $username = "Invité"; // Exemple de donnée dynamique

        // On charge la vue principale
        require_once ROOT . '/views/home.php';
    }
}