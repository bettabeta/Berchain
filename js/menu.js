// Desktop Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
  // Add hover functionality for desktop menu
  const menuItems = document.querySelectorAll('.desktop-menu > li');
  
  menuItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
      const subMenu = this.querySelector('.sub-menu');
      if (subMenu) {
        subMenu.style.display = 'block';
      }
    });
    
    item.addEventListener('mouseleave', function() {
      const subMenu = this.querySelector('.sub-menu');
      if (subMenu) {
        subMenu.style.display = 'none';
      }
    });
  });

  // Mobile Menu Toggle
  const burger = document.querySelector('.burger-menu');
  const mobileMenu = document.querySelector('.mobile-menu-container');
  const body = document.body;

  burger.addEventListener('click', function(e) {
    e.stopPropagation(); // Verhindert Event-Bubbling
    this.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    body.classList.toggle('menu-open');
  });

  // Close menu when clicking outside
  document.addEventListener('click', function(e) {
    if (mobileMenu.classList.contains('active') && 
        !mobileMenu.contains(e.target) && 
        !burger.contains(e.target)) {
      burger.classList.remove('active');
      mobileMenu.classList.remove('active');
      body.classList.remove('menu-open');
    }
  });
}); 