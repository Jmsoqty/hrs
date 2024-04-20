<?php
    // Get the current page filename
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar pe-4 pb-3 bg-secondary bg-gradient"> <!-- Add bg-dark class for background color -->
    <nav class="navbar navbar-light"> <!-- Remove bg-light class to avoid overriding the background color -->
        <a href="userdash.php" class="navbar-brand mx-4 mb-3">
            <H2 class="mt-5">HRS</H2>
            <!-- <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3> -->
        </a>
        
        <div class="navbar-nav w-100">
            <a href="userdash.php" class="nav-item nav-link <?php if($currentPage == 'userdash.php') echo 'active'; ?>"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
            <a href="e-wallet.php" class="nav-item nav-link <?php if($currentPage == 'e-wallet.php') echo 'active'; ?>"><i class="fas fa-wallet mr-2"></i>E-wallet</a>
            <a href="transactions.php" class="nav-item nav-link <?php if($currentPage == 'transactions.php') echo 'active'; ?>"><i class="fas fa-calendar-check mr-2"></i>Transactions</a>
            <a href="rented_house.php" class="nav-item nav-link <?php if($currentPage == 'rented_house.php') echo 'active'; ?>"><i class="fas fa-users mr-2"></i>Rented House</a>
            <a href="api/logout.php" class="nav-item nav-link logout-btn"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
        </div>
    </nav>
</div>
