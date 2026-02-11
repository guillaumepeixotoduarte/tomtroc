<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tom Troc - <?= $title ?? 'Accueil' ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= url('css/style.css') ?>">
    </head>
    <body>

        <header class="main-header">
            <nav class="navbar navbar-expand-lg navbar-light main-bg-color">
                <div class="container-fluid">
                    <a class="navbar-brand ms-2 ms-lg-3 me-5 ms-xl-5 ps-1 ps-lg-3 ps-xl-5" href="<?= url('') ?>">
                        <img src="<?= url('img/logo.png') ?>" id="logo-nav" alt="Logo" class="">
                    </a>

                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto font-size-14">
                            <li class="nav-item mx-3 d-flex align-items-center">
                                <a class="nav-link <?= navBarIsActive('home') ?>" href="<?= url('home') ?>">Accueil</a>
                            </li>
                            <li class="nav-item mx-3 d-flex align-items-center">
                                <a class="nav-link <?= navBarIsActive('nos-livres') ?>" href="<?= url('nos-livres') ?>">Nos livres à l'échange</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav font-size-14 me-0 me-xl-5 pe-1 pe-lg-3 pe-xl-5">
                            <?php if(!empty($_SESSION['user'])): ?>
                                <?php 
                                    require_once ROOT . '/app/Models/Managers/ConversationManager.php';
                                    $conversationManager = new App\Managers\ConversationManager(); 
                                    $unreadCount = $conversationManager->findUnreadConversations((int)$_SESSION['user']['id']);
                                
                                ?>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <span class="nav-link nav-separator p-0"></span>
                                </li>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <a class="nav-link <?= navBarIsActive('messagerie') ?>" href="<?= url('messagerie') ?>">
                                        <i class="bi bi-chat mirror-horizontal"></i> Messagerie
                                        <?php if(!empty($unreadCount) && count($unreadCount) > 0): ?>
                                            <span class="messagerie-badge font-size-8"> <?= count($unreadCount) ?> </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <a class="nav-link <?= navBarIsActive('my-profile') ?>" href="<?= url('my-profile') ?>"><i class="bi bi-person-circle"></i> Mon compte</a>
                                </li>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <a class="nav-link" href="<?= url('logout') ?>">Déconnexion</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <a class="nav-link <?= navBarIsActive('register') ?>" href="<?= url('register') ?>">Inscription</a>
                                </li>
                                <li class="nav-item mx-3 d-flex align-items-center">
                                    <a class="nav-link <?= navBarIsActive('login') ?>" href="<?= url('login') ?>">Connexion</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>


        </header>

        <main>
