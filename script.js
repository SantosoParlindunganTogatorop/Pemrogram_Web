const navbarNav = document.querySelector(".navbar-nav");
const hamburger = document.querySelector("#hamburger-menu");
const darkModeToggle = document.querySelector("#dark-mode-toggle");
const body = document.body;

// Hamburger toggle
hamburger.onclick = () => {
  navbarNav.classList.toggle("active");
};

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

// Dark mode toggle
darkModeToggle.onclick = (e) => {
  e.preventDefault();
  body.classList.toggle("dark-mode");

  // Ganti ikon moon <-> sun
  if (body.classList.contains("dark-mode")) {
    darkModeToggle.innerHTML = '<i data-feather="sun"></i>';
  } else {
    darkModeToggle.innerHTML = '<i data-feather="moon"></i>';
  }
  feather.replace();
};

// render ikon feather
feather.replace();

const userIcon = document.getElementById("user");
const userDropdown = document.getElementById("userDropdown");

// Toggle dropdown ketika klik ikon user
userIcon.addEventListener("click", function (e) {
  e.preventDefault();
  userDropdown.classList.toggle("show"); // pakai class 'show'
});

// Klik di luar dropdown untuk menutup
document.addEventListener("click", function (e) {
  if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
    userDropdown.classList.remove("show"); // hilangkan dropdown
  }
});

const orderButtons = document.querySelectorAll(".btn-order");
const loginMessage = document.getElementById("loginMessage");

orderButtons.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    if (!isLoggedIn) {
      e.preventDefault(); // hentikan aksi default

      // tampilkan pesan
      loginMessage.style.display = "block";

      // scroll ke atas
      window.scrollTo({ top: 0, behavior: "smooth" });

      // sembunyikan pesan setelah 3 detik
      setTimeout(() => {
        loginMessage.style.display = "none";
      }, 3000);
    }
  });
});
