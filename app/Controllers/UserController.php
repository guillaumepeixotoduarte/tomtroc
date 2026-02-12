<?php

require_once ROOT . '/app/Models/Entities/User.php';
require_once ROOT . '/app/Models/Managers/UserManager.php';
require_once ROOT . '/app/Models/Managers/BookManager.php';
require_once ROOT . '/app/Core/Controller.php';

use App\Managers\BookManager;
use App\Managers\UserManager;
use App\Core\Controller;

class UserController extends Controller {
    
    public function register() {
        $this->render('inscription', [
            'title' => 'Créer un compte'
        ]);
    }

    public function loginPage() {
        $this->render('login', [
            'title' => 'Se connecter'
        ]);
    }

    public function myProfilePage() {

        $userManager = new UserManager();
        $bookManager = new BookManager();
        $user = $userManager->findById($_SESSION['user']['id']);
        $books = $bookManager->findAllByIdUser($user->getId());

        $this->render('my_profile', [
            'title' => 'Profil utilisateur',
            'user' => $user,
            'books' => $books
        ]);
    }

    /** Affiche le profil d'un utilisateur spécifique (accessible via /profile/{id})
     * @param int|null $id L'ID de l'utilisateur à afficher
     */
    public function profilePage(int $id): void {

        $userManager = new UserManager();
        $bookManager = new BookManager();
        $user = $userManager->findById($id);

        if(!$user) {
            redirect('home');
        }

        $books = $bookManager->findAllByIdUser($user->getId());

        $this->render('profile', [
            'title' => 'Profil de ' . $user->getUsername(),
            'user' => $user,
            'books' => $books
        ]);
    }

    public function auth() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $userManager = new UserManager();
            $user = $userManager->findByEmail($email);

            // On vérifie si l'utilisateur existe ET si le mot de passe est correct
            if ($user && password_verify($password, $user->getPassword())) {
                
                // STOCKAGE EN SESSION
                // On ne stocke pas le mot de passe en session par sécurité
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'profilImage' => $user->getProfilImage(),
                    'role' => $user->getRole()
                ];

                redirect(path: 'my-profile');
            } else {
                $_SESSION['error'] = "Identifiants invalides.";
                redirect('/login');
            }
        }
    }

    public function saveUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Récupération et nettoyage
            $username = trim(htmlspecialchars($_POST['pseudo']));
            $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // 2. Validation simple
            if (empty($username) || empty($email) || empty($password) || strlen($password) < 8) {
                $_SESSION['error'] = "Veuillez remplir les champs correctement (password: 8 caractères min).";
                redirect('register');
            }

            $userManager = new UserManager();
            $existingUser = $userManager->findByEmailOrUsername($email, $username);
        
            if ($existingUser) {
                if ($existingUser['email'] === $email) {
                    $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
                } else {
                    $_SESSION['error'] = "Ce pseudo est déjà pris.";
                }
                redirect('register');
            }

            // 3. Appel au Modèle
            $userManager = new UserManager();
            $success = $userManager->create($username, $email, $password);

            if ($success) {
                $_SESSION['success'] = "Compte créé avec succès !";
                redirect('/login');
            } else {
                $_SESSION['error'] = "Erreur lors de l'inscription.";
                redirect('register');
            }
        }
    }

    public function updateProfile(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('my-profile');
        }

        $userManager = new UserManager();
        $user = $userManager->findById($_SESSION['user']['id']);
        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            redirect('login');
        }

        $username = trim(htmlspecialchars($_POST['pseudo']));
        $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (empty($username) || empty($email) || empty($password) || strlen($password) < 8) {
            $_SESSION['error'] = "Veuillez remplir les champs correctement (Mot de passe : 8 caractères min).";
            redirect(path: 'my-profile');
        }
        
        $existingUser = $userManager->findByEmailOrUsername($email, $username, true);
        
        if ($existingUser) {
            $_SESSION['error'] = "Ce pseudo est déjà pris.";
            if ($existingUser['email'] === $email) {
                $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
            }
            redirect('my-profile');
        }

        $update = $userManager->updateProfile($user->getId(), $username, $email, $password);

        if (!$update) {
            $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
            redirect(path: 'my-profile');
        }

        $_SESSION['user']['username'] = $username; // Met à jour le nom d'utilisateur en session
        $_SESSION['user']['email'] = $email; // Met à jour l'email en session
        $_SESSION['success'] = "Profil mis à jour avec succès !";
        redirect(path: 'my-profile');

    }

    public function updateProfileImage(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('my-profile');
        }

        $userManager = new UserManager();
        $user = $userManager->findById($_SESSION['user']['id']);
        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            redirect('login');
        }

        $actualImage = $user->getProfilImage();

        if (!isset($_FILES['profileImageInput']) || $_FILES['profileImageInput']['error'] !== 0) {

            $_SESSION['error'] = "Une erreur est survenue lors de la récupération de l'image";
            redirect('my-profile');

        }

        $newName = $this->uploadImage($_FILES['profileImageInput'], 'profile_image', 'profil_');

        if (!$newName) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement de l'image";
            redirect('my-profile');
        }
            
        $success = $userManager->updateProfileImage($user->getId(), $newName);

        if (!$success) {
            $this->deleteImage($newName, 'profile_image');
            $_SESSION['error'] = "Une erreur est survenue lors l'enregistrement des informations.";
            redirect('my-profile');
        }

        // On nettoie l'ancien fichier si ce n'était pas l'image par défaut
        if ($actualImage !== NULL) {
            $this->deleteImage($actualImage, 'profile_image');
        }
        // Mettre à jour la session
        $_SESSION['user']['profilImage'] = $newName;
        
        redirect('my-profile');
    }

}