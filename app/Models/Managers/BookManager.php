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
}