<?php

namespace App\Core;

abstract class Controller {


    protected function uploadImage(array $file, string $folder, string $prefix = ''): ?string {

        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $_SESSION['error'] = "Le fichier est trop lourd (max 2Mo).";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $_SESSION['error'] = "Le fichier n'a été que partiellement transféré.";
                    break;
                default:
                    $_SESSION['error'] = "Erreur inconnue lors de l'upload.";
            }
            return null;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            return null;
        }

        // On utilise le préfixe s'il est fourni, sinon rien
        $newName = uniqid($prefix, true) . '.' . $extension;
        
        $destination = ROOT . '/public/uploads/' . $folder . '/' . $newName;

        if (!is_dir(ROOT . '/public/uploads/' . $folder)) {
            mkdir(ROOT . '/public/uploads/' . $folder, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newName;
        }
        
        return null;
    }

    protected function deleteImage(string $name, string $folder){
        $path = ROOT . '/public/uploads/'.$folder.'/' . $name;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Affiche une vue avec des données
     */
    protected function render(string $view, array $data = []) {
        
        // On transforme le tableau de données en variables
        extract($data);
        
        require_once ROOT . '/views/layouts/header.php';
        // On appelle la vue
        $viewFile = ROOT . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("La vue '$view' n'existe pas dans " . $viewFile);
        }

        require_once ROOT . '/views/layouts/footer.php';
    }
}