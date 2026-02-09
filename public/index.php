<?php

session_start();

define('ROOT', dirname(__DIR__));
define('BASE_URL', '/book/public');

require_once '../app/Core/Helpers.php';

$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$params = explode('/', $url);

checkAccessNotLogged($params[0], $params[1] ?? 'index');

switch ($params[0]) {
    case 'home':
        require_once '../app/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'nos-livres':
        require_once '../app/Controllers/BookController.php';
        $controller = new BookController();
        $controller->ourBooks();
        break;

    case 'my-profile':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->myProfilePage();
        break;

    case 'my-profile-update':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->updateProfile();
        break;
    
    case 'update-profile-image':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->updateProfileImage();
        break;

    case 'profile':
        require_once '../app/Controllers/UserController.php';
        $id = (isset($params[1]) && is_numeric($params[1])) ? $params[1] : null; 
        $controller = new UserController();
        $controller->profilePage($id);
        break;

    case 'login':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->login_page();
        break;

    case 'login-user':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->auth();
        break;

    case 'logout':
        session_destroy();
        redirect('home');
        break;

    case 'register':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->register();
        break;

    case 'inscription-save':
        require_once '../app/Controllers/UserController.php';
        $controller = new UserController();
        $controller->saveUser();
        break;

    case 'book':

        require_once ROOT . '/app/Controllers/BookController.php';
        $controller = new BookController();
        $action = $params[1] ?? 'edit'; // Action par défaut si vide

        if ($action === 'edit') {
            // On récupère l'ID s'il existe dans le 3ème segment ($params[2])
            $id = (isset($params[2]) && is_numeric($params[2])) ? $params[2] : null; 
            $controller->edit($id);
        } 
        elseif ($action === 'save-book'){
            $controller->saveBook();
            break;
        }
        elseif ($action === 'detail') {
            $id = (isset($params[2]) && is_numeric($params[2])) ? $params[2] : null; 
            if(!$id) {
                redirect('nos-livres');
            }
            $controller->show($id);
        }
        elseif ($action === 'delete') {
            $id = $params[2] ?? null;
            $controller->deleteBook($id);
        }
        break;

    default:
        // Si la page n'existe pas
        http_response_code(404);
        echo "Erreur 404 : Page non trouvée";
        break;
}