function checkActiveTheme() {
    if(localStorage.getItem("themeSwitch") === 'light') {
        document.querySelector('body').classList.add("light-mode");
        document.getElementById('toggleLightIcon').classList.add("fa-moon");
        document.getElementById('toggleLightLabel').innerHTML = "Dark Theme";
    } else {
        document.getElementById('toggleLightIcon').classList.add("fa-sun");
        document.getElementById('toggleLightLabel').innerHTML = "Light Theme";
    }
}

window.onload = checkActiveTheme;

// Function to show the form only if the new user is going to be a manager
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById("selectAddUser");
        selectElement.addEventListener('change', function() {
        const formSelectElement = document.getElementById("addManagerForm")
        if(selectElement.value == 2) {
            formSelectElement.classList.remove('hidden');
        } else {
            formSelectElement.classList.add('hidden');
        }
    })
})