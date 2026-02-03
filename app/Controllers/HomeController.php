<?php

require_once ROOT . '/app/Models/Book.php';
require_once ROOT . '/app/Models/BookManager.php';
require_once ROOT . '/app/Core/Controller.php';

class HomeController extends Controller {
    public function index() {
        // Données à transmettre à la vue
        $title = "Page d'accueil";
        $username = "Invité"; // Exemple de donnée dynamique

        // On charge la vue principale
        $this->render('home', [
            'title' => $title,
            'username' => $username
        ]);
    }
}