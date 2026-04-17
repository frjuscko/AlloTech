(function() {
        // ---------- DOM Elements ----------
        const photoInput = document.getElementById('photoInput');
        const avatarPreviewDiv = document.getElementById('avatarPreview');
        const profileImg = document.getElementById('profileImage');
        const placeholderIcon = document.getElementById('placeholderIcon');
        

        // Variable pour stocker la photo en base64 (ou null)
        let currentPhotoBase64 = null;

        
        // Afficher la photo dans l'aperçu circulaire (base64)
        function displayPhotoPreview(base64String) {
            if (base64String && base64String.startsWith('data:image')) {
                profileImg.src = base64String;
                profileImg.style.display = 'block';
                placeholderIcon.style.display = 'none';
                currentPhotoBase64 = base64String;
            } else {
                // reset vers placeholder
                profileImg.style.display = 'none';
                placeholderIcon.style.display = 'flex';
                currentPhotoBase64 = null;
            }
        }
        
        // Gestion du fichier image
        function handlePhotoSelection(file) {
            if (!file) {
                // si aucun fichier, on garde l'ancienne (mais reset explicite possible)
                return;
            }
            
            // Vérifier type MIME
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format non supporté. Utilisez JPG, PNG ou WEBP.');
                photoInput.value = ''; // clear input
                return;
            }
            
            // Vérifier taille (5 Mo max)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('L\'image dépasse 5 Mo. Veuillez choisir une image plus légère.');
                photoInput.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageBase64 = e.target.result;
                displayPhotoPreview(imageBase64);
            };
            reader.onerror = function() {
                alert('Erreur lors de la lecture de l\'image.');
                photoInput.value = '';
            };
            reader.readAsDataURL(file);
        }
        
        // Evenement input photo
        photoInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                handlePhotoSelection(file);
            } else {
                // si l'utilisateur annule, on ne change rien
            }
        });
        
        // Permet de cliquer sur l'avatar pour déclencher l'upload (ergonomie)
        avatarPreviewDiv.addEventListener('click', (e) => {
            // Eviter conflit si clic sur le label qui a déjà son propre déclencheur
            return photoInput.click();;
            
        });
        
        // Fonction pour réinitialiser tout le formulaire (photo + champs + carte résultat)
        function resetFullForm() {
            // reset photo
            currentPhotoBase64 = null;
            profileImg.style.display = 'none';
            placeholderIcon.style.display = 'flex';
            photoInput.value = ''; // effacer la sélection de fichier
        }
        

        
        // simple escape html pour éviter XSS (même si les inputs sont validés)
        function escapeHtml(str) {
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
                return c;
            });
        }
        
        
        // Si l'utilisateur presse "Entrée" dans l'un des champs, déclencher soumission
        const handleEnter = (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitFormData();
            }
        };

        
        // initialisation: pas de photo, champs vides, aucun résultat affiché
        resetFullForm();
    })();