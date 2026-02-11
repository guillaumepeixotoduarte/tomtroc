<?php

namespace App\Models;

require_once ROOT . '/app/Core/Entity.php';

use App\Core\Entity;
class Message extends Entity {

    private string $content;
    private string $createdAt;
    private int $readed; // 0 pour non lu, 1 pour lu
    private int $userId;
    private int $conversationId;

    /**
     * Renvoie l'heure si le message est envoyé aujourd'hui sinon la date
     * @return string
     */
    public function getChatTimestamp(): string
    {
        $date = new \DateTime($this->createdAt);
        $today = new \DateTime('today');
        $yesterday = new \DateTime('yesterday');

        if ($date->format('Y-m-d') === $today->format('Y-m-d')) {
            return $date->format('H:i');
        }

        if ($date->format('Y-m-d') === $yesterday->format('Y-m-d')) {
            return "Hier";
        }

        return $date->format('d.m');
    }

    public function getFullTimestamp(): string
    {
        if (!$this->createdAt) return '';
        $date = new \DateTime($this->createdAt);
        
        // Retourne 11.02 14:30
        return $date->format('d.m H:i');
    }


    public function getContent(): string { return $this->content; }
    public function setContent(string $content): void { $this->content = $content; }

    public function getCreatedAt(): string { return $this->createdAt; }
    public function setCreatedAt(string $date): void { $this->createdAt = $date; }

    public function getReaded(): int { return $this->readed; }
    public function setReaded(int $readed): void { $this->readed = $readed; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $id): void { $this->userId = $id; }

    public function getConversationId(): int { return $this->conversationId; }
    public function setConversationId(int $id): void { $this->conversationId = $id; }
}