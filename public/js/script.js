const coverInput = document.getElementById('cover-image');
const profilImageInput = document.getElementById('profileImageInput');
const chatWindow = document.getElementById('chat-window');

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

if(profilImageInput) {
    profilImageInput.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            setTimeout(() => {
                document.getElementById('profileImageForm').submit();
            }, 100);
        }
    });
}

if (chatWindow) {
    chatWindow.scrollTop = chatWindow.scrollHeight;
}