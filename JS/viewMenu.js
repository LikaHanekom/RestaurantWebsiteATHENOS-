function filterMenu(tag) {
    let items = document.querySelectorAll(".menu-item");

    items.forEach(item => {
        let tags = item.getAttribute("data-tags") || "";
        let tagArray = tags.split(" ");

        if (tag === "all") {
            item.style.display = "flex"; // Show item normally using flex alignment
        } else if (tagArray.includes(tag)) {
            item.style.display = "flex"; // Match found, show item
        } else {
            item.style.display = "none"; // No match found, hide item completely
        }
    });
}

const sections = document.querySelectorAll(".menu-section");
const navLinks = document.querySelectorAll(".menu-scroll a[data-section]");
const filterLinks = document.querySelectorAll(".filter-link");

let isClickScrolling = false;
let isFiltering = false;

// CATEGORY NAVIGATION LINK SCROLLING
navLinks.forEach(link => {
    link.addEventListener("click", function(e) {
        e.preventDefault();
        const id = this.getAttribute("data-section");

        navLinks.forEach(l => l.classList.remove("active"));
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

// DIETARY FILTERING BUTTON CLICKS 
filterLinks.forEach(link => {
    link.addEventListener("click", function(e) {
        e.preventDefault();

        filterLinks.forEach(l => l.classList.remove("active"));
        this.classList.add("active");

        isFiltering = true; 
        const filter = this.getAttribute("data-filter");
        filterMenu(filter);
    });
});

// SCROLL TRACKER INTERSECTION OBSERVER
const observer = new IntersectionObserver(
    (entries) => {
        if (isClickScrolling || isFiltering) return;

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
    { threshold: 0.3 }
);

sections.forEach(section => observer.observe(section));