<div class="container-fluid m-0 h-100 second-bg-color">
    <div class="row">
        <div class="col-12 col-lg-6 px-3 px-lg-0">
            <div class="row">
                <div class="col-12 col-sm-10 col-md-8 col-lg-8 col-xl-7 mb-4 mb-lg-0 mx-auto">
                    <form class="mt-5 pt-lg-5" action="<?= url('inscription-save') ?>" method="post">
                        <h2 class="my-5">Inscription</h2>
                        
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger mb-4"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <div class="mb-4 grey-text">
                            <label for="pseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" name="pseudo">
                        </div>
                        
                        <div class="mb-4 grey-text">
                            <label for="email" class="form-label">Adresse mail</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="mb-4 grey-text">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <input type="submit" class="classic-button green-button w-100 mb-4" value="S'inscrire">

                        <p class="font-size-14 text-black mb-5">
                            Déjà inscrit ? <a class="text-black" href="<?= url('login') ?>">Connectez-vous</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 px-0">
            <img src="img/bibliotheque.png" class="img-fluid w-100" alt="Image d'une Bibliothèque">
        </div>
    </div>
</div>