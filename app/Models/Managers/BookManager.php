<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Models/Entities/Book.php';
require_once ROOT . '/app/Models/Entities/User.php';

use App\Core\Database;
use App\Models\Book;  
use App\Models\User;  


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
    public function findOne(int $id, bool $includeUser = false): ?Book {

        $sql = "SELECT * FROM books WHERE id = :id";

        if ($includeUser) {
            $sql = "SELECT b.*, u.username FROM books b JOIN users u ON b.user_id = u.id WHERE b.id = :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!$row) {
            return null; // Aucun livre trouvé
        }

        $book = new Book($row);
        if ($includeUser && isset($row['username'])) {
            $book->setOwner(new User(['nickname' => $row['username']]));
        }

        return $book;
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

    /**
     * Récupère les derniers livres ajoutés
     * @param int|null $limit Nombre de livres à récupérer
     * @return array Tableau d'objets Book
     */
    public function findDisponibleBooks(int|null $limit = null, bool $includeUser = false): array
    {
        $select = "SELECT b.*";
        $join = "";
        
        if ($includeUser) {
            $select .= ", u.username";
            $join = " INNER JOIN users u ON b.user_id = u.id";
        }

        // On ne récupère que les livres dont le statut est "disponible" (souvent 1 en BDD)
        $sql = "$select FROM books b $join WHERE b.statut_exchange = 1 ORDER BY b.id DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->db->prepare($sql);
        // On force le type en INT car PDO a parfois du mal avec LIMIT et les strings
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        }
        $stmt->execute();
        
        $data = $stmt->fetchAll();
        $books = [];
        
        foreach ($data as $bookData) {
            $book = new Book($bookData); // On transforme chaque ligne en objet

            if (isset($bookData['username'])) {
                $user = new User();
                $user->setUsername($bookData['username']);
                if (isset($bookData['user_id'])) {
                    $user->setId($bookData['user_id']);
                }
                
                // On lie l'objet User à l'objet Book
                $book->setOwner($user);
            }

            $books[] = $book; // On ajoute l'objet Book au tableau final
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