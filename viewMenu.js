function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({
        behavior: "smooth"
    });
}

function filterMenu(tag) {
    let items = document.querySelectorAll(".menu-item");

    items.forEach(item => {
        let tags = item.getAttribute("data-tags");

        if (tag === "all") {
            item.style.display = "block";
        } else if (tags.includes(tag)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}

const sections = document.querySelectorAll(".menu-section");
const navLinks = document.querySelectorAll(".menu-scroll a[data-section]");
const filterLinks = document.querySelectorAll(".filter-link");

let isClickScrolling = false;
let isFiltering = false; // 👈 NEW

// =====================
// SECTION CLICK
// =====================
navLinks.forEach(link => {
    link.addEventListener("click", function(e) {
        e.preventDefault();

        const id = this.getAttribute("data-section");

        navLinks.forEach(l => l.classList.remove("active"));
        filterLinks.forEach(l => l.classList.remove("active"));

        this.classList.add("active");

        isClickScrolling = true;
        isFiltering = false;

        document.getElementById(id).scrollIntoView({
            behavior: "smooth"
        });

        setTimeout(() => {
            isClickScrolling = false;
        }, 700);
    });
});


// =====================
// FILTER CLICK
// =====================
filterLinks.forEach(link => {
    link.addEventListener("click", function(e) {
        e.preventDefault();

        const filter = this.getAttribute("data-filter");

        // Highlight filter
        navLinks.forEach(l => l.classList.remove("active"));
        filterLinks.forEach(l => l.classList.remove("active"));
        this.classList.add("active");

        isFiltering = true; // 👈 STOP observer override

        filterMenu(filter);
    });
});


// =====================
// OBSERVER
// =====================
const observer = new IntersectionObserver(
    (entries) => {
        if (isClickScrolling || isFiltering) return; // 👈 KEY FIX

        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let id = entry.target.id;

                navLinks.forEach(link => {
                    link.classList.remove("active");

                    if (link.getAttribute("data-section") === id) {
                        link.classList.add("active");
                    }
                });
            }
        });
    },
    {
        threshold: 0.5
    }
);

sections.forEach(section => observer.observe(section));