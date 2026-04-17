const form = document.querySelector('#searchForm');
const searchInput = document.querySelector('input[name="search"]');
const skillSelect = document.querySelector('select[name="competence"]');
const villeSelect = document.querySelector('select[name="ville"]');

// Fonction pour soumettre le formulaire.
function submitForm(){
    form.submit();
}

if (skillSelect) {
    skillSelect.addEventListener('change', submitForm);
}

if (villeSelect) {
    villeSelect.addEventListener('change', submitForm);
}

let typingTimer;
const doneTypingInterval = 500;

if (searchInput) {
    searchInput.addEventListener('keyup', () =>{
        clearTimeout(typingTimer);
        typingTimer = setTimeout(submitForm, doneTypingInterval);
    })

    searchInput.addEventListener('keypress', () => {
        if (e.key === 'Enter') {
            clearTimeout(typingTimer);
            submitForm();
        }
    })
}