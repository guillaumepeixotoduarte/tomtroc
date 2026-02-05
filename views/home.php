<section class="main-bg-color">
    <div class="container-fluid px-0 mx-auto px-md-2 pt-0 pt-sm-5 pb-5 d-flex align-items-center " style="max-width: 1000px;">
        <div class="row w-100 m-0 flex-wrap-reverse"> 
            <div class="section-text-content col-12 col-lg-6 px-4 px-sm-0 my-5 my-lg-auto">
                <h1>Rejoignez nos lecteurs passionnés</h1>
                <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>
                <button class="classic-button green-button mt-3 w-100 w-sm-auto">Découvrir</button>
            </div>

            <div class="col-12 col-lg-6 d-flex flex-column align-items-center align-items-lg-end p-0">
                <div class="image-wrapper">
                    <img src="img/home_image.png" alt="Echange de livres" class="img-fluid"> 
                    <p class="grey-text font-size-12 fst-italic text-end w-100 my-2 mx-0 pe-2 pe-sm-0">Hamza</p>
                </div>
            </div>
            
        </div>  
    </div>
</section>

<section class="second-bg-color text-center ">
    <div class="max-width-1000 w-80 mx-auto px-4 px-lg-0 py-5">
        <h2 class="my-5"> Les derniers livres ajoutés </h2>
        <div id="latest-books" class="py-5 row row-cols-2 row-cols-md-4 g-4">
            <?php if(!empty($latestBooks)): ?>
                <?php foreach($latestBooks as $book): ?>

                    <div class="col">
                        <div class="card border-0 rounded-bottom">
                            <img src="<?= getBookImageUrl($book->getImage()) ?>" alt="<?= $book->getTitle() ?>" class="w-100">
                            <div class="card-body text-start">
                                <p class="font-size-14 mb-2"><?= $book->getTitle() ?></p>
                                <p class="card-text grey-text font-size-12"><?= $book->getAuthor() ?></p>
                                <p class="grey-text fst-italic font-size-12">Vendu par : <?= $book->getOwner()->getUsername() ?></p>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun livre disponible pour le moment.</p>
            <?php endif; ?>
            <!-- Les livres seront chargés ici dynamiquement -->
        </div>
        <button class="classic-button green-button mt-3 w-100 w-sm-auto">Voir tous les livres</button>
    </div>
</section>

<section class="main-bg-color">
    <div class="text-center py-5 px-4 px-lg-0 max-width-1000 w-80 mx-auto">
        <h2 class="py-4">Comment ça marche ?</h2>
        <p>Échanger des livres avec TomTroc c’est simple et <br> amusant ! Suivez ces étapes pour commencer :</p>
        <div class="d-flex justify-content-lg-around justify-content-between flex-column flex-sm-row flex-nowrap flex-sm-wrap flex-lg-nowrap mt-4">
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Inscrivez-vous <br> gratuitement sur <br> notre plateforme.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Ajoutez les livres que vous <br> souhaitez échanger à <br> votre profil.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Parcourez les livres <br> disponibles chez d'autres <br> membres.</p></div>
            <div class="bg-white d-flex rounded-3 home-help-blocs my-2"><p class="m-auto">Proposez un échange et <br> discutez avec d'autres <br> passionnés de lecture.</p></div>
        </div>
        <button class="classic-button secondary-green-button bg-white mt-3 w-100 w-sm-auto">Voir tous les livres</button>
    </div>
    <img class="d-none d-sm-block w-100 object-fit-cover" src="img/second_home_image.png" alt="Echange de livres">
    <img class="w-100 d-sm-none" src="img/second_home_phone_image.png" alt="Echange de livres">
    <div id="nos-valeurs" class="py-5 px-4 px-lg-0 mx-auto">
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
        <p class="grey-text font-size-12 fst-italic">L'équipe Tom Troc</p>
        <img src="img/heart.png" alt="Heart Icon">
        
    </div>
</section>