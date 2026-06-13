<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos - Make a Reservation</title>
    <link rel="stylesheet" href="../CSS/makeReservations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="image-section"></div>

        <section class="form-panel">
            <button class="close-btn" id="closeBtn">&times;</button>
            
            <h1>MAKE A<br>RESERVATION</h1>
            
            <div class="form-group">
                <label>SELECT LOCATION</label>
                <select id="locationSelect">
                    <option value="">-- Choose a restaurant --</option>
                </select>
            </div>

            <div id="locationInfo" style="display: none;">
                <div class="info-box">
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> <span id="address"></span></p>
                    <p><i class="fas fa-phone"></i> <strong>Phone:</strong> <a href="#" id="phoneLink"><span id="phone"></span></a></p>
                    <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <a href="#" id="emailLink"><span id="email"></span></a></p>
                </div>
            </div>

            <div class="form-group">
                <label>YOUR DETAILS</label>
                <input type="text" id="customerName" placeholder="Full Name" required>
                <input type="email" id="customerEmail" placeholder="Email Address" required>
                <input type="tel" id="customerPhone" placeholder="Phone Number" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>DATE</label>
                    <input type="date" id="reservationDate">
                </div>
                <div class="form-group">
                    <label>TIME</label>
                    <select id="timeSlot">
                        <option value="">Select time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>GUESTS</label>
                    <input type="number" id="partySize" placeholder="Number" min="1" max="20">
                </div>
            </div>

            <div class="form-group">
                <label>SPECIAL REQUESTS (Optional)</label>
                <textarea id="specialRequests" rows="3" placeholder="Dietary restrictions, allergies, special occasions..."></textarea>
            </div>

            <button id="submitBtn" class="submit-btn">CONFIRM RESERVATION</button>

            <div class="footer-links">
                <a href="#">OR EMAIL US ></a>
            </div>
        </section>
    </div>

    <div id="toast" class="toast"></div>

    <script src="../JS/reservations.js"></script>
</body>
</html>