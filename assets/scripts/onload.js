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