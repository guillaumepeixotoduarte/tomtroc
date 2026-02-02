<?php include_once ROOT. '/views/layouts/header.php'; ?>

<section class="main-bg-color">
    <div class="max-width-1000 px-2 py-5 w-80 mx-auto d-flex align-items-center">
        <div class="section-text-content">
            <h1>Rejoingez nos lecteurs passionnés</h1>
            <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>
            <button class="classic-button green-button mt-3">Découvrir</button>
        </div>
        <div class="section-image-content">
            <img id="home-image" src="img/home_image.png" alt="Echange de livres">
            <p class="italic-text text-right">Hamza</p>
        </div>
    </div>
</section>

<section class="second-bg-color text-center ">
    <div class="max-width-1000 w-80 mx-auto py-5">
        <h2> Les derniers livres ajoutés </h2>
        <div id="latest-books" class="">
            <!-- Les livres seront chargés ici dynamiquement -->
        </div>
        <button class="classic-button green-button mt-3">Voir tous les livres</button>
    </div>
</section>

<section class="main-bg-color">
    <div class="text-center py-5 px-2 px-lg-0 max-width-1000 w-80 mx-auto">
        <h2 class="py-4">Comment ça marche ?</h2>
        <p>Échanger des livres avec TomTroc c’est simple et <br> amusant ! Suivez ces étapes pour commencer :</p>
        <div class="d-flex justify-content-between  flex-column flex-sm-row flex-nowrap flex-sm-wrap flex-lg-nowrap mt-4">
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Inscrivez-vous <br> gratuitement sur <br> notre plateforme.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Ajoutez les livres que vous <br> souhaitez échanger à <br> votre profil.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Parcourez les livres <br> disponibles chez d'autres <br> membres.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Proposez un échange et <br> discutez avec d'autres <br> passionnés de lecture.</p></div>
        </div>
        <button class="classic-button secondary-green-button mt-3">Voir tous les livres</button>
    </div>
    <img class="d-none d-sm-block w-100 object-fit-cover" src="img/second_home_image.png" alt="Echange de livres">
    <img class="second-home-image w-100 d-sm-none" src="img/second_home_phone_image.png" alt="Echange de livres">
    <div id="nos-valeurs" class="py-5 px-2 px-lg-0 mx-auto">
        <h2 class="mb-4">Nos valeurs</h2>
        <p>
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. 
            Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. 
            Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
            <br><br>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. 
            <br><br>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
        <p class="italic-text">L'équipe Tom Troc</p>
        <img src="img/heart.png" alt="Heart Icon">
        
    </div>
</section>

<?php include_once ROOT. '/views/layouts/footer.php'; ?>