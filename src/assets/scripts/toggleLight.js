// Variables
const body = document.querySelector('body');
const toggle = document.getElementById('toggleLight');
const toggleIcon = document.getElementById('toggleLightIcon');
const toggleLabel = document.getElementById('toggleLightLabel');

// Function to switch the theme between dark and light
toggle.addEventListener('click', function() {
    if(body.classList.contains("light-mode") === true) {
        toggleIcon.classList.remove("fa-moon");
        toggleIcon.classList.add("fa-sun");
        body.classList.remove("light-mode");
        toggleLabel.innerHTML = "Light Theme";
        localStorage.removeItem("themeSwitch");
    } else {
        toggleIcon.classList.remove("fa-sun");
        toggleIcon.classList.add("fa-moon");
        body.classList.add("light-mode");
        toggleLabel.innerHTML = "Dark Theme";
        localStorage.setItem("themeSwitch", "light");
    }
})