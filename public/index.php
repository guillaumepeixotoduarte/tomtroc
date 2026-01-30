<?php

define('ROOT', dirname(__DIR__));

require_once '../app/Controllers/HomeController.php';

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
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