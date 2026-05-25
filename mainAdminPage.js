// Sidebar active state

const navItems = document.querySelectorAll(".nav-links li");

navItems.forEach(item => {

    item.addEventListener("click", () => {

        navItems.forEach(nav => nav.classList.remove("active"));

        item.classList.add("active");

    });

});

// Buttons

const actionButtons = document.querySelectorAll(".action-card button");

actionButtons.forEach(button => {

    button.addEventListener("mouseenter", () => {

        button.style.transform = "translateY(-2px)";

    });

    button.addEventListener("mouseleave", () => {

        button.style.transform = "translateY(0px)";

    });

});

// Hero button

const heroBtn = document.querySelector(".hero-btn");

heroBtn.addEventListener("click", () => {

    window.location.href = "../index.php";

});