// Selecciona el botón para cambiar de tema
const toggleThemeBtn = document.querySelector("#toggle-theme-btn");

// Selecciona las hojas de estilo para cada tema
const lightTheme = document.querySelector("#light-theme");
const darkTheme = document.querySelector("#dark-theme");

// Función para guardar la elección del usuario en una cookie
function setThemeCookie(theme) {
  document.cookie = `theme=${theme}; path=/`;
}

// Función para obtener el valor de la cookie "theme"
function getThemeCookie() {
  const cookies = document.cookie.split(";").map((cookie) => cookie.trim());
  const themeCookie = cookies.find((cookie) => cookie.startsWith("theme="));
  return themeCookie ? themeCookie.split("=")[1] : null;
}

// Función para aplicar el tema guardado en la cookie
function applySavedTheme() {
  const savedTheme = getThemeCookie();
  if (savedTheme === "dark") {
    lightTheme.disabled = true;
    darkTheme.disabled = false;
  } else {
    lightTheme.disabled = false;
    darkTheme.disabled = true;
  }
}

// Agrega un controlador de eventos de clic al botón
toggleThemeBtn.addEventListener("click", function () {
  // Si la hoja de estilo del tema claro está activa, cambia a la hoja de estilo del tema oscuro y viceversa
  if (lightTheme.disabled) {
    lightTheme.disabled = false;
    darkTheme.disabled = true;
    setThemeCookie("light");
  } else {
    lightTheme.disabled = true;
    darkTheme.disabled = false;
    setThemeCookie("dark");
  }
  updateWelcomeMessage();
});

// función para establecer la cookie
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  SameSite = none;
}

// función para obtener el valor de una cookie
function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }

  return "";
}

// función para mostrar el mensaje de bienvenida
function showWelcomeMessage() {
  var theme = getCookie("theme");
  var message = "";
  if (theme === "dark") {
    message = "Bienvenido al sitio web oscuro";
  } else if (theme === "light") {
    message = "Bienvenido al sitio web claro";
  } else {
    message = "Bienvenido al sitio web";
  }
} 

function updateWelcomeMessage() {
  const savedTheme = getThemeCookie();
  const welcomeMessage = document.getElementById("welcome-message");
  if (savedTheme === "dark") {
    alertaPerzonalizada("success", "Bienvenido al sitio web oscuro");
  } else if (savedTheme === "light") {
    //welcomeMessage.innerHTML = "Bienvenido al sitio web claro";
    alertaPerzonalizada("success", "Bienvenido al sitio web claro");
  } else {
    //welcomeMessage.innerHTML = "Bienvenido al sitio web";
    alertaPerzonalizada("success", "Bienvenido al sitio web");
  }
}

// función para cambiar el tema
function changeTheme(theme) {
  setCookie("theme", theme, 30);
  showWelcomeMessage();
}

// mostrar el mensaje de bienvenida al cargar la página
showWelcomeMessage();
function updateButtonName() {
  const themeToggle = document.querySelector("#toggle-theme-btn");
  if (getThemeCookie() === "dark") {
    themeToggle.textContent = "Desactivar tema oscuro";
  } else {
    themeToggle.textContent = "Activar tema oscuro";
  }
}

// Aplica el tema guardado en la cookie al cargar la página
applySavedTheme();
