document.addEventListener('DOMContentLoaded', function () {
    var navbar = document.querySelector('.navbar');
    var navbarBrand = document.querySelector('.navbar-brand');
    var navbarIcon = document.querySelector('.navbar-icon');
    var navLinks = document.querySelectorAll('.nav-link');
  
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
        navbarBrand.style.color = '#002628';
        navbarIcon.style.color = '#002628';
        navLinks.forEach(function (link) {
          link.style.color = '#002628';
        });
      } else {
        navbar.classList.remove('navbar-scrolled');
        navbarBrand.style.color = 'white';
        navbarIcon.style.color = 'white';
        navLinks.forEach(function (link) {
          link.style.color = 'white';
        });
      }

      
    });
  });
  