<?php

require_once ROOT . '/app/Core/Database.php';

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

    public function findByEmailOrUsername($email, $username) {
        $sql = "SELECT * FROM users WHERE email = :email OR username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email'    => $email,
            'username' => $username
        ]);
        
        // fetch() renvoie l'utilisateur s'il existe, ou false sinon
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch();
    }
}