<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Sync</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
session_start();
?>
<body>
    <!-- Header Section -->
    <header>
        <!-- Navigation Links -->
        <nav class="nav-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="report/report_lost.html">Report Lost Item</a></li>
                <li><a href="report/report_found.html">Report Found Item</a></li>
                <li><a href="report/found_items.php">Found Items</a></li>
                <li><a href="report/approved_items.php">Items Distributed</a></li>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="admin/approve_claim.php">ADMIN</a></li>
                <?php endif; ?>
                <li><a href="aboutus/aboutus.html">About Us</a></li>
                <!-- temp hta di h contact us -->
                <!-- <li><a href="#">Contact</a></li> -->
            </ul>
        </nav>
        <!-- Logo -->
        <div class="logo-container">
            <img src="logo.png" alt="Lost Sync Logo" class="logo">
        </div>
        <div class="heading"><h1><u>Lost Sync</u> 😎</h1></div>
        <!-- Hamburger Menu -->
        <div class="menu-icon">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <!-- Profile Circle -->
        <div class="header-right">
            <div class="profile-circle" id="profile-circle">
                <?php
                    if(isset($_SESSION['full_name']) && !empty($_SESSION['full_name'])){
                        echo strtoupper($_SESSION['full_name'][0]);
                    }
                    else{
                        echo "S";
                    }
                ?>
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <ul>
                    <li><a href="#">Change DP</a></li>
                    <li><a href="#">Edit Profile</a></li>
                    <li><a href="#">My Contributions</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Reconnect with what's Yours</h1>
            <p>Your lost items just a sync away.</p>
            <div class="cta-buttons">
                <a href="report/report_lost.html">Report Lost Item</a>
                <a href="report/report_found.html">Report Found Item</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Lost Sync. All Rights Reserved</p>
        <p>📧 Contact us: <a href="mailto:lostsync@example.com" target="_blank">lostsync@example.com</a></p>
    </footer>

    <script src="scripthome.js"></script>
</body>
</html>
