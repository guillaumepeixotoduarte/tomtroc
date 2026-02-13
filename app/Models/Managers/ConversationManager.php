<?php

namespace App\Managers;

require_once ROOT . '/app/Core/Database.php';
require_once ROOT . '/app/Models/Entities/Conversation.php';
require_once ROOT . '/app/Models/Entities/User.php';
require_once ROOT . '/app/Models/Entities/Message.php';

use App\Core\Database;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;

class ConversationManager {

    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    public function create(): int {
        $stmt = $this->db->query("INSERT INTO conversations (created_at) VALUES (NOW())");
        return (int)$this->db->lastInsertId();
    }

    public function getById(int $id): ?Conversation {
        $stmt = $this->db->prepare("SELECT * FROM conversations WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) return null;

        $conv = new Conversation($data);

        return $conv;
    }

    /**
     * Récupère la liste des conversations d'un utilisateur 
     * avec les détails de l'interlocuteur et le dernier message.
     */
    public function findAllConversationsByUser(int $userId): array
    {
        $sql = "SELECT 
                    c.id AS conversation_id, 
                    m.content AS last_message, 
                    m.created_at AS last_message_date,
                    u.id AS contact_id,
                    u.username AS contact_username, 
                    u.profil_image AS contact_image
                FROM conversations c
                -- 1. On vérifie que l'utilisateur actuel participe à la conversation
                INNER JOIN participants p1 ON c.id = p1.conversation_id AND p1.user_id = :userId
                -- 2. On rejoint la table participants pour trouver l'AUTRE personne
                INNER JOIN participants p2 ON c.id = p2.conversation_id AND p2.user_id != p1.user_id
                -- 3. On récupère les infos de cette autre personne dans la table users
                INNER JOIN users u ON p2.user_id = u.id
                -- 4. On récupère le tout dernier message (via une sous-requête sur ta table 'message')
                LEFT JOIN message m ON m.id = (
                    SELECT id FROM message
                    WHERE conversation_id = c.id 
                    ORDER BY created_at DESC 
                    LIMIT 1
                )
                ORDER BY COALESCE(m.created_at, c.created_at) DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $conversations = [];

        foreach ($rows as $row) {
            // 1. On crée l'objet Conversation
            $conversation = new Conversation();
            $conversation->setId((int)$row['conversation_id']);

            // 2. On crée et on injecte l'objet User (le contact)
            $contact = new User();
            $contact->setId((int)$row['contact_id']);
            $contact->setUsername($row['contact_username']);
            $contact->setProfilImage($row['contact_image']);
            $conversation->setContact($contact);

            // 3. On crée et on injecte l'objet Message (si existant)
            if ($row['last_message']) {
                $lastMsg = new Message();
                $lastMsg->setContent($row['last_message']);
                $lastMsg->setCreatedAt($row['last_message_date']);
                $conversation->setLastMessage($lastMsg);
            }

            $conversations[] = $conversation;
        }

        return $conversations;
    }

    /**
     * Récupère uniquement les IDs des conversations avec messages non-lus et le nombre de messages pour chacune.
     */
    public function findUnreadConversations(int $userId): array
    {
        $sql = "SELECT m.conversation_id, COUNT(*) as count
                FROM message m
                INNER JOIN participants p ON m.conversation_id = p.conversation_id
                WHERE p.user_id = :userId         -- Je suis dans la conv
                AND m.user_id != :userId        -- C'est pas moi qui ai écrit
                AND m.readed = FALSE           -- C'est pas encore lu
                GROUP BY conversation_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
        // Retourne par ex: [1 => 12, 4 => 2, ...]
    }
}