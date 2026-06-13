// API URLs
const GET_LOCATIONS_URL = '../Handlers/get_locations.php';
const CREATE_RESERVATION_URL = '../Handlers/create_reservation.php';
const GET_AVAILABLE_TIMES_URL = '../Handlers/get_available_times.php';

let locationsData = [];
let selectedLocationId = null;

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded');
    
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
    
    // Initialize time dropdown
    timeSlot.innerHTML = '<option value="">-- Select a location and date first --</option>';
    timeSlot.disabled = true;
    
    // Load locations
    loadLocations();
    
    // Setup event listeners
    locationSelect.addEventListener('change', onLocationChange);
    reservationDate.addEventListener('change', onDateChange);
    submitBtn.addEventListener('click', submitReservation);
    
    // Close button
    const closeBtn = document.querySelector(".close-btn");
    if (closeBtn) {
        closeBtn.addEventListener("click", function(e) {
            e.preventDefault();
            window.location.href = "index.php";
        });
    }
});

// Function to fetch available time slots from server
async function fetchAvailableTimeSlots(locationId, date) {
    try {
        const url = `${GET_AVAILABLE_TIMES_URL}?location_id=${locationId}&date=${date}`;
        console.log('Fetching available times from:', url);
        
        const response = await fetch(url);
        const data = await response.json();
        
        console.log('Available times response:', data);
        
        if (data.success) {
            return data.available_times;
        } else {
            console.error('Error fetching available times:', data.error);
            return [];
        }
    } catch (error) {
        console.error('Network error:', error);
        return [];
    }
}

// Function to populate time slots (only showing available ones)
async function populateTimeSlots() {
    if (!selectedLocationId || !reservationDate.value) {
        timeSlot.innerHTML = '<option value="">-- Select location and date first --</option>';
        timeSlot.disabled = true;
        return;
    }
    
    console.log('Checking availability for location:', selectedLocationId, 'date:', reservationDate.value);
    
    // Show loading state
    timeSlot.innerHTML = '<option value="">Checking availability...</option>';
    timeSlot.disabled = true;
    
    // Fetch available time slots from server
    const availableTimes = await fetchAvailableTimeSlots(selectedLocationId, reservationDate.value);
    
    // Clear dropdown
    timeSlot.innerHTML = '';
    
    if (!availableTimes || availableTimes.length === 0) {
        timeSlot.innerHTML = '<option value="">No available time slots for this date</option>';
        timeSlot.disabled = true;
        return;
    }
    
    // Add available time slots
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-- Select a time --';
    timeSlot.appendChild(defaultOption);
    
    for (let i = 0; i < availableTimes.length; i++) {
        const option = document.createElement('option');
        option.value = availableTimes[i];
        option.textContent = availableTimes[i];
        timeSlot.appendChild(option);
    }
    
    timeSlot.disabled = false;
    console.log('Available times:', availableTimes);
}

// Load locations from database
async function loadLocations() {
    try {
        console.log('Fetching locations...');
        const response = await fetch(GET_LOCATIONS_URL);
        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        locationsData = data;
        locationSelect.innerHTML = '<option value="">-- Choose a restaurant --</option>';
        
        for (let i = 0; i < locationsData.length; i++) {
            const option = document.createElement('option');
            option.value = locationsData[i].location_id;
            option.textContent = `${locationsData[i].location_name} (${locationsData[i].province})`;
            locationSelect.appendChild(option);
        }
        console.log('Loaded', locationsData.length, 'locations');
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
    
    if (!id) {
        locationInfo.style.display = 'none';
        timeSlot.innerHTML = '<option value="">-- Select a location first --</option>';
        timeSlot.disabled = true;
        return;
    }
    
    let location = null;
    for (let i = 0; i < locationsData.length; i++) {
        if (locationsData[i].location_id === id) {
            location = locationsData[i];
            break;
        }
    }
    
    if (location) {
        addressSpan.textContent = location.address;
        phoneSpan.textContent = location.phone;
        emailSpan.textContent = location.email;
        phoneLink.href = 'tel:' + location.phone.replace(/\D/g, '');
        emailLink.href = 'mailto:' + location.email;
        locationInfo.style.display = 'block';
        
        // Check availability for selected date
        if (reservationDate.value) {
            populateTimeSlots();
        } else {
            timeSlot.innerHTML = '<option value="">-- Select a date --</option>';
            timeSlot.disabled = true;
        }
    }
}

function onDateChange() {
    if (selectedLocationId && reservationDate.value) {
        populateTimeSlots();
    } else if (selectedLocationId && !reservationDate.value) {
        timeSlot.innerHTML = '<option value="">-- Select a date --</option>';
        timeSlot.disabled = true;
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
    if (!timeSlot.value) {
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
    console.log('Submitting reservation...');

    if (!validateForm()) {
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    
    // Make sure selectedLocationId is a number
    const locationId = parseInt(selectedLocationId);
    
    const reservationData = {
        location_id: locationId,
        customer_name: customerName.value.trim(),
        customer_email: customerEmail.value.trim(),
        customer_phone: customerPhone.value.trim(),
        reservation_date: reservationDate.value,
        reservation_time: timeSlot.value,
        party_size: parseInt(partySize.value),
        special_requests: specialRequests.value.trim() || null
    };
    
    console.log('Sending data:', reservationData);
    
    try {
        const response = await fetch(CREATE_RESERVATION_URL, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(reservationData)
        });
        
        const result = await response.json();
        console.log('Server response:', result);
        
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
            timeSlot.innerHTML = '<option value="">-- Select a location first --</option>';
            timeSlot.disabled = true;
            selectedLocationId = null;
        } else {
            showToast(result.error || 'Reservation failed', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Network error. Try again later.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'CONFIRM RESERVATION';
    }
}

function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast ${type}`;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}