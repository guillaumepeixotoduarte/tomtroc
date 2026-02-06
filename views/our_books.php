<section class="container-fluid p-4 m-0 h-100 second-bg-color">
    <div class="max-width-1000 mx-auto pb-5">
        <div class="d-flex mt-5 justify-content-between w-100 flex-sm-row flex-column align-items-sm-center align-items-start">
            <h2>Nos livres à l'échange</h2>
            <div class="search-container d-flex align-items-center my-3 px-2 py-1 border rounded-2 bg-white  col-12 col-sm-auto">
                <i class="bi bi-search pe-2 grey-text"></i>
                <input type="text" class="border-0 shadow-none ps-0" placeholder="Rechercher un livre" id="searchInput">
            </div>
        </div>
        <div class="py-3 row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if(!empty($books)): ?>
                <?php foreach($books as $book): ?>

                    <a href="<?= url('book/detail/' . $book->getId()) ?>" class="col text-decoration-none">
                        <div class="card border-0 rounded-bottom">
                            <img src="<?= getBookImageUrl($book->getImage()) ?>" alt="<?= $book->getTitle() ?>" class="w-100">
                            <div class="card-body text-start">
                                <p class="font-size-16 mb-2 w-100 text-truncate"><?= $book->getTitle() ?></p>
                                <p class="card-text grey-text font-size-14"><?= $book->getAuthor() ?></p>
                                <p class="grey-text fst-italic font-size-12 mb-1">Vendu par : <?= $book->getOwner()->getUsername() ?></p>
                            </div>
                        </div>
                    </a>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun livre disponible pour le moment.</p>
            <?php endif; ?>
            <!-- Les livres seront chargés ici dynamiquement -->
        </div>
    </div>
</section>