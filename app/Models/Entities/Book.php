<?php
namespace App\Models;

class Book {
    private int $id;
    private string $title;
    private string $author;
    private ?string $image;
    private ?string $description;
    private ?bool $statut_exchange = null;
    private ?int $idUser = null;

    /**
     * Setter pour l'id de l'utilisateur. 
     * @param int $idUser
     */
    public function setIdUser(int $idUser) : void 
    {
        $this->idUser = $idUser;
    }


}