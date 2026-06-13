const FETCH_RESERVATIONS_URL = '../Handlers/get_admin_reservations.php';

document.addEventListener('DOMContentLoaded', function() {
    console.log('Reservation Manager Core Online.');
    fetchReservations();
    setInterval(fetchReservations, 30000);
    
    // Wire up sidebar redirect linkages
    const navItems = document.querySelectorAll(".nav-links li");
    navItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            if(index === 0) window.location.href = 'mainAdminPage.php';
        });
    });
});

// Sidebar toggle 
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.querySelector('.sidebar');

if(menuToggle){
    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.toggle('active');
    });
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    if (window.innerWidth <= 900 && sidebar && sidebar.classList.contains('active')) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    }
});

// Close sidebar when window is resized above mobile breakpoint
window.addEventListener('resize', function() {
    if (window.innerWidth > 900 && sidebar && sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});

// Logout button
const logoutBtn = document.querySelector('.logout-btn');
if(logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        if(confirm('Are you sure you want to logout?')) {
            window.location.href = '../Handlers/logout.php';
        }
    });
}

// Primary data aggregation engine
async function fetchReservations() {
    const tableBody = document.getElementById('reservationsTableBody');
    
    try {
        const response = await fetch(FETCH_RESERVATIONS_URL);
        const rawText = await response.text();
        console.log("RAW SERVER RESPONSE:", rawText);
        
        // Try to parse JSON
        let result;
        try {
            result = JSON.parse(rawText);
        } catch(e) {
            console.error("JSON Parse error:", e);
            tableBody.innerHTML = `<tr><td colspan="7" class="loading-text" style="color: red;">Error parsing server response</td></tr>`;
            return;
        }
        
        if (!result.success) {
            tableBody.innerHTML = `<tr><td colspan="7" class="loading-text" style="color: red;">Error: ${result.error}</td></tr>`;
            return;
        }
        
        const bookings = result.data;
        if (bookings.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="loading-text">No reservations found in database.</td></tr>`;
            return;
        }
        
        tableBody.innerHTML = '';
        
        bookings.forEach(booking => {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>
                    <strong>${escapeHTML(booking.customer_name || 'Guest User')}</strong><br>
                    <small>${escapeHTML(booking.customer_email || 'N/A')}</small><br>
                    <small>Tel: ${escapeHTML(booking.customer_phone || 'N/A')}</small>
                 </td>
                <td>${escapeHTML(booking.location_name || 'Unknown Location')}</td>
                <td>
                    <strong>${booking.reservation_date}</strong><br>
                    <small>${booking.reservation_time}</small>
                 </td>
                <td>${booking.party_size}</td>
                <td>${escapeHTML(booking.special_requests || 'None')}</td>
                <td>
                    <span class="status-badge status-${booking.status.toLowerCase()}">
                        ${booking.status}
                    </span>
                 </td>
                <td>
                    <div class="action-btns">
                        ${booking.status === 'pending' ? `
                            <button class="btn-table btn-approve" onclick="updateStatus(${booking.reservation_id}, 'confirmed')">
                                ✓ Approve
                            </button>
                            <button class="btn-table btn-reject" onclick="updateStatus(${booking.reservation_id}, 'cancelled')">
                                ✗ Cancel
                            </button>
                        ` : `
                            <small style="color:#999; display:block; margin-bottom:5px;">Status: ${booking.status}</small>
                        `}
                        <button class="btn-table btn-delete" onclick="deleteReservation(${booking.reservation_id})">
                            🗑 Delete
                        </button>
                    </div>
                 </td>
            `;
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error('Data pipeline failure:', error);
        tableBody.innerHTML = `<tr><td colspan="7" class="loading-text" style="color: red;">Failed to load reservations. Please try again.</td></tr>`;
    }
}

// Update reservation status
async function updateStatus(id, targetStatus) {
    if(!confirm(`Are you sure you want to mark reservation #${id} as ${targetStatus.toUpperCase()}?`)) return;
    
    try {
        const response = await fetch(FETCH_RESERVATIONS_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                reservation_id: id, 
                status: targetStatus,
                action: 'update_status'
            })
        });
        
        const result = await response.json();
        if(result.success) {
            showToast(`Reservation #${id} marked as ${targetStatus}`, 'success');
            fetchReservations(); // Refresh table
        } else {
            alert('Failed to update: ' + result.error);
            showToast('Update failed: ' + result.error, 'error');
        }
    } catch(err) {
        console.error('State process fault:', err);
        alert('Network failure occurred while updating status.');
    }
}

// Delete reservation
async function deleteReservation(id) {
    if (!confirm(`Are you sure you want to DELETE reservation #${id}? This action cannot be undone.`)) return;

    try {
        const response = await fetch(FETCH_RESERVATIONS_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                reservation_id: id,
                action: 'delete'
            })
        });

        const result = await response.json();

        if (result.success) {
            showToast(`Reservation #${id} deleted successfully`, 'success');
            fetchReservations(); // refresh table
        } else {
            alert('Delete failed: ' + result.error);
            showToast('Delete failed: ' + result.error, 'error');
        }

    } catch (err) {
        console.error('Delete error:', err);
        alert('Network error while deleting reservation.');
    }
}

// Toast notification function
function showToast(message, type) {
    // Remove existing toast if any
    const existingToast = document.querySelector('.toast-notification');
    if(existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <span>${type === 'success' ? '✓' : '✗'}</span>
        <span>${message}</span>
    `;
    toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 12px 24px;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1000;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Add animation styles if not present
if(!document.querySelector('#toast-styles')) {
    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
}

// Prevent cross site scripting string injection attacks
function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
}