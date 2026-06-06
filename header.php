<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<header class="header">

    <a href="index.php" class="logo-link">
        <div class="logo">
            ATHENOS 
            <span>- GREEK TAVERNA -</span>
        </div>
    </a>

    <section class="nav-links">
        <a href="ourStory.php">OUR STORY</a>
        <a href="specialEvents.php">SPECIAL EVENTS</a>
        <a href="ourLocations.php">LOCATIONS</a>
        <a href="viewMenu.php">MENU</a>
        <a href="gallery.php">GALLERY</a>
        <a href="vouchers.php">VOUCHERS</a>
    </section>

    <a href="makeReservation.html" class="btn">MAKE A RESERVATION</a>

    <!--PROFILE ICON - Only appears when logged in -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <section class="auth-icon">
            <a href="profile.php" class="profile-icon">
                <i class="fa fa-user"></i>
            </a>
        </section>
    <?php endif; ?>

</header>