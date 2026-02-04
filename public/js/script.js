const coverInput = document.getElementById('cover-image');

if(coverInput) {
    coverInput.addEventListener('change', function(event) {
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
}