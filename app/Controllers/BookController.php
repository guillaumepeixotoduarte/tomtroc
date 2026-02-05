<?php

require_once ROOT . '/app/Models/Entities/Book.php';
require_once ROOT . '/app/Models/Managers/BookManager.php';
require_once ROOT . '/app/Core/Controller.php';

use App\Models\Book;
use App\Managers\BookManager;
use App\Core\Controller;

class BookController extends Controller {
    
    
    public function index() {

        require_once ROOT . '/views/books/list.php';
    }

    // Page : Détails d'un livre spécifique
    public function show($id) {

        require_once ROOT . '/views/books/detail.php';
    }

    public function edit($id = null) {
        $bookManager = new BookManager();
        $book = null;

        if ($id) {
            // Mode MODIFICATION
            $book = $bookManager->findOne((int)$id);
            
            // Sécurité : on vérifie que le livre appartient bien à l'utilisateur connecté
            if (!$book || $book->getUserId() !== $_SESSION['user']['id']) {
                $_SESSION['error'] = "Livre introuvable ou accès refusé.";
                redirect(path: 'my-profile');
            }
        }

        // On envoie le livre à la vue (il sera null si c'est un ajout)
        $this->render('form_book', [
            'title' => $id ? 'Modifier le livre' : 'Ajouter un livre',
            'book'  => $book
        ]);
    }

    public function saveBook() {
        
        $bookManager = new BookManager();
        
        if(isset($_POST['id']) && !empty($_POST['id'])) {
            // En mode modification, on vérifie que le livre existe et appartient à l'utilisateur
            $existingBook = $bookManager->findOne((int)$_POST['id']);
            if (!$existingBook || !isset($_SESSION['user']['id']) || $existingBook->getUserId() !== $_SESSION['user']['id']) {
                $_SESSION['error'] = "Livre introuvable ou accès refusé.";
                redirect('login');
            }
        }

        // On passe $_POST pour les textes et $_FILES pour l'image
        if ($bookManager->save($_POST, $_FILES['cover_image'])) {
            $_SESSION['success'] = "Livre enregistré avec succès !";
            redirect('my-profile');
        } else {
            $_SESSION['error'] = "Une erreur est survenue.";
            redirect('book/edit' . (isset($_POST['id']) ? '/' . $_POST['id'] : ''));
        }
        
    }
}