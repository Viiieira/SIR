function checkActiveTheme() {
    if(localStorage.getItem("themeSwitch") === 'light') {
        document.querySelector('body').classList.add("light-mode");
        document.getElementById('toggleLight').classList.add("fa-moon");
    } else {
        document.getElementById('toggleLight').classList.add("fa-sun");
    }
}

window.onload = checkActiveTheme;