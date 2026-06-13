<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos</title>
    <link rel="stylesheet" href="../CSS/ourLocations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>

   <section class="locations-page">
        <div class="container">
            <!-- Page Header -->
            <h1 class="page-title">Our Locations</h1>
            
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">ALL</button>
                <button class="filter-tab" data-filter="check-in">CHECK IN</button>
                <button class="filter-tab" data-filter="delivery">DELIVERY</button>
                <button class="filter-tab" data-filter="liquor">LIQUOR LICENCE</button>
                <button class="filter-tab" data-filter="on-site">ON-SITE SERVICES</button>
                <button class="filter-tab" data-filter="smoking">SMOKING</button>
                <button class="filter-tab" data-filter="takeaway">TAKEAWAY</button>
                <button class="filter-tab" data-filter="wheelchair">WHEELCHAIR</button>
            </div>
            
             <!-- Loading Spinner -->
                <div id="loadingSpinner" class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i> Loading locations...
                </div>
                
                <!-- Provinces Row-->
                <div id="provincesContainer" class="provinces-row"></div>
            
        </div>
    </section>

        <!-- CTA Section -->
    <section class="cta-section">
        <p class="cta-text">Experience culinary excellence with us.</p>
        <a href="makeReservation.php" class="cta-link">BOOK NOW ></a>
    </section>
    
    </main>
    <?php include 'footer.php'; ?>

    <!-- Popup Modal -->
    <div id="locationModal" class="location-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalLocationName">Location Name</h3>
                <button class="close-modal" id="closeModalBtn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-text" id="modalAddress"></div>
                </div>
                <div class="info-row">
                    <i class="fas fa-phone-alt"></i>
                    <div class="info-text">
                        <a href="tel:" id="modalPhoneLink" class="clickable-link">
                            <span id="modalPhone"></span>
                        </a>
                    </div>
                </div>
                <div class="info-row">
                    <i class="fas fa-envelope"></i>
                    <div class="info-text">
                        <a href="mailto:" id="modalEmailLink" class="clickable-link">
                            <span id="modalEmail"></span>
                        </a>
                    </div>
                </div>
                <div class="info-row" id="modalFeaturesRow" style="display: none;">
                    <i class="fas fa-tags"></i>
                    <div class="info-text" id="modalFeatures"></div>
                </div>
            </div>
            <div class="modal-footer">
                <i class="fas fa-utensils"></i> 
                <a href="makeReservation.php" id="modalReservationLink" class="reservation-link">Make a reservation at this location</a>
            </div>
        </div>
    </div>
<script src="../JS/ourLocations.js"></script>
</body>
</html>