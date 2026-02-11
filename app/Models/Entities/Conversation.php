<?php

namespace App\Models;

require_once ROOT . '/app/Core/Entity.php';

use App\Core\Entity;
class Conversation extends Entity {
    private string $createdAt;

    // Propriétés "virtuelles" pour stocker les objets liés
    private ?User $contact = null;
    private ?Message $lastMessage = null;

    public function getCreatedAt(): string { return $this->createdAt; }
    public function setCreatedAt(string $date): void { $this->createdAt = $date; }

    public function getContact(): ?User { return $this->contact; }
    public function setContact(User $contact): void { $this->contact = $contact; }

    public function getLastMessage(): ?Message { return $this->lastMessage; }
    public function setLastMessage(Message $message): void { $this->lastMessage = $message; }
}