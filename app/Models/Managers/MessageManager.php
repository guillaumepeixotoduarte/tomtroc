<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Models/Entities/User.php';
require_once ROOT . '/app/Models/Entities/Message.php';

use App\Core\Database;
use App\Models\Message;
use App\Models\User;  


class MessageManager {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère tous les messages d'une conversation par ordre chronologique.
     * @param int $conversationId
     * @return array Liste des messages (table 'message')
     */
    public function findAllMessagesByConversation(int $conversationId): array
    {
        // On sélectionne tout, trié par date ascendante (le flux normal d'un chat)
        $sql = "SELECT * FROM message 
                WHERE conversation_id = :conv_id 
                ORDER BY created_at ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['conv_id' => $conversationId]);

        $messages = [];

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach($rows as $row){
            $message = new Message($row);
            $messages[] = $message;
        }

        return $messages;

    }

    public function createFullConversation(int $senderId, int $recipientId, string $content): int 
    {
        try {
            $this->db->beginTransaction();

            // A. Créer la conversation
            $stmt = $this->db->prepare("INSERT INTO conversations (created_at) VALUES (NOW())");
            $stmt->execute();
            $convId = (int)$this->db->lastInsertId();

            // B. Ajouter les participants
            $stmt = $this->db->prepare("INSERT INTO participants (conversation_id, user_id) VALUES (?, ?)");
            $stmt->execute([$convId, $senderId]);
            $stmt->execute([$convId, $recipientId]);

            // C. Créer le premier message (On utilise tes noms de colonnes : content, user_id, conversation_id)
            $stmt = $this->db->prepare("INSERT INTO message (content, created_at, readed, user_id, conversation_id) VALUES (?, NOW(), 0, ?, ?)");
            $stmt->execute([$content, $senderId, $convId]);

            $this->db->commit();
            
            return $convId; // On renvoie uniquement l'ID

        } catch (\Exception $e) {
            $this->db->rollBack();
            // On relance l'exception pour que le controller soit au courant
            throw new \Exception("Impossible de créer la conversation : " . $e->getMessage());
        }
    }

    /**
     * Marquer tout les messages d'une discution comme lu
     * @param int $conversationId
     * @param int $currentUserId
     * @return void
     */
    public function markAsRead(int $conversationId, int $currentUserId): void
    {
        $sql = "UPDATE message 
                SET readed = TRUE 
                WHERE conversation_id = :conv_id 
                AND user_id != :user_id 
                AND readed = FALSE";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'conv_id' => $conversationId,
            'user_id' => $currentUserId
        ]);
    }

    /**
     * Envoie un nouveau message
     */
    public function addMessage(int $conversationId, int $userId, string $content): bool {
        $sql = "INSERT INTO message (content, created_at, readed, user_id, conversation_id) 
                VALUES (:content, NOW(), 0, :user_id, :conv_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'content' => htmlspecialchars($content),
            'user_id' => $userId,
            'conv_id' => $conversationId
        ]);
    }
}