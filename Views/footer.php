<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<footer class="footer">
        <section class="footer-left">
            <a href="https://www.instagram.com/athenos_restaurant/?hl=en" target="_blank" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>

            <a href="hhttps://www.facebook.com/profile.php?id=100068622436265" target="_blank" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
        </section>
        <section class="footer-nav-links">
            <a href="ourStory.php">OUR STORY</a>
            <a href="specialEvents.php">SPECIAL EVENTS</a>
            <a href="ourLocations.php">LOCATIONS</a>
            <a href="viewMenu.php">MENU</a>
            <a href="gallery.php">GALLERY</a>
            <a href="vouchers.php">VOUCHERS</a>
            <?php if (isset($_SESSION['user_id'])): ?>

                <a href="../Handlers/logout.php">LOGOUT</a>

            <?php else: ?>

                <a href="login.php">LOGIN</a>

            <?php endif; ?>
        </section>
        <section class="footer-contact">
            <a href="contactUs.php">CONTACT US</a>
        </section>
</footer>