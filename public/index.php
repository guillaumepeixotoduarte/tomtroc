<?php

session_start();

define('ROOT', dirname(__DIR__));
define('BASE_URL', '/book/public');

require_once '../app/Core/Helpers.php';

require_once '../app/Controllers/HomeController.php';
require_once '../app/Controllers/BookController.php';

$url = $_GET['url'] ?? 'home';

$protected_routes = ['profile', 'add-book', 'login/user', 'logout', 'dashboard'];

if (in_array($url, $protected_routes) && !isLogged()) {
    $_SESSION['error'] = "Accès refusé. Veuillez vous connecter.";
    header('Location: ' . url('/login'));
    exit;
}

switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'profile':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->profile();
        break;

    case 'login':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->login();
        break;

    case 'login/user':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->auth();
        break;

    case 'logout':
        session_destroy();
        redirect('home');
        break;

    case 'inscription':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->register();
        break;

    case 'inscription/save':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->save();
        break;
    
    case 'nos-livres':
        echo "Page nos livres (à créer)";
        break;

    case 'contact':
        echo "Page contact (à créer)";
        break;

    default:
        // Si la page n'existe pas
        http_response_code(404);
        echo "Erreur 404 : Page non trouvée";
        break;
}