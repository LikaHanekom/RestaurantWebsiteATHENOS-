<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos - Menu</title>
    <link rel="stylesheet" href="../CSS/viewMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="viewMenu.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>MAIN MENU</h1>
        </div>
    </section>

    <main>
        <div class="menu-nav">
            <div class="menu-scroll">
                <a href="#starters" data-section="starters" class="active">Starters</a>
                <a href="#steaks" data-section="steaks">Steaks</a>
                <a href="#desserts" data-section="desserts">Desserts</a>
                <a href="#beverages" data-section="beverages">Beverages</a>

                <span class="divider">|</span>

                <a href="#" class="filter-link active" data-filter="all">All</a>
                <a href="#" class="filter-link" data-filter="vegan">Vegan</a>
                <a href="#" class="filter-link" data-filter="gluten">Gluten-Free</a>
            </div>
        </div>

        <section class="menu-container">
            <h1>MYKONOS TAVERNA</h1>
            <p class="subtitle">MAIN MENU</p>

            <section id="starters" class="menu-section">
                <h2>STARTERS</h2>
                <div class="menu-grid">
                    <div class="menu-item" data-tags="gluten">
                        <img src="../assets/Tzatziki.jpeg" alt="Tzatziki" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Tzatziki <span class="badge gluten">GF</span>
                                </div>
                                <span>R45</span>
                            </div>
                            <p>Authentic Greek yogurt, cucumber, and garlic dip.</p>
                        </div>
                    </div>

                    <div class="menu-item" data-tags="vegan gluten">
                        <img src="../assets/Hummus.jpeg" alt="Hummus" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Classic Hummus <span class="badge vegan">V</span> <span class="badge gluten">GF</span>
                                </div>
                                <span>R50</span>
                            </div>
                            <p>Smooth chickpeas blended with tahini, lemon, and olive oil.</p>
                        </div>
                    </div>

                    <div class="menu-item" data-tags="vegan gluten">
                        <img src="../assets/dolmades.jpg" alt="Dolmades" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Dolmades <span class="badge vegan">V</span> <span class="badge gluten">GF</span>
                                </div>
                                <span>R55</span>
                            </div>
                            <p>Hand-rolled vine leaves stuffed with herb-infused rice.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="steaks" class="menu-section">
                <h2>STEAKS & MAINS</h2>
                <div class="menu-grid">
                    <div class="menu-item" data-tags="gluten">
                        <img src="../assets/Paidakia.jpeg" alt="Lamb Chops" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Paidakia (Lamb Chops) <span class="badge gluten">GF</span>
                                </div>
                                <span>R185</span>
                            </div>
                            <p>Flame-grilled lamb chops with lemon, garlic, and wild oregano.</p>
                        </div>
                    </div>

                    <div class="menu-item" data-tags="gluten">
                        <img src="../assets/TomahawkSteaks.jpeg" alt="Tomahawk Ribeye" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Tomahawk Steak <span class="badge gluten">GF</span>
                                </div>
                                <span>R240</span>
                            </div>
                            <p>400g Grilled ribeye with a rosemary and sea salt crust.</p>
                        </div>
                    </div>

                    <div class="menu-item" data-tags="vegan gluten">
                        <img src="../assets/Gemista.jpeg" alt="Gemista" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Gemista <span class="badge vegan">V</span> <span class="badge gluten">GF</span>
                                </div>
                                <span>R115</span>
                            </div>
                            <p>Peppers and tomatoes stuffed with seasoned vegetable rice and baked.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="desserts" class="menu-section">
                <h2>DESSERTS</h2>
                <div class="menu-grid">
                    <div class="menu-item" data-tags="">
                        <img src="../assets/Baklava.jpeg" alt="Baklava" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">Baklava</div>
                                <span>R55</span>
                            </div>
                            <p>Crispy phyllo layers with walnuts and spiced syrup.</p>
                        </div>
                    </div>

                    <div class="menu-item" data-tags="vegan gluten">
                        <img src="../assets/Halva.jpeg" alt="Semolina Halva" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Traditional Halva <span class="badge vegan">V</span> <span class="badge gluten">GF</span>
                                </div>
                                <span>R50</span>
                            </div>
                            <p>A completely dairy-free semolina pudding flavored with cinnamon.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="beverages" class="menu-section">
                <h2>BEVERAGES</h2>
                <div class="menu-grid">
                    <div class="menu-item" data-tags="vegan gluten">
                        <img src="../assets/Ouzo.jpeg" alt="Ouzo" class="menu-item-img">
                        <div class="menu-item-info">
                            <div class="title">
                                <div class="title-left">
                                    Ouzo <span class="badge vegan">V</span> <span class="badge gluten">GF</span>
                                </div>
                                <span>R40</span>
                            </div>
                            <p>The iconic anise-flavored clear spirit of Greece.</p>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>