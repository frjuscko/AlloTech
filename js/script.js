const themeBtn = document.querySelector('#themeBtn');
const body = document.querySelector('body');

themeBtn.addEventListener('click', () => {
    body.classList.toggle('dark_theme');
    if(document.body.classList.contains("dark_theme")){
    localStorage.setItem("theme","dark");
  } else {
    localStorage.setItem("theme","light");
  }
})

if(localStorage.getItem("theme") === "dark"){
  document.body.classList.add("dark_theme");
}