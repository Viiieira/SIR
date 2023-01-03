const navbarDropDownToggle = document.getElementById('navbar-dropdown');
const navbarDropDownMenu = document.getElementById('navbar-dropdown-menu');
const filterToggler = document.getElementById('filterToggler');
const filterMenu = document.getElementById('filterMenu');

navbarDropDownToggle.addEventListener('click', function() {
    navbarDropDownMenu.classList.toggle('hidden');
})

filterToggler.addEventListener('click', function () {
    filterMenu.classList.toggle('hidden');
})
