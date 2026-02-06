<?php

require_once ROOT . '/app/Models/Entities/Book.php';
require_once ROOT . '/app/Models/Managers/BookManager.php';
require_once ROOT . '/app/Core/Controller.php';

use App\Core\Controller;
use App\Managers\BookManager;

class HomeController extends Controller {
    public function index() {
        // Données à transmettre à la vue
        $title = "Page d'accueil";
        $username = "Invité"; // Exemple de donnée dynamique

        $bookManager = new BookManager();
        $latestBooks = $bookManager->findAll(4, true); // Récup

        // On charge la vue principale
        $this->render('home', [
            'title' => $title,
            'username' => $username,
            'latestBooks' => $latestBooks
        ]);
    }
}