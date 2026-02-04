<div class="container-fluid p-5 m-0 h-100 second-bg-color">
    <div class="max-width-1000 mx-auto">
        <h2 class="py-4 px-0">Mon compte</h2>
        <div class="row">
            <div class="col-12 col-lg-6 pe-3">
                <div class="d-flex justify-content-center align-items-center flex-column p-3 bg-white rounded-4 h-100">
                    <div class="d-flex flex-column align-items-center justify-content-center my-4">
                        <img src="<?= !empty($user->getProfilImage()) ? $user->getProfilImage() : 'img/default-profil-image.png' ?>" alt="Icône utilisateur" class="mb-1" style="width: 100px;">
                        <a class="grey-text" href="#">Modifier l'image</a>
                    </div>
                    <hr class="w-50 grey-text">
                    <div class="text-center  my-4">
                        <h5><?= $user->getUsername() ?></h5>
                        <p class="grey-text"> Membre depuis <?= $user->getAccoundAge() ?> </p>
                        <p class="font-size-8 fw-semibold mb-1">BIBLIOTHEQUE</p>
                        <p class="mt-0 font-size-14"><i class="bi bi-book"></i> <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-6 ps-3">
                <div class="p-sm-5 p-4 bg-white rounded-4 mt-4 mt-lg-0 h-100">
                    <form class="px-md-5 px-sm-2 px-0" method="post" action="<?= url('/profile/update') ?>">
                        <h5 class="mb-4">Vos informations personnelles</h5>
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
        <div class="mt-3 bg-white rounded-4">
            <?php if (!empty($books)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">PHOTO</th>
                            <th scope="col">TITRE</th>
                            <th scope="col">AUTEUR</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">DISPONIBILITE</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php foreach($books as $book): ?>
                            <tr>
                                <td><img src="<?= !empty($book->getCoverImage()) ? $book->getCoverImage() : 'img/default-book-cover.png' ?>" alt="Cover Image" style="width: 50px;"></td>
                                <td><?= htmlspecialchars($book->getTitle()) ?></td>
                                <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                                <td><?= htmlspecialchars($book->getDescription()) ?></td>
                                <td><span class="<?= $book->isAvailable() ? 'bg-teal-400' : 'bg-red-400' ?> text-white px-2 py-1 rounded"><?= $book->isAvailable() ? 'Disponible' : 'Indisponible' ?></span></td>
                                <td>
                                    <form method="get" action="<?= url('/profile/edit-book') ?>">
                                        <input type="hidden" name="book_id" value="<?= $book->getId() ?>">
                                        <input type="submit" class="btn btn-primary btn-sm me-2" value="Éditer">
                                    </form>
                                    <form method="post" action="<?= url('/profile/delete-book') ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                        <input type="hidden" name="book_id" value="<?= $book->getId() ?>">
                                        <input type="submit" class="btn btn-danger btn-sm" value="Supprimer">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="p-4">Vous n'avez pas encore ajouté de livres à votre bibliothèque. <a href="<?= url('/add-book') ?>">Ajoutez-en un maintenant !</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
