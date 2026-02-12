<div class="flex-column w-100">
    <div class="container-fluid flex-grow-1 p-3 pt-5 m-0 h-100 second-bg-color">
        <div class="max-width-1140 mx-auto">
            <div class="row">
                <div class="col-12 col-md-4 pe-lg-3">
                    <div class="d-flex justify-content-center align-items-center flex-column p-3 bg-white rounded-4 h-100">
                        <div class="d-flex flex-column align-items-center justify-content-center my-4">
                            <img src="<?= !empty($user->getProfilImage()) ? getProfileImageUrl($user->getProfilImage()) : url('img/default-profil-image.png') ?>" alt="Icône utilisateur" class="mb-1 profil-image rounded-circle" >
                        </div>
                        <hr class="w-50 grey-text">
                        <div class="text-center  my-4">
                            <h5><?= $user->getUsername() ?></h5>
                            <p class="grey-text font-size-12"> Membre depuis <?= $user->getAccoundAge() ?> </p>
                            <p class="font-size-8 fw-semibold mb-1">BIBLIOTHEQUE</p>
                            <p class="mt-0 font-size-14"><i class="bi bi-book"></i> <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>

                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] !== $user->getId()): ?>
                                <a href="<?= url('messagerie/contact/' . $user->getId()) ?>" class="classic-button secondary-green-button second-bg-color text-decoration-none w-100 d-block mt-5 text-center">
                                    Écrire un message
                                </a>
                            <?php elseif(!isset($_SESSION['user'])): ?>
                                <button type="button" class="classic-button secondary-green-button second-bg-color text-decoration-none w-100 mt-5" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    Écrire un message
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 ps-md-3 pt-4 pt-md-0">
                    <?php if (!empty($books)): ?>
                        <div class="bg-white rounded-4 d-none d-md-block">
                            <div class="profil-book-list col-12 pt-4 mb-1 row flex-row font-size-8 fw-semibold">
                                <div class="col-3">PHOTO</div>
                                <div class="col-3">TITRE</div>
                                <div class="col-3">AUTEUR</div>
                                <div class="col-3">DESCRIPTION</div>
                            </div>
                            <hr class="col-12 my-1">
                            <div class="table-books-list-bg">
                                <?php foreach($books as $book): ?>
                                    <div class="profil-book-list col-12 py-4 row mx-0 flex-row">
                                        <div class="col-3 ps-0 d-flex align-items-center"><img src="<?= getBookImageUrl($book->getImage()) ?>" class="img-fluid table-image-column" alt="Image du livre : <?= $book->getTitle() ?>"></div>
                                        <div class="col-3 ps-0 d-flex align-items-center"><?= htmlspecialchars($book->getTitle()) ?></div>
                                        <div class="col-3 ps-0 d-flex align-items-center"><?= htmlspecialchars($book->getAuthor()) ?></div>
                                        <div class="col-3 ps-0 d-flex align-items-center"><?= htmlspecialchars( truncate($book->getDescription())) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>  
                    <?php else: ?>
                        <p class="bg-white rounded-4 p-4">Ce profil ne possède aucun livre</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($books)): ?>
                <div class="d-block d-md-none">
                    <?php foreach($books as $book): ?>
                        <div class="col-12 p-4 bg-white rounded-4 mb-3">
                            <div class="row mx-0">
                                <div class="col-4 p-0 d-flex justify-content-center align-items-center">
                                    <img src="<?= getBookImageUrl($book->getImage()) ?>" class="img-fluid table-image-column w-100" alt="Image du livre : <?= $book->getTitle() ?>">
                                </div>
                                <div class="col-8 d-flex my-auto flex-column">
                                        <p class="font-size-14 mb-1"><?= htmlspecialchars($book->getTitle()) ?></p>
                                        <p class="font-size-14 mb-2"><?= htmlspecialchars($book->getAuthor()) ?></p>
                                </div>
                            </div>
                            <div class="col-12 mt-2 font-size-14 fst-italic"><?= htmlspecialchars( truncate($book->getDescription())) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            </div>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1">
            <div class="modal-dialog  mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-4" id="exampleModalFullscreenXxlLabel">Envie de lire ce livre ?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Vous devez être connecté pour envoyer un message à <strong><?= htmlspecialchars($user->getUsername()) ?></strong></p>
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
</div>