<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos Admin - Manage Reservations</title>
    <link rel="stylesheet" href="mainAdminPage.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Open+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    
</head>
<body>

<div class="dashboard-container">

    <button class="menu-toggle" id="menuToggle">
    ☰
    </button>
    <aside class="sidebar">
        <div class="logo-section">
            <h1>ATHENOS</h1>
            <p>Admin Panel</p>
        </div>
        <nav>
            <ul class="nav-links">
                <li onclick="window.location.href='mainAdminPage.html'">Dashboard</li>
                <li class="active">Reservations</li>
                <li>Website Content</li>
                <li>Users</li>
                <li>Settings</li>
            </ul>
        </nav>
        <button class="logout-btn">Logout</button>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h2>Manage Reservations</h2>
                <p class="subtitle">Review, approve, or cancel pending guest dinner bookings</p>
            </div>
            <div class="admin-profile">
                <div class="profile-circle">A</div>
            </div>
        </header>

        <section class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Location</th>
                        <th>Date & Time</th>
                        <th>Guests</th>
                        <th>Requests</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="reservationsTableBody">
                    <tr>
                        <td colspan="7" class="loading-text">Loading client bookings...</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</div>

<script src="manageReservtions.js"></script>
</body>
</html>