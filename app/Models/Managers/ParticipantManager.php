<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Models/Entities/Participant.php';

use App\Core\Database;
use App\Models\Participant;

class ParticipantManager {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addParticipant(int $conversationId, int $userId): void {
        $stmt = $this->db->prepare("INSERT INTO participants (conversation_id, user_id) VALUES (?, ?)");
        $stmt->execute([$conversationId, $userId]);
    }

    public function getRecipientId(int $conversationId, int $currentUserId): ?int 
    {
        // On cherche l'ID de l'autre participant...
        // ...MAIS seulement si une ligne existe aussi pour l'utilisateur actuel dans cette conv
        $sql = "SELECT p1.user_id 
                FROM participants p1
                WHERE p1.conversation_id = :conv_id 
                AND p1.user_id != :current_user_id
                AND EXISTS (
                    SELECT 1 FROM participants p2 
                    WHERE p2.conversation_id = :conv_id 
                    AND p2.user_id = :current_user_id
                )";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'conv_id' => $conversationId,
            'current_user_id' => $currentUserId
        ]);
        
        $result = $stmt->fetchColumn();
        
        return $result ? (int)$result : null;
    }

    // Récupère l'ID de la conversation entre deux utilisateurs
    public function findConversationBetween(int $user1, int $user2): ?int {
        $sql = "SELECT p1.conversation_id 
                FROM participants p1
                INNER JOIN participants p2 ON p1.conversation_id = p2.conversation_id
                WHERE p1.user_id = :u1 AND p2.user_id = :u2";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['u1' => $user1, 'u2' => $user2]);
        $res = $stmt->fetch();
        return $res ? (int)$res['conversation_id'] : null;
    }
}