<?php

namespace App\Models;

require_once ROOT . '/app/Core/Entity.php';

use App\Core\Entity;

class Participant extends Entity {
    private int $conversationId;
    private int $userId;

    public function getConversationId(): int { return $this->conversationId; }
    public function setConversationId(int $id): void { $this->conversationId = $id; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $id): void { $this->userId = $id; }
}