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

    public function login_page() {
        $this->render('login', [
            'title' => 'Se connecter'
        ]);
    }

    public function profile() {

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
                    'role' => $user->getRole()
                ];

                $_SESSION['success'] = "Ravi de vous revoir, " . $user->getUsername() . " !";
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

}