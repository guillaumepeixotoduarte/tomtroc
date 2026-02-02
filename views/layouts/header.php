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
            <nav class="navbar">
                <div class="logo">
                    <img src="img/logo.png" alt="Tom Book">
                </div>
                <button class="burger-menu" id="burger-btn">
                    <span></span><span></span><span></span>
                </button>
                <ul class="nav-links" id="nav-menu">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/livres">Nos livres à l'échange</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
        </header>

        <main>
