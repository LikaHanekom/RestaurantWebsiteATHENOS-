// Sidebar navigation active state behavior
const navItems = document.querySelectorAll(".nav-links li");

navItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        navItems.forEach(nav => nav.classList.remove("active"));
        item.classList.add("active");
        
        // Link the Reservations navigation item directly to your management table page
        if (index === 1) {
            window.location.href = 'manageReservations.php';
        }
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

// Dynamic live counter fetch routine
document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardStats();
});

async function fetchDashboardStats() {
    const todayElement = document.getElementById('statToday');
    const pendingElement = document.getElementById('statPending');
    
    try {
        const response = await fetch('get_dashboard_stats.php');
        const result = await response.json();
        
        if (result.success) {
            // Smoothly replace loading placeholders with absolute real-time metrics
            if(todayElement) todayElement.textContent = result.todays_reservations;
            if(pendingElement) pendingElement.textContent = result.pending_requests;
        } else {
            console.error('Database response structural failure:', result.error);
        }
    } catch (error) {
        console.error('Failed to aggregate real-time admin matrix data counters:', error);
        if(todayElement) todayElement.textContent = 'Err';
        if(pendingElement) pendingElement.textContent = 'Err';
    }
}

// Button Hover Animations
const actionButtons = document.querySelectorAll(".action-card button");
actionButtons.forEach(button => {
    button.addEventListener("mouseenter", () => {
        button.style.transform = "translateY(-2px)";
    });
    button.addEventListener("mouseleave", () => {
        button.style.transform = "translateY(0px)";
    });
});

// Hero Link routing
const heroBtn = document.querySelector(".hero-btn");
if (heroBtn) {
    heroBtn.addEventListener("click", () => {
        window.location.href = "../index.php";
    });
}