<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Sync</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <!-- Navigation Links -->
        <nav class="nav-links" >
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="report/report_lost.html">Report Lost Item</a></li>
                <li><a href="report/report_found.html">Report Found Item</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <!-- Logo -->
        <div class="logo-container">
            <img src="logo.png" alt="Lost Sync Logo" class="logo">
        </div>
        <div class="heading"><h1><u>Lost Sync</u> 😎</h1></div>
        <!-- Hamburger Menu -->
        <div class="menu-icon" >
            <div></div>
            <div></div>
            <div></div>
        </div>
        <!-- profile Circle -->
        <div class="header-right">
            <div class="profile-circle" id="profile-circle">
                <?php
                    if(isset($_SESSION['full_name']) && !empty($_SESSION['full_name'])){
                        echo
                        strtoupper($_SESSION['full_name'][0]);
                    }
                    else{
                        echo "S";
                    }
                ?>
            </div>

            <div class="dropdown-menu" id="dropdown-menu">
                <ul>
                    <li><a href="#change dp">Change DP</a></li>
                    <li><a href="#edit-profile">Edit profile</a></li>
                    <li><a href="#my-contribution">My Contributuions</a></li>
                    <li><a href="#logout">Logut</a></li>
                </ul>
            </div>
        </div>

    </header>

    <!-- Hero Section -->
     <section class="hero">

        <div class="hero-content">
            <h1>
                Reconnect with what's Your's
            </h1>

            <p>
                Your lost items just a sync away.
            </p>

            <div class="cta-buttons" >
                <a href="report/report_lost.html">Report Lost Item</a>
                <a href="report/report_found.html">Report Found Items</a>
            </div>
        </div>

     </section>

     <!-- Footer -->
      <footer>
        <p>
            &copy; 2024 Lost Sync . All Rights Reserved
        </p>
      </footer>
      <script src="scripthome.js"></script>
</body>
</html>