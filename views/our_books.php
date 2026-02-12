<section class="container-fluid flex-grow-1 p-3 m-0 h-100 second-bg-color">
    <div class="max-width-1140 mx-auto pb-5 col-12 col-md-10 col-xl-8">
        <div class="d-flex mt-5 justify-content-between w-100 flex-sm-row flex-column align-items-sm-center align-items-start mb-lg-5 mb-2">
            <h2>Nos livres à l'échange</h2>
            <form method="GET" action="<?= url('nos-livres') ?>" class="search-container d-flex align-items-center my-3 px-2 py-1 border rounded-2 bg-white  col-12 col-sm-auto">
                <i class="bi bi-search pe-2 grey-text"></i>
                <input type="text" name="search" class="border-0 shadow-none ps-0 grey-placeholder" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un livre" id="searchInput">
            </form>
        </div>
        <?php if(!empty($books)): ?>
            <div class="py-3 row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach($books as $book): ?>

                    <a href="<?= url('book/detail/' . $book->getId()) ?>" class="col text-decoration-none">
                        <div class="card border-0 rounded-bottom h-100">
                            <img src="<?= getBookImageUrl($book->getImage()) ?>" alt="<?= $book->getTitle() ?>" class="w-100">
                            <?php if(!$book->getStatutExchange()): ?>
                                <span class="indisponible-badge indisp-badge-card">non dispo.</span>
                            <?php endif; ?>
                            <div class="card-body text-start">
                                <p class="font-size-16 mb-2 w-100 text-truncate"><?= $book->getTitle() ?></p>
                                <p class="card-text grey-text font-size-14"><?= $book->getAuthor() ?></p>
                                <p class="grey-text fst-italic font-size-12 mb-1">Vendu par : <?= $book->getOwner()->getUsername() ?></p>
                            </div>
                        </div>
                    </a>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</section>