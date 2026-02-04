<?php
namespace App\Models;

require_once ROOT . '/app/Core/Entity.php';

use \App\Core\Entity;

class User extends Entity {
    private string $username;
    private string $email;
    private string $password;
    private string|null $profil_image;
    private string $created_at;
    private string $role;

    /**
     * Calcule l'ancienneté à partir d'une date (format Y-m-d H:i:s)
     */
    function getAccoundAge() {
        $now = new \DateTime();
        $ref = new \DateTime($this->getCreatedAt());
        $diff = $now->diff($ref);

        // 1. On vérifie les années
        if ($diff->y > 0) {
            return $diff->y . ($diff->y > 1 ? " ans" : " an");
        }
        
        // 2. On vérifie les mois
        if ($diff->m > 0) {
            return $diff->m . " mois";
        }
        
        // 3. On vérifie les jours
        if ($diff->d > 0) {
            return $diff->d . ($diff->d > 1 ? " jours" : " jour");
        }

        return "moins d'un jour";
    }




    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }
    
    public function setProfilImage(?string $profil_image): void {
        $this->profil_image = $profil_image;
    }

    public function getProfilImage(): ?string {
        return $this->profil_image;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }

}