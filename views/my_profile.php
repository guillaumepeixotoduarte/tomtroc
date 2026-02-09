<div class="container-fluid p-md-5 p-4 m-0 h-100 second-bg-color">
    <div class="max-width-1000 mx-auto">
        <h2 class="py-4 px-0">Mon compte</h2>
        <div class="row">
            <div class="col-12 col-lg-6 pe-lg-3">
                <div class="d-flex justify-content-center align-items-center flex-column p-3 bg-white rounded-4 h-100">
                    <div class="d-flex flex-column align-items-center justify-content-center my-4">
                        <img src="<?= !empty($user->getProfilImage()) ? getProfileImageUrl($user->getProfilImage()) : 'img/default-profil-image.png' ?>" alt="Icône utilisateur" class="mb-1 profil-image rounded-circle" >
                        <form id="profileImageForm" action="<?= url('update-profile-image') ?>" method="POST" enctype="multipart/form-data">
                            <label for="profileImageInput" class="grey-text text-decoration-underline cursor-pointer font-size-12">
                                Modifier l'image
                            </label>
                            <input type="file" id="profileImageInput" name="profileImageInput" class="d-none" accept="image/*" >
                        </form>
                    </div>
                    <hr class="w-50 grey-text">
                    <div class="text-center  my-4">
                        <h5><?= $user->getUsername() ?></h5>
                        <p class="grey-text font-size-12"> Membre depuis <?= $user->getAccoundAge() ?> </p>
                        <p class="font-size-8 fw-semibold mb-1">BIBLIOTHEQUE</p>
                        <p class="mt-0 font-size-14"><i class="bi bi-book"></i> <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-6 ps-lg-3">
                <div class="p-sm-5 p-4 bg-white rounded-4 mt-4 mt-lg-0 h-100">
                    <form class="px-md-5 px-sm-2 px-0" method="post" action="<?= url('my-profile-update') ?>">
                        <h5 class="mb-4">Vos informations personnelles</h5>

                        <?php if(isset($_SESSION['success'])): ?>
                            <div class="alert alert-success mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger mb-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <div class="mb-4 grey-text">
                            <label for="email" class="form-label font-size-14 mb-1">Adresse mail</label>
                            <input type="email" class="form-control light-blue-bg-color" id="email" name="email" value="<?= $user->getEmail() ?>">
                        </div>
                        <div class="mb-4 grey-text">
                            <label for="password" class="form-label font-size-14 mb-1">Mot de passe</label>
                            <input type="password" class="form-control light-blue-bg-color" id="password" name="password">
                        </div>
                        <div class="mb-4 grey-text">
                            <label for="pseudo" class="form-label font-size-14 mb-1">Pseudo</label>
                            <input type="text" class="form-control light-blue-bg-color" id="pseudo" name="pseudo" value="<?= $user->getUsername() ?>">
                        </div>
                        <input type="submit" class="classic-button second-bg-color secondary-green-button col-12 col-sm-auto mb-4" value="Enregistrer">
                    </form>    
                </div>            
            </div>
        </div>

        <div class="col-12 d-flex justify-content-between align-items-center mt-5 mt-lg-2 mb-2">
            <h5 class="my-auto">Ma bibliothèque</h5>
            <a href="<?= url('book/edit') ?>" class="my-auto text-black">Ajouter un livre</a>
        </div>
        <?php if (!empty($books)): ?>
            <div class="bg-white rounded-4 d-none d-md-block">
                <div class="profil-book-list col-12 pt-4 mb-1 row flex-row font-size-8 fw-semibold">
                    <div class="col-2">PHOTO</div>
                    <div class="col-2">TITRE</div>
                    <div class="col-2">AUTEUR</div>
                    <div class="col-2">DESCRIPTION</div>
                    <div class="col-2">DISPONIBILITE</div>
                    <div class="col-2">ACTION</div>
                </div>
                <hr class="col-12 my-1">
                <div class="table-books-list-bg">
                    <?php foreach($books as $book): ?>
                        <div class="profil-book-list col-12 py-4 row mx-0 flex-row">
                            <div class="col-2 ps-0 d-flex align-items-center"><img src="<?= getBookImageUrl($book->getImage()) ?>" class="img-fluid table-image-column" alt="Image du livre : <?= $book->getTitle() ?>"></div>
                            <div class="col-2 ps-0 d-flex align-items-center"><?= htmlspecialchars($book->getTitle()) ?></div>
                            <div class="col-2 ps-0 d-flex align-items-center"><?= htmlspecialchars($book->getAuthor()) ?></div>
                            <div class="col-2 ps-0 d-flex align-items-center"><?= htmlspecialchars( truncate($book->getDescription())) ?></div>
                            <div class="col-2 ps-0 d-flex align-items-center"><span class="<?= $book->getStatutExchange() ? 'disponible-badge' : 'indisponible-badge' ?>"><?= $book->getStatutExchange() ? 'Disponible' : 'Indisponible' ?></span></div>
                            <div class="col-2 ps-0 d-flex justify-content-between align-items-center flex-wrap">
                                <a href="<?= url('book/edit/'.$book->getId()) ?>" class="text-black text-decoration-underline">Éditer</a>
                                <a href="<?= url('book/delete/' . $book->getId()) ?>" class="text-danger text-decoration-underline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">Supprimer </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-block d-md-none">
                <?php foreach($books as $book): ?>
                    <div class="col-12 p-3 bg-white rounded-4 mb-3">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-center align-items-center">
                                <img src="<?= getBookImageUrl($book->getImage()) ?>" class="img-fluid table-image-column w-100" alt="Image du livre : <?= $book->getTitle() ?>">
                            </div>
                            <div class="col-8 d-flex flex-column">
                                    <p class="font-size-14 mb-1"><?= htmlspecialchars($book->getTitle()) ?></p>
                                    <p class="font-size-14 mb-2"><?= htmlspecialchars($book->getAuthor()) ?></p>
                                    <div><span class="<?= $book->getStatutExchange() ? 'disponible-badge' : 'indisponible-badge' ?>"><?= $book->getStatutExchange() ? 'Disponible' : 'Indisponible' ?></span></div>
                            </div>
                        </div>
                        <div class="col-12 mt-2 font-size-14 fst-italic"><?= htmlspecialchars( truncate($book->getDescription())) ?></div>
                       
                        <div class="col-12 my-4 d-flex justify-content-around align-items-center flex-row">
                            <a href="<?= url('book/edit/'.$book->getId()) ?>" class="text-black text-decoration-underline">Éditer</a>
                            <a href="<?= url('book/delete/' . $book->getId()) ?>" class="text-danger text-decoration-underline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">Supprimer </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="p-4">Vous n'avez pas encore ajouté de livres à votre bibliothèque. <a href="<?= url('book/edit') ?>">Ajoutez-en un maintenant !</a></p>
        <?php endif; ?>
        </div>
    </div>
</div>
