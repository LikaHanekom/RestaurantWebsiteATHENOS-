// API URLs
const GET_LOCATIONS_URL = 'get_locations.php';
const CREATE_RESERVATION_URL = 'create_reservation.php';

let locationsData = [];
let selectedLocationId = null;

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page loaded');
    
    // Get DOM elements
    window.locationSelect = document.getElementById('locationSelect');
    window.locationInfo = document.getElementById('locationInfo');
    window.addressSpan = document.getElementById('address');
    window.phoneSpan = document.getElementById('phone');
    window.emailSpan = document.getElementById('email');
    window.phoneLink = document.getElementById('phoneLink');
    window.emailLink = document.getElementById('emailLink');
    window.customerName = document.getElementById('customerName');
    window.customerEmail = document.getElementById('customerEmail');
    window.customerPhone = document.getElementById('customerPhone');
    window.reservationDate = document.getElementById('reservationDate');
    window.timeSlot = document.getElementById('timeSlot');
    window.partySize = document.getElementById('partySize');
    window.specialRequests = document.getElementById('specialRequests');
    window.submitBtn = document.getElementById('submitBtn');
    
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    reservationDate.min = today;
    reservationDate.value = today;
    
    // Initialize time dropdown with default message
    timeSlot.innerHTML = '<option value="">-- Select a time --</option>';
    
    // Load locations
    loadLocations();
    
    // Setup event listeners
    locationSelect.addEventListener('change', onLocationChange);
    reservationDate.addEventListener('change', onDateChange);
    submitBtn.addEventListener('click', submitReservation);
    
    // Close button
    const closeBtn = document.querySelector(".close-btn");
    if (closeBtn) {
        closeBtn.addEventListener("click", function() {
            window.location.href = "index.html";
        });
    }
});

// Function to populate time slots
function populateTimeSlots() {
    console.log('Populating time slots...');
    
    // Clear existing options
    timeSlot.innerHTML = '';
    
    // Add default option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-- Select a time --';
    timeSlot.appendChild(defaultOption);
    
    // Time slots array
    const timeSlots = [
        '12:00 PM', '12:30 PM', '13:00 PM', '13:30 PM', '14:00 PM',
        '14:30 PM', '17:00 PM', '17:30 PM', '18:00 PM', '18:30 PM',
        '19:00 PM', '19:30 PM', '20:00 PM', '20:30 PM', '21:00 PM'
    ];
    
    // Add each time slot
    for (let i = 0; i < timeSlots.length; i++) {
        const option = document.createElement('option');
        option.value = timeSlots[i];
        option.textContent = timeSlots[i];
        timeSlot.appendChild(option);
    }
    
    console.log('Added', timeSlots.length, 'time slots');
    console.log('Time dropdown now has', timeSlot.children.length, 'options');
}

// Load locations from database
async function loadLocations() {
    try {
        console.log(' Fetching locations...');
        const response = await fetch(GET_LOCATIONS_URL);
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        locationsData = data;
        
        // Populate dropdown
        locationSelect.innerHTML = '<option value="">-- Choose a restaurant --</option>';
        
        for (let i = 0; i < locationsData.length; i++) {
            const option = document.createElement('option');
            option.value = locationsData[i].location_id;
            option.textContent = `${locationsData[i].location_name} (${locationsData[i].province})`;
            locationSelect.appendChild(option);
        }
        
        console.log('✅ Loaded', locationsData.length, 'locations');
        
    } catch (error) {
        console.error('Error:', error);
        locationSelect.innerHTML = '<option value="">Error loading locations</option>';
        showToast('Failed to load locations', 'error');
    }
}

// Handle location selection
function onLocationChange() {
    const id = parseInt(locationSelect.value);
    selectedLocationId = id;
    
    console.log('📍 Location selected:', id);
    
    if (!id) {
        locationInfo.style.display = 'none';
        return;
    }
    
    // Find the selected location
    let location = null;
    for (let i = 0; i < locationsData.length; i++) {
        if (locationsData[i].location_id === id) {
            location = locationsData[i];
            break;
        }
    }
    
    if (location) {
        console.log('📍 Showing details for:', location.location_name);
        
        // Show location details
        addressSpan.textContent = location.address;
        phoneSpan.textContent = location.phone;
        emailSpan.textContent = location.email;
        phoneLink.href = 'tel:' + location.phone.replace(/\D/g, '');
        emailLink.href = 'mailto:' + location.email;
        locationInfo.style.display = 'block';
        
        // Populate time slots
        populateTimeSlots();
    }
}

// Handle date change
function onDateChange() {
    if (selectedLocationId) {
        console.log(' Date changed to:', reservationDate.value);
        console.log(' Refreshing time slots...');
        populateTimeSlots();
    }
}

// Validate form
function validateForm() {
    if (!selectedLocationId) {
        showToast('Please select a location', 'error');
        return false;
    }
    if (!customerName.value.trim()) {
        showToast('Please enter your name', 'error');
        customerName.focus();
        return false;
    }
    if (!customerEmail.value.trim() || !customerEmail.value.includes('@')) {
        showToast('Please enter a valid email', 'error');
        customerEmail.focus();
        return false;
    }
    if (!customerPhone.value.trim()) {
        showToast('Please enter your phone number', 'error');
        customerPhone.focus();
        return false;
    }
    if (!reservationDate.value) {
        showToast('Please select a date', 'error');
        return false;
    }
    if (!timeSlot.value || timeSlot.value === '') {
        showToast('Please select a time', 'error');
        return false;
    }
    if (!partySize.value || partySize.value < 1) {
        showToast('Please enter number of guests', 'error');
        partySize.focus();
        return false;
    }
    return true;
}

// Submit reservation
async function submitReservation(e) {
    
    if (e) e.preventDefault();
    console.log(' Submitting reservation...');

    if (!validateForm()) {
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    
    const data = {
        location_id: selectedLocationId,
        customer_name: customerName.value.trim(),
        customer_email: customerEmail.value.trim(),
        customer_phone: customerPhone.value.trim(),
        reservation_date: reservationDate.value,
        reservation_time: timeSlot.value,
        party_size: parseInt(partySize.value),
        special_requests: specialRequests.value.trim() || null
    };
    
    console.log(' Sending:', data);
    
    try {
        const response = await fetch(CREATE_RESERVATION_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        
        
        // CATCH PHP CRASHES BEFORE PARSING JSON
        if (!response.ok) {
            const rawText = await response.text();
            console.error('PHP Server Error Text:', rawText);
            showToast('Server error encountered. Check console.', 'error');
            return;
        }
        
        const result = await response.json();
        console.log(' Response:', result);
        
        if (result.success) {
            showToast('Reservation confirmed! Check your email.', 'success');
            
            // Reset form
            locationSelect.value = '';
            locationInfo.style.display = 'none';
            customerName.value = '';
            customerEmail.value = '';
            customerPhone.value = '';
            partySize.value = '';
            specialRequests.value = '';
            const today = new Date().toISOString().split('T')[0];
            reservationDate.value = today;
            timeSlot.innerHTML = '<option value="">-- Select a time --</option>';
            selectedLocationId = null;
        } else {
            showToast(result.error || 'Reservation failed', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'CONFIRM RESERVATION';
    }
}

// Toast notification
function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast ${type}`;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
