<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<footer class="footer">
        <section class="footer-left">
            <i class="fab fa-instagram"></i>
            <i class="fab fa-facebook-f"></i>
        </section>
        <section class="footer-nav-links">
            <a href="ourStory.html">OUR STORY</a>
            <a href="specialEvents.html">SPECIAL EVENTS</a>
            <a href="ourLocations.html">LOCATIONS</a>
            <a href="viewMenu.html">MENU</a>
            <a href="gallery.html">GALLERY</a>
            <a href="vouchers.html">VOUCHERS</a>
            <?php if (isset($_SESSION['user_id'])): ?>

                <a href="logout.php">LOGOUT</a>

            <?php else: ?>

                <a href="login.php">LOGIN</a>

            <?php endif; ?>
        </section>
        <section class="footer-contact">
            <a href="contactUs.html">CONTACT US</a>
        </section>
</footer>