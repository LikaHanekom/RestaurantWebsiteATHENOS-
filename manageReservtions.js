const FETCH_RESERVATIONS_URL = 'get_admin_reservations.php';

document.addEventListener('DOMContentLoaded', function() {
    console.log('Reservation Manager Core Online.');
    fetchReservations();
    setInterval(fetchReservations, 30000);
    
    // Wire up sidebar redirect linkages
    const navItems = document.querySelectorAll(".nav-links li");
    navItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            if(index === 0) window.location.href = 'mainAdminPage.phpl'; // Points back to the dashboard layout
        });
    });
});


//sidebar toggle 
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.querySelector('.sidebar');

if(menuToggle){
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
}

// Primary data aggregation engine
async function fetchReservations() {
    const tableBody = document.getElementById('reservationsTableBody');
    
    try {
        const response = await fetch(FETCH_RESERVATIONS_URL);

        const rawText = await response.text();

        console.log("RAW SERVER RESPONSE:");
        console.log(rawText);

        const result = JSON.parse(rawText);
                
        if (!result.success) {
            tableBody.innerHTML = `<tr><td colspan="7" class="loading-text" style="color: red;">Error: ${result.error}</td></tr>`;
            return;
        }
        
        const bookings = result.data;
        if (bookings.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="loading-text">No reservations found in database.</td></tr>`;
            return;
        }
        
        tableBody.innerHTML = ''; // Wipe loading row template structural elements
        
        bookings.forEach(booking => {
            const row = document.createElement('tr');
            
            // Build dynamic text nodes for validation
            row.innerHTML = `
                <td>User ${booking.user_id ?? 'Guest'}</td>

                <td>${booking.location_name}</td>

                <td>
                    <strong>${booking.customer_name ?? 'Guest User'}</strong><br>
                    <small>${booking.customer_email ?? 'N/A'}</small>
                </td>

                <td>
                    <strong>${booking.reservation_date}</strong><br>
                    <small>${booking.reservation_time}</small>
                </td>

                <td>${booking.party_size}</td>

                <td>-</td>

                <td>
                    <span class="status-badge status-${booking.status.toLowerCase()}">
                        ${booking.status}
                    </span>
                </td>

                <td>
                    <div class="action-btns">

                        ${booking.status === 'pending' ? `
                            <button class="btn-table btn-approve"
                                onclick="updateStatus(${booking.reservation_id}, 'confirmed')">
                                Approve
                            </button>

                            <button class="btn-table btn-reject"
                                onclick="updateStatus(${booking.reservation_id}, 'cancelled')">
                                Cancel
                            </button>
                        ` : `
                            <small style="color:#999;">Resolved</small>
                        `}

                        <!-- DELETE BUTTON (always visible) -->
                        <button class="btn-table btn-delete"
                            onclick="deleteReservation(${booking.reservation_id})">
                            Delete
                        </button>

                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error('Data pipeline failure:', error);
        tableBody.innerHTML = `<tr><td colspan="7" class="loading-text" style="color: red;">Failed to parse data server payloads.</td></tr>`;
    }
}

// Transaction structural logic state update
async function updateStatus(id, targetStatus) {
    if(!confirm(`Are you sure you want to mark reservation #${id} as ${targetStatus}?`)) return;
    
    try {
        const response = await fetch(FETCH_RESERVATIONS_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ reservation_id: id, status: targetStatus })
        });
        
        const result = await response.json();
        if(result.success) {
            fetchReservations(); // Refresh records matrix tracking elements cleanly
        } else {
            alert('Failed to update: ' + result.error);
        }
    } catch(err) {
        console.error('State process fault:', err);
        alert('Network failure occurred changing system structural metrics.');
    }
}

async function deleteReservation(id) {
    if (!confirm(`Are you sure you want to DELETE reservation #${id}? This cannot be undone.`)) return;

    try {
        const response = await fetch('get_admin_reservations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                reservation_id: id,
                action: 'delete'
            })
        });

        const result = await response.json();

        if (result.success) {
            fetchReservations(); // refresh table
        } else {
            alert('Delete failed: ' + result.error);
        }

    } catch (err) {
        console.error('Delete error:', err);
        alert('Network error while deleting reservation.');
    }
}

// Prevent cross site scripting string injection attacks inside data table view rendering blocks
function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}