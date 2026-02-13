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

    /** Affichage de la messagerie ( ici uniquement les discussions en cours )
     * @return void 
     */
    public function index(){
        $senderId = $_SESSION['user']['id'];
        $conversationManager = new ConversationManager();

        return $this->render('message_page', [
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    /** Affichage de la messagerie pour un premier message, si une conversation existe avec le correspondant alors on est rediriger vers elle
     * @param int $recipientId L'ID de l'utilisateur que l'on souhaite contacter
     * @return void 
     */
    public function contactOwner(int $recipientId) {

        $senderId = $_SESSION['user']['id'];
        $userManager = new UserManager();
        $conversationManager = new ConversationManager();
        $participantManager = new ParticipantManager();

        $recipientUser = $userManager->findById($recipientId);

        // On vérifie si on a déja une conversation en cours avec l'utilisateur que l'on souhaite contacté
        $existingId = $participantManager->findConversationBetween($senderId, $recipientId);

        if ($existingId) {
            // Si oui, on va directement sur la conversation
            redirect('messagerie/conversation/' . $existingId);
        }

        // Si non, on affiche l'interface "Premier Message"
        // On peut passer l'ID du destinataire à la vue pour le formulaire
        return $this->render('message_page', [
            'recipientUser' => $recipientUser,
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    /** Affichage de la conversation avec un autre utilisateur
     * @param int $conversationId L'ID de la conversation que l'on souhaite afficher
     * @return void 
     */
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

        // Cette fonction va passer les messages non-lu en lu
        $messageManager->markAsRead($conversationId, $_SESSION['user']['id']);

        return $this->render('message_page', [
            'recipientUser' => $recipientUser,
            'activeId' => $conversationId,
            'messages' => $messages,
            'conversations' => $conversationManager->findAllConversationsByUser($senderId),
            'unreadConversation' => $conversationManager->findUnreadConversations((int)$_SESSION['user']['id'])
        ]);
    }

    /** Fonction qui s'occupe d'enregister le message
     * @param int $conversationId L'ID de la conversation que l'on souhaite afficher
     * @return void 
     */
    public function handlePostMessage() 
    {
        $content = trim($_POST['messageContent']);
        $receiverId = (int)$_POST['recipientId']; // L'ID de l'autre personne
        $senderId = $_SESSION['user']['id'];  // Ton ID

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
                $redirectPath = "messagerie/conversation/$conversationId";
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