<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos Admin Dashboard</title>

    <link rel="stylesheet" href="mainAdminPage.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Open+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

<div class="dashboard-container">

    <!-- Sidebar -->
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
                <li class="active">Dashboard</li>
                <li>Reservations</li>
                <li>Website Content</li>
                <li>Users</li>
                <li>Settings</li>
            </ul>
        </nav>

        <button class="logout-btn">Logout</button>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Topbar -->
        <header class="topbar">

            <div>
                <h2>Welcome Back</h2>
                <p class="subtitle">Manage your restaurant website and reservations</p>
            </div>

            <div class="admin-profile">
                <div class="profile-circle">A</div>
            </div>

        </header>

        <!-- Hero Banner -->
        <section class="hero-banner">

            <div class="overlay"></div>

            <div class="hero-content">
                <h1>Luxury Mediterranean Dining Experience</h1>

                <p>
                    Easily manage reservations, website content,
                    and customer experiences from one place.
                </p>

                <button class="hero-btn">
                    View Website
                </button>
            </div>

        </section>

        <!-- Stats -->
        <section class="stats-section">

            <div class="stat-card">
                <h3>Today's Reservations</h3>
                <p id="statToday">0</p>
            </div>

            <div class="stat-card">
                <h3>Pending Requests</h3>
                <p id="statPending">0</p>
            </div>

            <div class="stat-card">
                <h3>Website Visitors</h3>
                <p id="statVisitors">1,284</p>
            </div>

        </section>

        <!-- Quick Actions -->
        <section class="quick-actions">

            <div class="section-header">
                <h2>Quick Actions</h2>
            </div>

            <div class="actions-grid">

                <div class="action-card">
                    <h3>Manage Reservations</h3>
                    <p>Approve, cancel or view customer bookings.</p>

                    <button onclick="window.location.href='manageReservations.php'">Open</button>
                </div>

                <div class="action-card">
                    <h3>Edit Homepage</h3>
                    <p>Update welcome text and homepage images.</p>

                    <button>Edit</button>
                </div>

                <div class="action-card">
                    <h3>Manage Gallery</h3>
                    <p>Upload and organize restaurant photos.</p>

                    <button>Manage</button>
                </div>

            </div>

        </section>

    </main>

</div>

<script src="mainAdminPage.js"></script>

</body>
</html>