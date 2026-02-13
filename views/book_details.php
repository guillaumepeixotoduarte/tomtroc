
<div class="container-fluid m-0 h-100 second-bg-color">
    <div class="row">
        <div class="col-12 main-bg-color p-3 d-none d-md-block">
            <p class="max-width-1140 mb-0 mx-auto font-size-10 grey-text">Nos livres > <?= $book->getTitle() ?></p>
        </div>
        <div class="col-12 col-md-6 px-0 position-relative">
            <img src="<?= getBookImageUrl($book->getImage()) ?>" class="img-fluid w-100" alt="<?= $book->getTitle() ?>">
            <?php if(!$book->getStatutExchange()): ?>
                <span class="indisponible-badge indisp-badge-card">non dispo.</span>
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-6 px-3 px-lg-0">
            <div class="w-100">
                <div class="mx-0 mt-5 mx-lg-5 p-0 p-lg-3 pe-lg-5 mb-5">
                    <h2 class="mb-3"><?= $book->getTitle() ?></h2>
                    <p class="font-size-16 grey-text">par <?= $book->getAuthor() ?></p>
                    <hr class="short-line my-4">
                    <p class="text-uppercase font-size-8 fw-semibold mb-2">Description</p>
                    <p class="font-size-14 mb-4"><?= $book->getDescription() ?></p>
                    <p class="text-uppercase  font-size-8 fw-semibold mb-2">propriétaire</p>
                    <a href="<?= url('profile/'.$book->getUserId() ) ?>" class="profile-badge mb-5 text-decoration-none text-black">
                        <img src="<?= !empty($book->getOwner()->getProfilImage()) ? getProfileImageUrl($book->getOwner()->getProfilImage()) : url('img/default-profil-image.png') ?>" alt="Image de profil de <?= $book->getOwner()->getUsername() ?>" class="rounded-circle profile-img-small">
                        <span class="profile-username"><?= $book->getOwner()->getUsername() ?></span>
                    </a>

                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] !== $book->getUserId()): ?>
                        <a href="<?= url('messagerie/contact/' . $book->getUserId()) ?>" class="classic-button green-button text-decoration-none w-100 d-block my-5 text-center">
                            Envoyer un message
                        </a>
                    <?php elseif(!isset($_SESSION['user'])): ?>
                        <button type="button" class="classic-button green-button text-decoration-none w-100 my-5" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Envoyer un message
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalFullscreenXxlLabel">Envie de lire ce livre ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Vous devez être connecté pour envoyer un message à <strong><?= htmlspecialchars($book->getOwner()->getUsername()) ?></strong></p>
                    <div class="d-grid gap-2">
                        <a href="<?= url('login') ?>" class="classic-button green-button text-center text-decoration-none">Se connecter</a>
                        <a href="<?= url('register') ?>" class="classic-button secondary-green-button text-center text-decoration-none">Créer un compte</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>