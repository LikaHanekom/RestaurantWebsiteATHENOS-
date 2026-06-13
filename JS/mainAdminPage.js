// Sidebar navigation active state behavior
const navItems = document.querySelectorAll(".nav-links li");

navItems.forEach((item, index) => {
    item.addEventListener("click", () => {
        navItems.forEach(nav => nav.classList.remove("active"));
        item.classList.add("active");
        
        // Link navigation items
        if (index === 0) {
            window.location.href = 'mainAdminPage.php';
        }
        if (index === 1) {
            window.location.href = 'manageReservations.php';
        }
        if (index === 2) {
            window.location.href = 'manageUsers.php';
        }
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

// Logout button functionality
const logoutBtn = document.querySelector('.logout-btn');
if(logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        if(confirm('Are you sure you want to logout?')) {
            window.location.href = '../Handlers/logout.php';
        }
    });
}

// Dynamic live counter fetch routine
document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardStats();
    // Refresh stats every 30 seconds
    setInterval(fetchDashboardStats, 30000);
});

async function fetchDashboardStats() {
    const todayElement = document.getElementById('statToday');
    const pendingElement = document.getElementById('statPending');
    const visitorsElement = document.getElementById('statVisitors');
    
    // Show loading state
    if(todayElement) todayElement.textContent = '...';
    if(pendingElement) pendingElement.textContent = '...';
    
    try {
        const response = await fetch('../Handlers/get_dashboard_stats.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update with real-time metrics
            if(todayElement) todayElement.textContent = result.data.today_reservations || 0;
            if(pendingElement) pendingElement.textContent = result.data.pending_reservations || 0;
            // Keep static visitors count
            if(visitorsElement && result.data.website_visitors) {
                visitorsElement.textContent = result.data.website_visitors;
            }
        } else {
            console.error('Database response structural failure:', result.error);
            if(todayElement) todayElement.textContent = '0';
            if(pendingElement) pendingElement.textContent = '0';
        }
    } catch (error) {
        console.error('Failed to aggregate real-time admin matrix data counters:', error);
        if(todayElement) todayElement.textContent = '0';
        if(pendingElement) pendingElement.textContent = '0';
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

// Add active class to current page in sidebar
function setActiveNavItem() {
    const currentPage = window.location.pathname.split('/').pop();
    const navItemsList = document.querySelectorAll(".nav-links li");
    
    navItemsList.forEach((item, index) => {
        if (currentPage === 'mainAdminPage.php' && index === 0) {
            item.classList.add('active');
        } else if (currentPage === 'manageReservations.php' && index === 1) {
            item.classList.add('active');
        } else if (currentPage === 'manageUsers.php' && index === 2) {
            item.classList.add('active');
        }
    });
}

// Call on page load
setActiveNavItem();

// Close sidebar when window is resized above mobile breakpoint
window.addEventListener('resize', function() {
    if (window.innerWidth > 900 && sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});