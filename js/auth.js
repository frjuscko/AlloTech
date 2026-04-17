const nextButtons = document.querySelectorAll('.next');
const prevButtons = document.querySelectorAll('.prev');

const slidesContainer = document.querySelector('.slides');
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

let currentIndex = 0;



// Fonction pour mettre à jour la position des slides
function updateSlidesPosition() {
    const translateValue = -currentIndex * 100;
    slidesContainer.style.transform = `translateX(${translateValue}%)`;
}

// Fonction pour mettre à jour l'état des boutons (désactiver aux extrémités)
function updateButtonsState() {
    // Désactiver/activer les boutons prev selon l'index
    prevButtons.forEach(btn => {
        if (currentIndex === 0) {
            btn.setAttribute('disabled', 'disabled');
        } else {
            btn.removeAttribute('disabled');
        }
    });
    
    // Désactiver/activer les boutons next selon l'index
    nextButtons.forEach(btn => {
        if (currentIndex === totalSlides - 1) {
            btn.setAttribute('disabled', 'disabled');
        } else {
            btn.removeAttribute('disabled');
        }
    });
}

// Fonction pour aller au slide suivant
function nextSlide() {
    if (currentIndex < totalSlides - 1) {
        currentIndex++;
        updateSlidesPosition();
        updateButtonsState();
    }
}

// Fonction pour aller au slide précédent
function prevSlide() {
    if (currentIndex > 0) {
        currentIndex--;
        updateSlidesPosition();
        updateButtonsState();
    }
}

// Ajouter les écouteurs à TOUS les boutons next
nextButtons.forEach(button => {
    button.addEventListener('click', nextSlide);
});

// Ajouter les écouteurs à TOUS les boutons prev
prevButtons.forEach(button => {
    button.addEventListener('click', prevSlide);
});

// Initialiser l'état des boutons
updateButtonsState();


let regLink = document.querySelector('#regLink');
let logLink = document.querySelector('#logLink');
let login = document.querySelector('.login');
let register = document.querySelector('.register');

cacher(logLink);

regLink.addEventListener('click', () => {
    console.log('reg');
    cacher(regLink);
    afficher(logLink);
    login.classList.remove('toRight');
    register.classList.remove('toRight');
    login.classList.add('toLeft');
    register.classList.add('toLeft');
})

logLink.addEventListener('click', () => {
    console.log('logo');
    cacher(logLink);
    afficher(regLink);
    login.classList.remove('toLeft');
    register.classList.remove('toLeft');
    login.classList.add('toRight');
    register.classList.add('toRight');
    
})

function cacher(l) {
    l.classList.toggle('hide');
}

function afficher(l) {
    l.classList.toggle('hide');
}


const passConfirm = document.querySelector('#passConfirm');
const pass = document.querySelector('#pass');
const submit = document.querySelector('#submit');
desactiver(submit);

passConfirm.addEventListener('blur', () => {
    if (passConfirm.value === pass.value) {
        activer(submit);
    } else {
        alert('Les mots de passe ne correspondent pas !');
        passConfirm.value = "";
        desactiver(submit);
    }
})

function desactiver(bouton) {
    bouton.disabled = true;
    bouton.classList.add('desactive');
}

function activer(bouton) {
    bouton.disabled = false;
    bouton.classList.remove('desactive');
}

