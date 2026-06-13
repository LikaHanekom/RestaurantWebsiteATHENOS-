<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos</title>
     <link rel="stylesheet" href="../CSS/voucher.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../JS/voucher.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <!-- TOP SECTION -->
        <section class="voucher-top">

            <div class="voucher-box">
                <h2>GIFT VOUCHERS</h2>
                <p>Buy vouchers for friends or loved ones.</p>
                <button onclick="openPopup('personal')">BUY A VOUCHER ></button>
            </div>

            <div class="voucher-box">
                <h2>GIFT VOUCHERS</h2>
                <p>Buy vouchers to incentivize staff or team.</p>
                <button onclick="openPopup('corporate')">REGISTER HERE ></button>
            </div>

        </section>

        <!--Voucher Popup-->
        <div id="voucherPopup" class="popup">
            <div class="popup-content">

                <span class="close" onclick="closePopup()">×</span>

                
                <div id="step1" class="step active">
                    <h2>Select a Design</h2>

                    <div class="design-grid">

                        <div class="card" onclick="selectDesign(this, 'birthday')">
                            <img src="../assets/Halva.jpeg">
                            <div class="overlay">Χρόνια Πολλά</div>
                        </div>

                        <div class="card" onclick="selectDesign(this, 'romantic')">
                            <img src="../assets/winde-glasses.png">
                            <div class="overlay">Dinner for Two</div>
                        </div>

                        <div class="card" onclick="selectDesign(this, 'celebration')">
                            <img src="../assets/dance.png">
                            <div class="overlay">Celebrate</div>
                        </div>

                    </div>
                </div>

                
                <div id="step2" class="step">
                    <h2>Voucher Details</h2>

                    <p id="selectedDesignText"></p>

                    <label>Amount (R):</label>
                    <input type="number" id="amount">

                    <label>Message:</label>
                    <textarea id="message"></textarea>

                    <label>Your Email:</label>
                    <input type="email" id="email">

                    <button onclick="submitVoucher()">Send Voucher</button>
                </div>

            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>