 // Global variable to store locations data
        let allLocationsData = [];
        
        // Function to fetch locations from database
        async function fetchLocations() {
            try {
                const response = await fetch('get_locations.php');
                if (!response.ok) {
                    throw new Error('Failed to fetch locations');
                }
                const data = await response.json();
                allLocationsData = data;
                displayLocationsByProvince(allLocationsData);
                document.getElementById('loadingSpinner').style.display = 'none';
            } catch (error) {
                console.error('Error fetching locations:', error);
                document.getElementById('loadingSpinner').innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error loading locations. Please refresh the page.';
            }
        }
        
        // Function to group locations by province
        function groupByProvince(locations) {
            const grouped = {};
            locations.forEach(location => {
                if (!grouped[location.province]) {
                    grouped[location.province] = [];
                }
                grouped[location.province].push(location);
            });
            return grouped;
        }
        
        // Function to display locations in the provinces row
        function displayLocationsByProvince(locations) {
            const grouped = groupByProvince(locations);
            const provincesContainer = document.getElementById('provincesContainer');
            provincesContainer.innerHTML = '';
            
            // Define province order (optional)
            const provinceOrder = ['Gauteng', 'Western Cape', 'Northern Cape', 'KwaZulu-Natal', 'Eastern Cape'];
            
            // Sort provinces according to order
            const sortedProvinces = Object.keys(grouped).sort((a, b) => {
                return provinceOrder.indexOf(a) - provinceOrder.indexOf(b);
            });
            
            sortedProvinces.forEach(province => {
                const provinceLocations = grouped[province];
                const provinceColumn = document.createElement('div');
                provinceColumn.className = 'province-column';
                provinceColumn.setAttribute('data-province', province);
                
                // Add province title
                const provinceTitle = document.createElement('h2');
                provinceTitle.className = 'province-title';
                provinceTitle.textContent = province;
                provinceColumn.appendChild(provinceTitle);
                
                // Add location list
                const locationList = document.createElement('div');
                locationList.className = 'location-list';
                
                provinceLocations.forEach(location => {
                    const locationItem = document.createElement('div');
                    locationItem.className = 'location-item';
                    locationItem.textContent = location.location_name;
                    locationItem.setAttribute('data-location-id', location.location_id);
                    locationItem.setAttribute('data-location-name', location.location_name);
                    locationItem.setAttribute('data-address', location.address);
                    locationItem.setAttribute('data-phone', location.phone);
                    locationItem.setAttribute('data-email', location.email);
                    locationItem.setAttribute('data-features', JSON.stringify(location.features));
                    
                    // Add click event to show modal
                    locationItem.addEventListener('click', () => {
                        openModal(location);
                    });
                    
                    locationList.appendChild(locationItem);
                });
                
                provinceColumn.appendChild(locationList);
                provincesContainer.appendChild(provinceColumn);
            });
        }
        
        // Filter locations based on selected feature
        function filterLocations(feature) {
            if (feature === 'all') {
                displayLocationsByProvince(allLocationsData);
                return;
            }
            
            // Map filter tab text to database feature values
            const featureMap = {
                'check-in': 'check-in',
                'delivery': 'delivery',
                'liquor': 'liquor',
                'on-site': 'on-site',
                'smoking': 'smoking',
                'takeaway': 'takeaway',
                'wheelchair': 'wheelchair'
            };
            
            const dbFeature = featureMap[feature];
            if (!dbFeature) {
                displayLocationsByProvince(allLocationsData);
                return;
            }
            
            const filteredLocations = allLocationsData.filter(location => {
                return location.features && location.features.includes(dbFeature);
            });
            
            displayLocationsByProvince(filteredLocations);
        }
        
        // Modal functions
        const modal = document.getElementById('locationModal');
        const modalLocationName = document.getElementById('modalLocationName');
        const modalAddress = document.getElementById('modalAddress');
        const modalPhone = document.getElementById('modalPhone');
        const modalEmail = document.getElementById('modalEmail');
        const modalFeatures = document.getElementById('modalFeatures');
        const modalFeaturesRow = document.getElementById('modalFeaturesRow');
        const closeModalBtn = document.getElementById('closeModalBtn');
        
       function openModal(location) {
            modalLocationName.textContent = location.location_name;
            modalAddress.textContent = location.address;
            
            // Set clickable phone number
            const phoneNumber = location.phone;
            const modalPhoneSpan = document.getElementById('modalPhone');
            const modalPhoneLink = document.getElementById('modalPhoneLink');
            modalPhoneSpan.textContent = phoneNumber;
            modalPhoneLink.href = `tel:${phoneNumber.replace(/[^0-9+]/g, '')}`; // Clean phone number for tel: link
            modalPhoneLink.setAttribute('data-tooltip', 'Click to call');
            
            // Set clickable email
            const emailAddress = location.email;
            const modalEmailSpan = document.getElementById('modalEmail');
            const modalEmailLink = document.getElementById('modalEmailLink');
            modalEmailSpan.textContent = emailAddress;
            modalEmailLink.href = `mailto:${emailAddress}?subject=Athenos%20Reservation%20Inquiry&body=Hello,%20I%27m%20interested%20in%20making%20a%20reservation%20at%20your%20${encodeURIComponent(location.location_name)}%20location.`;
            modalEmailLink.setAttribute('data-tooltip', 'Click to send email');
            
            // Set reservation link with location parameter
            const modalReservationLink = document.getElementById('modalReservationLink');
            modalReservationLink.href = `makeReservation.html?location=${encodeURIComponent(location.location_name)}&location_id=${location.location_id}`;
            
            // Display features if available
            if (location.features && location.features.length > 0) {
                const featuresFormatted = location.features.map(f => 
                    f.replace('-', ' ').toUpperCase()
                ).join(' • ');
                modalFeatures.textContent = featuresFormatted;
                modalFeaturesRow.style.display = 'flex';
            } else {
                modalFeaturesRow.style.display = 'none';
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        // Event Listeners
        closeModalBtn.addEventListener('click', closeModal);
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeModal();
            }
        });
        
        // Filter tabs functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active state
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                // Get filter value
                const filter = tab.getAttribute('data-filter');
                
                // Show loading state briefly for smooth UX
                document.getElementById('loadingSpinner').style.display = 'flex';
                document.getElementById('loadingSpinner').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Filtering locations...';
                
                // Simulate small delay for better UX
                setTimeout(() => {
                    filterLocations(filter);
                    document.getElementById('loadingSpinner').style.display = 'none';
                }, 200);
            });
        });
        
        // Load locations when page loads
        document.addEventListener('DOMContentLoaded', () => {
            fetchLocations();
        });