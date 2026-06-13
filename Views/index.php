<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../JS/index.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="hero">

        <div class="hero-slides">

            <div class="hero-slide active" style="background-image: url('../assets/Greek\ Lamb\ Gyros\ With\ Pita\ And\ Tahini\ Yogurt\ Sauce2.jpeg');">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1>Welcome</h1>
                    <h2>Authentic Greek Taverna Since 1972</h2>
                </div>
            </div>

            <div class="hero-slide" style="background-image: url('../assets/winde-glasses.png');">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1>WEEKEND SPECIALS</h1>
                    <h2>2-for-1 Souvlaki Platters every Saturday & Sunday</h2>
                </div>
            </div>

            <div class="hero-slide" style="background-image: url('../assets/fish.png');">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1>AUTHENTIC GREEK TAVERNA</h1>
                    <h2>Every Friday evening – shared plates & Greek wine</h2>
                    <h2></h2>
                </div>
            </div>

            <div class="hero-slide" style="background-image: url('../assets/fish.png');">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1>LUNCH DEAL</h1>
                    <h2>Free drink with any main meal before 3pm</h2>
                </div>
            </div>

        </div>

    </section>

    <main>
        
        <section class="content-section">
            <div class="container">
                <!-- Stacked paragraphs (one above the other) -->
                <div class="text-block">
                    <p class="first-paragraph">Since 1972, we've celebrated the heart of the Mediterranean – vibrant, welcoming, and unmistakably Aegean. Every drizzle of olive oil, every flame-kissed souvlaki, every shared meze platter reflects a tradition rooted in family, flavour, and φιλοξενία (philoxenia).</p>
                    <p class="second-paragraph">Over five decades of passion – all in pursuit of one promise: an authentic Greek dining experience that lingers long after the last bite.</p>
                </div>
                
                <!-- Separator line -->
                <div class="separator"></div>

                
                <!-- Three images in mosaic layout -->
                <div class="gallery">
                    <div class="top-image">
                        <img src="../assets/The Best Greek Food We Ate in Rhodes & Athens2.jpeg" alt="">
                    </div>

                    <div class="bottom-images">
                        <img src="../assets/wraps-on-salad.jpeg" alt="">
                        <img src="../assets/HomeImgLeft.png" alt="">
                        <img src="../assets/HomeImgRight.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="reviews-section">

            <h2>What Our Guests Say</h2>

            <div class="reviews-container">

                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>"Absolutely authentic Greek food. The souvlaki tastes just like Athens!"</p>
                    <h4>- Sarah M.</h4>
                </div>

                <div class="review-card">
                    <div class="stars">★★★★★</div>
                    <p>"Beautiful atmosphere, amazing service, and the wine night is a must!"</p>
                    <h4>- Daniel K.</h4>
                </div>

                <div class="review-card">
                    <div class="stars">★★★★☆</div>
                    <p>"Great food and vibe. Feels like a little piece of Greece in the city."</p>
                    <h4>- Lindiwe N.</h4>
                </div>

            </div>

            <!-- External review links -->
            <div class="review-links">
                <p>See more reviews:</p>
                <a href="https://www.google.com/search?q=athenos+restaurant+reviews" target="_blank">Google Reviews</a>
                <a href="https://www.tripadvisor.co.za/Restaurant_Review-g312659-d12345678-Reviews-Athenos-Cape_Town_Central_Western_Cape.html" target="_blank">TripAdvisor</a>
            </div>

        </section>

    </main>
    <?php include 'footer.php'; ?>
</body>
</html>