<?php


require_once ROOT . '/app/Core/Controller.php';
require_once ROOT . '/app/Models/Managers/MessageManager.php';
require_once ROOT . '/app/Models/Managers/UserManager.php';
require_once ROOT . '/app/Models/Managers/ParticipantManager.php';
require_once ROOT . '/app/Models/Managers/ConversationManager.php';

use App\Core\Controller;
use App\Managers\ConversationManager;
use App\Managers\MessageManager;
use App\Managers\UserManager;
use App\Managers\ParticipantManager;


class MessagerieController extends Controller {

    public function index(){
        $senderId = $_SESSION['user']['id'];
        $messageManager = new MessageManager();
        $conversationManager = new ConversationManager();

        return $this->render('message_page', [
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    public function contactOwner(int $recipientId) {

        $senderId = $_SESSION['user']['id'];
        $userManager = new UserManager();
        $conversationManager = new ConversationManager();

        $recipientUser = $userManager->findById($recipientId);

        // 1. Est-ce qu'on a déjà discuté ensemble ?
        $existingId = $conversationManager->getConversationIdBetweenTwoUsers($senderId, $recipientId);

        if ($existingId) {
            // Si oui, on va directement sur la conversation
            redirect('messagerie/conversation/' . $existingId);
        }

        // 2. Si non, on affiche l'interface "Premier Message"
        // On peut passer l'ID du destinataire à la vue pour le formulaire
        return $this->render('message_page', [
            'recipientUser' => $recipientUser,
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    public function conversationWithOtherUser(int $conversationId){
        $senderId = $_SESSION['user']['id'];
        $userManager = new UserManager();
        $participantManager = new ParticipantManager();
        $conversationManager = new ConversationManager();
        $messageManager = new MessageManager();

        // cette fonction permet de récupérer l'autre utilisateur avec qui on a la conversation, si on est bien le 2e participant
        $recipientId = $participantManager->getRecipientId($conversationId, $_SESSION['user']['id']);

        if(!$recipientId){
            redirect('messagerie');
        }

        $recipientUser = $userManager->findById($recipientId);
        $messages = $messageManager->findAllMessagesByConversation($conversationId);

        $messageManager->markAsRead($conversationId, $_SESSION['user']['id']);

        return $this->render('message_page', [
            'recipientUser' => $recipientUser,
            'activeId' => $conversationId,
            'messages' => $messages,
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    public function handlePostMessage() 
    {
        $content = trim($_POST['messageContent']);
        $receiverId = (int)$_POST['recipientId']; // L'ID de l'autre personne
        $senderId = $_SESSION['user']['id'];       // Ton ID

        if(empty($receiverId)){
            redirect('messagerie');
        }

        $messageManager = new MessageManager();
        $participantManager = new ParticipantManager();
        $conversationId = $participantManager->findConversationBetween($senderId, $receiverId);

        $redirectPath = $conversationId ? "messagerie/conversation/$conversationId" : "messagerie/contact/$receiverId";

        if (empty($content)) {
            $_SESSION['error'] = "Vous ne pouvez pas envoyé de message sans contenu.";
            redirect($redirectPath);
        }

        try {
            if ($conversationId) {
                $messageManager->addMessage($conversationId, $senderId, $content);
            } else {
                // Ici, le manager renvoie l'ID ou explose en cas d'erreur
                $conversationId = $messageManager->createFullConversation($senderId, $receiverId, $content);
            }

            // Succès : Redirection unique
            redirect($redirectPath);

        } catch (\Exception $e) {
            $_SESSION['error'] = "Désolé, l'envoi du message a échoué.";
            if($conversationId)
            {
                redirect($redirectPath);
            }
            redirect($redirectPath);
            
        }
    }
    
}