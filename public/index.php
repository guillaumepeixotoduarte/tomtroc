<?php

define('ROOT', dirname(__DIR__));
define('BASE_URL', '/book/public');

require_once '../app/Core/Helpers.php';

require_once '../app/Controllers/HomeController.php';
require_once '../app/Controllers/BookController.php';

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
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