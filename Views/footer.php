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