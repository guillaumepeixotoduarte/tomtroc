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


    // Récupérer un objet Book précis
    public function findOne(int $id, bool $includeUser = false): ?Book {

        $sql = "SELECT * FROM books WHERE id = :id";

        if ($includeUser) {
            $sql = "SELECT b.*, u.username, u.profil_image FROM books b JOIN users u ON b.user_id = u.id WHERE b.id = :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!$row) {
            return null; // Aucun livre trouvé
        }

        $book = new Book($row);
        if ($includeUser && isset($row['username'])) {
            $book->setOwner(new User(['username' => $row['username'], 'profil_image' => $row['profil_image'] ?? null]));
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
     * @param string $search Permet de recherche les livres contenant la valeur passé
     * @param int|null $limit Nombre de livres à récupérer
     * @param int|null $includeUser Si on veut récupérer l'username et la photo de profil de l'utilisateur lié au livre
     * @return array Tableau d'objets Book
     */
    public function findFiltered(string $search, int|null $limit = null, bool $includeUser = false): array
    {
        $select = "SELECT b.*";
        $join = "";
        $where = " WHERE 1=1"; // Astuce pour chaîner les "AND" facilement
        $params = [];

        if ($includeUser) {
            $select .= ", u.username, u.profil_image";
            $join = " INNER JOIN users u ON b.user_id = u.id";
        }

        // Gestion de la recherche par titre
        if ($search && $search != '') {
            $where .= " AND b.title LIKE :search";
            $params['search'] = '%' . $search . '%';
        }

        $sql = "$select FROM books b $join $where ORDER BY b.id DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->db->prepare($sql);

        // Liaison des paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
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
                $user->setProfilImage($bookData['profil_image'] ?? null);
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

    public function save(array $data, string $fileName) {
        
        if (isset($data['id']) && !empty($data['id'])) {

            $sql = "UPDATE `books` SET title = :title, author = :author, image = :image , description = :description, statut_exchange = :statut_exchange
                    WHERE id = :id AND user_id = :user_id";

            $params = [
                'title'   => $data['title'],
                'author'  => $data['author'],
                'description'  => $data['description'],
                'statut_exchange'  => $data['availability'],
                'image'   => $fileName,
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
                'image'   => $fileName,
                'user_id' => $_SESSION['user']['id']
            ];
        }

        return $this->db->prepare($sql)->execute($params);
    }

    public function deleteById(int $id){
        $sql = "DELETE FROM books WHERE id = :id";
        $params = ['id' => $id];

        return $this->db->prepare($sql)->execute($params);
    }

}