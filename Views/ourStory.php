<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos</title>
    <link rel="stylesheet" href="../CSS/ourStory.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="hero">
        <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>OUR STORY</h1>
            </div>
    </section>
    <main class="main-body">
        <section class="info">
            <p class="story-text">For decades, our Greek restaurant has been a celebration of Mediterranean tradition, where every dish tells a story of sun‑drenched shores, fresh ingredients, and heartfelt hospitality. What began as a dream to share the vibrant flavours of Greece has grown into a beloved destination for food lovers who seek warmth, culture, and authentic cuisine. From the moment you step through our doors, you’re welcomed into an inviting space where blue and white accents evoke the spirit of the Aegean, and every meal feels like a sincere expression of Greek joie de vivre.</p>
            <img src="../assets/winde-glasses.png" alt="" class="story-img">
        </section>
        <section class="info reverse">
            <img src="../assets/fish.png" alt="" class="story-img">
            <p class="story-text">For decades, our Greek restaurant has been a celebration of Mediterranean tradition, where every dish tells a story of sun‑drenched shores, fresh ingredients, and heartfelt hospitality. What began as a dream to share the vibrant flavours of Greece has grown into a beloved destination for food lovers who seek warmth, culture, and authentic cuisine. From the moment you step through our doors, you’re welcomed into an inviting space where blue and white accents evoke the spirit of the Aegean, and every meal feels like a sincere expression of Greek joie de vivre.</p>
        </section>
        <section class="info">
            <p class="story-text">Our journey has been shaped by community, celebration, and connection. Whether it’s the laughter of friends sharing dishes over wine or the joy of a family gathering, our restaurant is built around the belief that great food brings people together. We honour this tradition in every interaction, inviting you to linger, share stories, raise a glass of ouzo or local wine, and be part of our ongoing story of passion, flavour, and hospitality.</p>
            <img src="../assets/wraps-on-salad.jpeg" alt="" class="story-img">
        </section>

        <section class="chefs-section">
            <div class="chefs-left">
                <h2>Meet our chefs</h2>
                <p>Passionate culinary experts crafting every dish with care and creativity.</p>
            </div>

            <div class="chefs-right">
                <div class="chef-card">
                <img src="../assets/Chef1.png" alt="Chef 1">
                <div class="chef-overlay">
                    <h3>Chef Alex</h3>
                    <p>Specialises in modern fusion cuisine with bold flavours.</p>
                </div>
                </div>

                <div class="chef-card">
                <img src="../assets/chef2.png" alt="Chef 2">
                <div class="chef-overlay">
                    <h3>Chef Maria</h3>
                    <p>Expert in traditional Italian dishes and handmade pasta.</p>
                </div>
                </div>

                <div class="chef-card">
                <img src="../assets/chef3.png" alt="Chef 3">
                <div class="chef-overlay">
                    <h3>Chef David</h3>
                    <p>Grill master known for perfectly cooked meats and sauces.</p>
                </div>
                </div>
            </div>
        </section>

       <section class="awards-section">

            <h2>Awards & Recognition</h2>

            <div class="awards-container">

                <div class="award-card">
                    <div class="icon"><i class="fa-solid fa-award"></i></div>
                    <p>"Best Mediterranean Restaurant – Johannesburg Food Awards 2025"</p>
                    <h4>Gold Winner</h4>
                </div>

                <div class="award-card">
                    <div class="icon"><i class="fa-solid fa-star"></i></div>
                    <p>"Top 10 Greek Dining Experiences in South Africa"</p>
                    <h4>Food & Travel Guide</h4>
                </div>

                <div class="award-card">
                    <div class="icon"><i class="fa-solid fa-utensils"></i></div>
                    <p>"Excellence in Authentic Cuisine & Hospitality"</p>
                    <h4>Culinary Institute SA</h4>
                </div>

            </div>

        </section>

        <section class="full-image">
            <a href="makeReservation.php" class="full-image">
                <img src="../assets/ourstorybottom.png" alt="Description">
                <div class="overlay">
                    <div class="overlay-content">
                        <h2 class="overlay-title">Book Now ></h2>
                        <div class="overlay-line"></div>
                        <p class="overlay-subtitle">Come Enjoy Authentic Greek Quisine</p>
                    </div>
                </div>
            </a>
        </section>

        

    </main>
    <?php include 'footer.php'; ?>
</body>
</html>