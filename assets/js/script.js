let mainNav = document.getElementById('js-menu');
let navBarToggle = document.getElementById('js-topNavbar-toggle');

navBarToggle.addEventListener('click', function () {
  mainNav.classList.toggle('active');
});
