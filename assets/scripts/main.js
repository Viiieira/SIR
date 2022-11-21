const navbarDropDownToggle = document.getElementById('navbar-dropdown');
const navbarDropDownMenu = document.getElementById('navbar-dropdown-menu');

navbarDropDownToggle.addEventListener('click', function() {
    navbarDropDownMenu.classList.toggle('hidden');
})

// Article Stuff

    // Get the variables (link, article)
const link = document.querySelectorAll('a.sidebar-link');
const article = document.querySelectorAll('article');

link.addEventListener('click', function() {
    console.log("boas");
})