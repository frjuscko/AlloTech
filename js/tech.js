const invitBtn = document.querySelector('.invite_btn');
const commentInput = document.querySelector('.comment_input');
const commentText = document.querySelector('.commentText');
const commentBtn = document.querySelector('.commentBtn');
const commentEmail = document.querySelector('.commentEmail');


invitBtn.addEventListener('click', () => {
    commentInput.classList.toggle('show');
})

// Fermer le sous-menu en cliquant ailleurs
document.addEventListener('click', function (e) {
    if (!invitBtn.contains(e.target) && !commentText.contains(e.target) && !commentEmail.contains(e.target)) {
        commentInput.classList.remove('show');
    }
});