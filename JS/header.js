document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navContainer = document.querySelector('.nav-container');
    const toggleIcon = menuToggle.querySelector('i');
    const navLinks = document.querySelectorAll('.nav-links a');

    // Toggle menu function
    function toggleMenu() {
        navContainer.classList.toggle('active');
        
        if (navContainer.classList.contains('active')) {
            toggleIcon.classList.remove('fa-bars');
            toggleIcon.classList.add('fa-times');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
        } else {
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
            document.body.style.overflow = ''; // Restore scrolling
        }
    }

    // Toggle menu on button click
    menuToggle.addEventListener('click', toggleMenu);

    // Close menu when clicking on any nav link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navContainer.classList.contains('active')) {
                toggleMenu();
            }
        });
    });

    // Close menu when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = navContainer.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        
        if (navContainer.classList.contains('active') && !isClickInsideMenu && !isClickOnToggle) {
            toggleMenu();
        }
    });
});