<?php

require_once ROOT . '/app/Models/Entities/Book.php';
require_once ROOT . '/app/Models/Managers/BookManager.php';
require_once ROOT . '/app/Core/Controller.php';

use App\Models\Book;
use App\Managers\BookManager;
use App\Core\Controller;

class BookController extends Controller {
    
    // Page : Détails d'un livre spécifique
    public function show($id) {

        $bookManager = new BookManager();
        $book = $bookManager->findOne((int)$id, true); // Récupère le livre avec les infos utilisateur

        if (!$book) {
            $_SESSION['error'] = "Livre introuvable.";
            redirect('nos-livres');
        }

        $this->render('book_details', [
            'title' => 'Détails du livre',
            'book' => $book
        ]);
    }

    public function ourBooks() {
        $bookManager = new BookManager();

        $search = (!empty($_GET['search'])) ? ($_GET['search']) : '';

        $books = $bookManager->findFiltered($search, null, true); // Récupère tous les livres disponibles avec les infos utilisateur

        $this->render('our_books', [
            'title' => 'Nos livres disponibles',
            'books' => $books
        ]);
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
            'title' => $id ? 'Modifier les informations' : 'Ajouter un livre',
            'book'  => $book
        ]);
    }

    public function saveBook() {
        $bookManager = new BookManager();
        $id = $_POST['id'] ?? null;
        
        $existingBook = $id ? $bookManager->findOne((int)$id) : null;
        $imageName = $existingBook ? $existingBook->getImage() : null;

        // On vérifie si une image est passé
        if (!empty($_FILES['coverImage']['name'])) {
            $uploadedFile = $this->uploadImage($_FILES['coverImage'], 'book_cover', 'book_');
            
            if ($uploadedFile) {
                // On mémorise l'ancienne image pour la supprimer plus tard
                $oldImageToDelete = $imageName; 
                $imageName = $uploadedFile;
            }else{
                redirect($id ? 'book/edit/'.$id : 'book/edit');
            }
        }

        // Si $imageName est vide c'est que ce n'est pas livre existant et que l'ajout d'un nouveau livre n'a pas passé d'image
        if (!$imageName) {
            $_SESSION['error'] = "Une image de couverture est requise.";
            redirect($id ? 'book/edit/'.$id : 'book/edit');
        }

        // 4. Enregistrement unique
        if ($bookManager->save($_POST, $imageName)) {
            // Si tout est OK, on nettoie l'ancienne image si elle a été remplacée
            if (!empty($oldImageToDelete)) {
                $this->deleteImage($oldImageToDelete, 'book_cover');
            }
            $_SESSION['success'] = "Livre enregistré !";
            redirect('my-profile');
        }

        // Si on arrive ici, c'est que la BDD a échoué
        $_SESSION['error'] = "Erreur lors de l'enregistrement.";
        redirect($id ? 'book/edit/'.$id : 'book/edit');
    }

    public function deleteBook(int $id){
        
        $bookManager = new BookManager();
        
        $book = $bookManager->findOne((int)$id);
        
        // Sécurité : on vérifie que le livre appartient bien à l'utilisateur connecté
        if (!$book || $book->getUserId() !== $_SESSION['user']['id']) {
            $_SESSION['error'] = "Livre introuvable ou accès refusé.";
            redirect(path: 'my-profile');
        }
    
        if($bookManager->deleteByID($id)){
            $_SESSION['success'] = "Livre supprimé avec succès";
            $this->deleteImage($book->getImage(), 'book_cover');
        }else{
            $_SESSION['error'] = "Une erreur s'est produite lors de la suppression du livre";
        }
        redirect(path: 'my-profile');
    }
}