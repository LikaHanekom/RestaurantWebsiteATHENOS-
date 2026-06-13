# Athenos Restaurant Website

## User Manual

### System Overview

The Athenos Restaurant Website is a dynamic web application developed using HTML, CSS, JavaScript, PHP, and MySQL. The system allows customers to browse restaurant information, view menu items, make reservations, and contact the restaurant. Administrators can manage reservations and monitor website activity through an admin dashboard.

---

## System Requirements

### Software Requirements

- Google Chrome, Microsoft Edge, Firefox, or Safari
- WAMP/XAMPP Server (for local development)
- MySQL Database
- Internet connection (for deployed version)

### Access URL

- **Local testing:** `http://localhost/RestaurantPage`
- **Live deployment:** `http://athenos-restaurant.infinityfreeapp.com`

---

## User Roles

The system contains two primary user roles:

| Role | Description |
|------|-------------|
| **Customer** | Can browse menu, make reservations, and contact the restaurant |
| **Administrator** | Can manage reservations, view statistics, and monitor website activity |

---

## Customer User Guide

### Accessing the Website

**Step 1:** Open a web browser.

**Step 2:** Navigate to: http://localhost/RestaurantPage/index.php

**Step 3:** The Home Page will load.

---

### Home Page

The Home Page provides:
- Restaurant branding
- Hero banner with rotating images
- Featured content about the restaurant
- Navigation menu
- Reservation call-to-action

**How to Use:**
1. Open the Home Page
2. Scroll through featured sections
3. Use the navigation menu to access other pages

---

### Viewing the Menu

**Step 1:** Select **Menu** from the navigation bar.

**Step 2:** Browse available menu categories (Starters, Steaks, Desserts, Beverages).

**Step 3:** View:
- Dish name
- Description
- Price
- Dietary badges (Vegan, Gluten-Free)
- Images

**Expected Result:** The user can explore all available food and beverage options.

---

### Viewing Restaurant Locations

**Step 1:** Select **Locations** from the navigation bar.

**Step 2:** Browse available restaurant branches.

**Step 3:** View:
- Branch name
- Province
- Address
- Contact details

**Expected Result:** The customer can identify the nearest restaurant branch.

---

### Making a Reservation

**Step 1:** Navigate to the **Make a Reservation** page.

**Step 2:** Complete the reservation form.

**Required information:**
- Select Location
- Date
- Time (only available time slots are shown)
- Party Size (1-20 guests)
- Full Name
- Email Address
- Phone Number
- Special Requests (optional)

**Step 3:** Click **CONFIRM RESERVATION**.

**Expected Result:** The reservation is saved in the database with status **Pending**. The reservation then becomes available for administrator review. A confirmation email is sent to the customer.

---

### Contacting the Restaurant

**Step 1:** Navigate to the **Contact Us** page.

**Step 2:** Complete the contact form.

**Required information:**
- First Name
- Last Name
- Email Address
- Mobile Number
- Query Type
- Nearest Location
- Message
- Security CAPTCHA

**Step 3:** Click **SEND**.

**Expected Result:** The inquiry is sent to the restaurant email for review.

---

## Administrator User Guide

### Administrator Login

**Default Admin Credentials:**
- Email: `admin@gmail.com`
- Password: `admin123`

**Step 1:** Navigate to the Login page: http://localhost/RestaurantPage/Views/login.php


**Step 2:** Enter Email and Password.

**Step 3:** Click **LOGIN**.

**Expected Result:** The administrator is redirected to the Admin Dashboard.

---

### Admin Dashboard

The dashboard provides an overview of restaurant activity.

**Features include:**
- Today's Reservations counter
- Pending Requests counter
- Website Visitors counter (static)
- Quick action shortcuts

**Dashboard Navigation:**
- Dashboard
- Reservations
- Users (if applicable)
- Logout

---

### Managing Reservations

**Step 1:** Select **Reservations** from the sidebar.

**Step 2:** The reservation management table will display:

| Column | Description |
|--------|-------------|
| Customer | Name, email, and phone number |
| Location | Restaurant branch name |
| Date & Time | Reservation date and time |
| Guests | Number of guests |
| Requests | Special requests (if any) |
| Status | Pending, Confirmed, or Cancelled |
| Actions | Approve, Cancel, or Delete buttons |

**Expected Result:** All reservations stored in the database are displayed.

---

### Approving a Reservation

**Step 1:** Locate a reservation with status **Pending**.

**Step 2:** Click **Approve**.

**Expected Result:** The reservation status changes to **Confirmed** and is updated in the database.

---

### Cancelling a Reservation

**Step 1:** Locate the reservation.

**Step 2:** Click **Cancel**.

**Expected Result:** The reservation status changes to **Cancelled** and the database record is updated.

---

### Deleting a Reservation

**Step 1:** Locate the reservation.

**Step 2:** Click **Delete**.

**Step 3:** Confirm the deletion.

**Expected Result:** The reservation is permanently removed from the database.

---

### Logging Out

**Step 1:** Click **Logout** from the sidebar.

**Expected Result:** The administrator session ends and the user is returned to the login page.

---

## Deployment to InfinityFree Hosting

### Prerequisites

- InfinityFree account (https://www.infinityfree.com)
- Your project files ready for upload
- Database backup (`.sql` file)

### Step 1: Create InfinityFree Account

1. Go to https://www.infinityfree.com
2. Click **Sign Up** and complete registration
3. Verify your email address

### Step 2: Create Website

1. Login to InfinityFree members area
2. Click **Create Website**
3. Choose a subdomain (e.g., `athenos-restaurant.infinityfreeapp.com`)
4. Click **Create Website**

### Step 3: Create Database

1. In cPanel, go to **MySQL Databases**
2. Create a database (e.g., `athenos_db`)
3. Create a database user with password
4. Add user to database with **ALL PRIVILEGES**

> **Note:** Your database names will have a prefix like `if0_12345678_`

### Step 4: Update Database Configuration

Update `Handlers/connection.php` with InfinityFree credentials:

```php
<?php
$servername = "sql301.infinityfree.com";
$username = "if0_12345678_username";
$password = "your_password";
$dbname = "if0_12345678_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

### Step 5: Upload Files

#### Option A - File Manager

1. In cPanel, click **File Manager**
2. Navigate to `/htdocs` folder
3. Upload and extract your project ZIP file

#### Option B - FTP (FileZilla)

1. Download [FileZilla](https://filezilla-project.org)
2. Connect using InfinityFree FTP credentials
3. Upload files to `/htdocs` folder

---

### Step 6: Import Database

1. In cPanel, click **phpMyAdmin**
2. Select your database
3. Click **Import** tab
4. Choose your `.sql` backup file
5. Click **Go**

---

### Step 7: Update Email Settings (Optional)

For contact form emails to work:

#### Option A - Use Gmail SMTP (current setup)

```php
$mail->Username = 'your_email@gmail.com';
$mail->Password = 'your_app_password';

Step 8: Test Your WebsiteHomepage	http://your-site.infinityfreeapp.com/Views/index.php
Login	http://your-site.infinityfreeapp.com/Views/login.php
Make Reservation	http://your-site.infinityfreeapp.com/Views/makeReservation.php
Contact	http://your-site.infinityfreeapp.com/Views/contactUs.php