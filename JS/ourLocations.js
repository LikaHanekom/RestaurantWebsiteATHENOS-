// Global variable to store locations data
let allLocationsData = [];

// Function to fetch locations from database
async function fetchLocations() {
    try {
        const response = await fetch('../Handlers/get_locations.php');
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
    const provincesContainer = document.getElementById('provincesContainer');
    if (!provincesContainer) return;
    
    const grouped = groupByProvince(locations);
    provincesContainer.innerHTML = '';
    
    // Check if empty
    if (locations.length === 0) {
        provincesContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-map-marker-alt" style="opacity: 0.5; font-size: 48px; margin-bottom: 20px;"></i>
                <p>No locations matches found for this filter criteria.</p>
            </div>`;
        return;
    }
    
    const provinceOrder = ['Gauteng', 'Western Cape', 'Northern Cape', 'KwaZulu-Natal', 'Eastern Cape'];
    
    const sortedProvinces = Object.keys(grouped).sort((a, b) => {
        return provinceOrder.indexOf(a) - provinceOrder.indexOf(b);
    });
    
    sortedProvinces.forEach(province => {
        const provinceLocations = grouped[province];
        const provinceColumn = document.createElement('div');
        provinceColumn.className = 'province-column';
        provinceColumn.setAttribute('data-province', province);
        
        const provinceTitle = document.createElement('h2');
        provinceTitle.className = 'province-title';
        provinceTitle.textContent = province;
        provinceColumn.appendChild(provinceTitle);
        
        const locationList = document.createElement('div');
        locationList.className = 'location-list';
        
        provinceLocations.forEach(location => {
            const locationItem = document.createElement('div');
            locationItem.className = 'location-item';
            locationItem.textContent = location.location_name;
            
            // Assign direct attributes for reference lookup
            locationItem.setAttribute('data-location-id', location.location_id);
            
            // Attach location dataset reference safely to element mapping
            locationItem.locationDataObject = location;
            
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

// Modal Cache Handlers
const modal = document.getElementById('locationModal');
const modalLocationName = document.getElementById('modalLocationName');
const modalAddress = document.getElementById('modalAddress');
const modalFeatures = document.getElementById('modalFeatures');
const modalFeaturesRow = document.getElementById('modalFeaturesRow');
const closeModalBtn = document.getElementById('closeModalBtn');

function openModal(location) {
    if (!location) return;

    modalLocationName.textContent = location.location_name || 'Athenos Location';
    modalAddress.textContent = location.address || 'Address not available';
    
    // Config Phone Links safely
    const phoneNumber = location.phone;
    const modalPhoneSpan = document.getElementById('modalPhone');
    const modalPhoneLink = document.getElementById('modalPhoneLink');
    if (modalPhoneSpan && modalPhoneLink && phoneNumber) {
        modalPhoneSpan.textContent = phoneNumber;
        modalPhoneLink.href = `tel:${phoneNumber.replace(/[^0-9+]/g, '')}`;
        modalPhoneLink.setAttribute('data-tooltip', 'Click to call');
    }
    
    // Config Email Links safely
    const emailAddress = location.email;
    const modalEmailSpan = document.getElementById('modalEmail');
    const modalEmailLink = document.getElementById('modalEmailLink');
    if (modalEmailSpan && modalEmailLink && emailAddress) {
        modalEmailSpan.textContent = emailAddress;
        modalEmailLink.href = `mailto:${emailAddress}?subject=Athenos%20Reservation%20Inquiry&body=Hello,%20I%27m%20interested%20in%20making%20a%20reservation%20at%20your%20${encodeURIComponent(location.location_name)}%20location.`;
        modalEmailLink.setAttribute('data-tooltip', 'Click to send email');
    }
    
    // Config Booking Action
    const modalReservationLink = document.getElementById('modalReservationLink');
    if (modalReservationLink) {
        modalReservationLink.href = `makeReservation.php?location=${encodeURIComponent(location.location_name)}&location_id=${location.location_id}`;
    }
    
    // Parse features if they arrived as a JSON string from the backend
    let featureList = location.features;
    if (typeof featureList === 'string') {
        try {
            featureList = JSON.parse(featureList);
        } catch(e) {
            featureList = [];
        }
    }
    
    // Config Feature Badges
    if (Array.isArray(featureList) && featureList.length > 0) {
        const featuresFormatted = featureList.map(f => 
            f.replace('-', ' ').toUpperCase()
        ).join(' • ');
        modalFeatures.textContent = featuresFormatted;
        modalFeaturesRow.style.display = 'flex';
    } else {
        modalFeaturesRow.style.display = 'none';
    }
    
    // Open the window view
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; 
}

function closeModal() {
    modal.style.display = 'none';
    
    //Only unlock body overflow if mobile menu drawer isn't active
    const navContainer = document.querySelector('.nav-container');
    if (navContainer && !navContainer.classList.contains('active')) {
        document.body.style.overflow = '';
    }
}


document.addEventListener('DOMContentLoaded', () => {
    fetchLocations();

    // Unified Event Delegation for dynamically created Location Items
    const provincesContainer = document.getElementById('provincesContainer');
    if (provincesContainer) {
        provincesContainer.addEventListener('click', (e) => {
            const item = e.target.closest('.location-item');
            if (item && item.locationDataObject) {
                e.stopPropagation(); // Stops mobile nav background script conflicts
                openModal(item.locationDataObject);
            }
        });
    }

    // Close Action Handlers
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeModal();
        }
    });
    
    // Filter tabs functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const spinner = document.getElementById('loadingSpinner');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            const filter = tab.getAttribute('data-filter');
            
            if (spinner) {
                spinner.style.display = 'block';
                spinner.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Filtering locations...';
            }
            
            setTimeout(() => {
                filterLocations(filter);
                if (spinner) spinner.style.display = 'none';
            }, 200);
        });
    });
});