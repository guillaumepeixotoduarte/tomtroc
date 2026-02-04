<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Models/Entities/Book.php';

use App\Core\Database;
use App\Models\Book;  


class BookManager {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Récupérer tous les livres sous forme d'objets Book
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM books");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book($row);
        }
        return $books;
    }

    // Récupérer un objet Book précis
    public function findOne(int $id): ?Book {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? new Book($row) : null;
    }

    public function findAllByIdUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE user_id = ?");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book($row);
        }
        return $books;
    }

    public function save(array $data, array $file) {
        
        // 1. Gestion de l'image (si une nouvelle image est uploadée)
        $imagePath = $data['current_cover'] ?? null; // Garder l'ancienne par défaut
        
        if ($file && $file['error'] === 0) {
            $imagePath = $this->uploadImage($file);
        }

        if (isset($data['id']) && !empty($data['id'])) {

            $actualBook = $this->findOne((int)$data['id']);

            if ($actualBook && $actualBook->getImage() && $actualBook->getImage() !== $imagePath) {
                $oldFilePath = ROOT . '/public/uploads/book_cover/' . $actualBook->getImage();
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); 
                }
            }

            $sql = "UPDATE `books` SET title = :title, author = :author, image = :image , description = :description, statut_exchange = :statut_exchange
                    WHERE id = :id AND user_id = :user_id";

            $params = [
                'title'   => $data['title'],
                'author'  => $data['author'],
                'description'  => $data['description'],
                'statut_exchange'  => $data['availability'],
                'image'   => $imagePath,
                'id'      => $data['id'],
                'user_id' => $_SESSION['user']['id']
            ];
        } else {

            $sql = "INSERT INTO `books` (title, author, description, statut_exchange, image, user_id) 
                    VALUES (:title, :author, :description, :statut_exchange, :image, :user_id)";

            $params = [
                'title'   => $data['title'],
                'author'  => $data['author'],
                'description'  => $data['description'],
                'statut_exchange'  => $data['availability'],
                'image'   => $imagePath,
                'user_id' => $_SESSION['user']['id']
            ];
        }

        return $this->db->prepare($sql)->execute($params);
    }

    private function uploadImage($file) {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        // On génère un nom unique pour éviter d'écraser des fichiers
        $newName = uniqid('book_', true) . '.' . $extension;
        $destination = ROOT . '/public/uploads/book_cover/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newName; // On renvoie le nom du fichier pour le stocker en BDD
        }
        return null;
    }

}