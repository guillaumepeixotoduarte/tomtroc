<?php
namespace App\Models;

require_once ROOT . '/app/Core/Entity.php';

use \App\Core\Entity;

class Book extends Entity {
    private string $title;
    private string $author;
    private ?string $image;
    private ?string $description;
    private ?bool $statutExchange = null;
    private ?int $userId = null;

    /**
     * Setter pour le titre du livre.
     * @param string $title
     */
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre du livre.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour l'auteur du livre.
     * @param string $author
     */
    public function setAuthor(string $author) : void
    {
        $this->author = $author;
    }

    /**
     * Getter pour l'auteur du livre.
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter pour l'image du livre.
     * @param string|null $image
     */
    public function setImage(?string $image) : void
    {
        $this->image = $image;
    }

    /**
     * Getter pour l'image du livre.
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Setter pour la description du livre.
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }

    /**
     * Getter pour la description du livre.
     * @return string|null
     */
    
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter pour le statut d'échange du livre.
     * @param bool|null $statutExchange
     */
    public function setStatutExchange(?bool $statutExchange) : void
    {
        $this->statutExchange = $statutExchange;
    }

    /**
     * Getter pour le statut d'échange du livre.
     * @return bool|null
     */
    public function getStatutExchange(): ?bool
    {
        return $this->statutExchange;
    }

    /**
     * Setter pour l'id de l'utilisateur. 
     * @param int $userId
     */
    public function setUserId(int $userId) : void 
    {
        $this->userId = $userId;
    }

    /**
     * Getter pour l'id de l'utilisateur.
     * @return int|null
     */
    public function getUserId(): ?int
    {   
        return $this->userId;
    }
}