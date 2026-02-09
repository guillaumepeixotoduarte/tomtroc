<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';

use App\Core\Database;
use App\Models\User;

class UserManager {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); 
    }

    public function create($username, $email, $password) {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => 'user'
        ]);
    }

    public function updateProfile($id, $username, $email, $password) {

        $params = [
            'id' => $id,
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($params);
    }

    public function updateProfileImage($id, $profilImageName) {
        $sql = "UPDATE users SET profil_image = :profil_image WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'id' => $id,
            'profil_image' => $profilImageName
        ]);
    }

    public function findByEmailOrUsername($email, $username, $includeCurrentUser = false) {

        $params = [
            'email'    => $email,
            'username' => $username
        ];
        $whereNotCurrentUser = '';

        if($includeCurrentUser){
            $params['id'] = (!empty($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0);
            $whereNotCurrentUser = "AND id != :id ";
        }

        $sql = "SELECT * FROM users WHERE ( email = :email OR username = :username ) $whereNotCurrentUser";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        // fetch() renvoie l'utilisateur s'il existe, ou false sinon
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();
        if($user){
            return new User($user);
        }
        
        return null;
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();
        if($user){
            return new User($user);
        }
        
        return null;
    }
}