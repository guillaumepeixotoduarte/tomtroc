<div class="container-fluid p-5 pt-4 m-0 h-100 second-bg-color">
    <div class="max-width-1000 mx-auto">
        <a class="grey-text text-decoration-none" href="<?= url('profile') ?>"> <i class="bi bi-arrow-left"></i> retour </a>
        <h3 class="my-3"><?= $title ?></h3>
        <form class="p-4 bg-white rounded-4 mt-3 row" method="post" action="<?= url('book/save-book') ?>" enctype="multipart/form-data">
            <div class="col-12 col-lg-6 mb-3">
                <div id="preview-img">
                    <img id="preview-image" src="<?= !empty($book) ? getBookImageUrl($book->getImage()) : '../img/default-book-image.jpg' ?>" alt="Aperçu" class="img-fluid">
                </div>
                <label for="cover-image" class="d-block text-end text-black text-decoration-underline cursor-pointer mt-2"><?= !empty($book) ? 'Modifier' : 'Ajouter' ?> l'image</label>
                <input type="file" id="cover-image" name="cover_image" class="mb-3 d-none" accept="image/*" <?= empty($book) ? 'required' : '' ?>>
            </div>
            <div class="col-12 col-lg-6">
                <?php if (!empty($book)): ?>
                    <input type="hidden" name="id" value="<?= $book->getId() ?>">
                    <input type="hidden" name="current_cover" value="<?= $book->getImage() ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="title" class="form-label grey-text">Titre</label>
                    <input type="text" class="form-control light-blue-bg-color" id="title" name="title" value="<?= !empty($book) ? htmlspecialchars($book->getTitle()) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label grey-text">Auteur</label>
                    <input type="text" class="form-control light-blue-bg-color" id="author" name="author" value="<?= !empty($book) ? htmlspecialchars($book->getAuthor()) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label grey-text">Description</label>
                    <textarea class="form-control light-blue-bg-color" id="description" name="description" rows="4" required><?= !empty($book) ? htmlspecialchars($book->getDescription()) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="disponibilite" class="form-label grey-text">Disponibilité</label>
                    <select class="form-select font-size-14 light-blue-bg-color" id="disponibilite" name="availability" required>
                        <option value="1" <?= !empty($book) && $book->getStatutExchange() ? 'selected' : '' ?>>Disponible</option>
                        <option value="0" <?= !empty($book) && !$book->getStatutExchange() ? 'selected' : '' ?>>Indisponible</option>
                    </select>
                </div>
                
                <button type="submit" class="classic-button second-bg-color green-button w-100">Enregistrer le livre</button>
            
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('cover-image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');

        if (file) {
            const reader = new FileReader();

            // Cette fonction s'exécute quand le fichier est lu
            reader.onload = function(e) {
                preview.src = e.target.result; // On met les données de l'image dans le src
            }

            reader.readAsDataURL(file); // On lance la lecture du fichier
        }
    });
</script>