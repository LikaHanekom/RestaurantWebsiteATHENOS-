
window.addEventListener("DOMContentLoaded", () => {
    let heroSlides = document.querySelectorAll('.hero-slide');
    let heroIndex = 0;

    if (heroSlides.length === 0) return;

    setInterval(() => {
        heroSlides[heroIndex].classList.remove('active');

        heroIndex = (heroIndex + 1) % heroSlides.length;

        heroSlides[heroIndex].classList.add('active');
    }, 6000);
});