<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?? 'Mon Site' ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <header class="main-header">
            <nav class="navbar navbar-expand-lg navbar-light main-bg-color">
                <div class="container-fluid">
                    <a class="navbar-brand ms-5 ps-5" href="<?= url('') ?>">
                        <img src="img/logo.png" id="logo-nav" alt="Logo" class="">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item mx-3">
                                <a class="nav-link <?= navBarIsActive('home') ?>" href="<?= url('home') ?>">Accueil</a>
                            </li>
                            <li class="nav-item mx-3">
                                <a class="nav-link <?= navBarIsActive('nos-livres') ?>" href="<?= url('nos-livres') ?>">Nos livres à l'échange</a>
                            </li>

                        </ul>

                        <?php if(!empty($_SESSION['user'])): ?>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= url('messages') ?>">Messagerie</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= url('profil') ?>">Mon Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= url('logout') ?>">Déconnexion</a>
                                </li>
                            </ul>
                        <?php else: ?>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= url('inscription') ?>">Inscription</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= url('login') ?>">Connexion</a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>


        </header>

        <main>
