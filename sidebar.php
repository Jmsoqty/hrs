<?php
    // Get the current page filename
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar pe-4 pb-3 bg-secondary bg-gradient"> <!-- Add bg-dark class for background color -->
    <nav class="navbar navbar-light"> <!-- Remove bg-light class to avoid overriding the background color -->
        <a href="admindash.php" class="navbar-brand mx-4 mb-3">
            <H2 class="mt-5">HRS</H2>
            <!-- <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3> -->
        </a>
        
        <div class="navbar-nav w-100">
            <a href="admindash.php" class="nav-item nav-link <?php if($currentPage == 'admindash.php') echo 'active'; ?>"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
            <a href="housetype.php" class="nav-item nav-link <?php if($currentPage == 'housetype.php') echo 'active'; ?>"><i class="fas fa-home mr-2"></i>House Type</a>
            <a href="pendingbookings.php" class="nav-item nav-link <?php if($currentPage == 'pendingbookings.php') echo 'active'; ?>"><i class="fas fa-calendar-check mr-2"></i>House Details</a>
            <a href="tenantdetails.php" class="nav-item nav-link <?php if($currentPage == 'tenantdetails.php') echo 'active'; ?>"><i class="fas fa-users mr-2"></i>Tenant Details</a>
            <a href="paymentstatus.php" class="nav-item nav-link <?php if($currentPage == 'paymentstatus.php') echo 'active'; ?>"><i class="fas fa-money-check-alt mr-2"></i>Payment Status</a>
            <a href="createuser.php" class="nav-item nav-link <?php if($currentPage == 'createuser.php') echo 'active'; ?>"><i class="fas fa-user-circle mr-2"></i>Create User Profile</a>
            <a href="#" class="nav-item nav-link logout-btn <?php if($currentPage == 'logout.php') echo 'active'; ?>"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
        </div>
    </nav>
</div>
