const navbarNav = document.querySelector(".navbar-nav");
const hamburger = document.querySelector("#hamburger-menu");
const darkModeToggle = document.querySelector("#dark-mode-toggle");
const body = document.body;

hamburger.onclick = () => {
  navbarNav.classList.toggle("active");
};

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

darkModeToggle.onclick = (e) => {
  e.preventDefault();
  body.classList.toggle("dark-mode");

  // Ganti ikon moon <-> sun
  if (body.classList.contains("dark-mode")) {
    darkModeToggle.innerHTML = '<i data-feather="sun"></i>';
  } else {
    darkModeToggle.innerHTML = '<i data-feather="moon"></i>';
  }

  // render ulang ikon feather setelah innerHTML berubah
  feather.replace();
};

// render ikon pertama kali
feather.replace();
