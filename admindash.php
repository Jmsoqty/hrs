<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body> 
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <?php include 'navbar.php'; ?>

        <div class="container" style="background-color: #FEFAF6;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <h2 class="mt-3 mb-3" style="color: black;">Admin Dashboard</h2>
                </div>
            </div>
            <hr id="line"> <!-- Separation line -->

            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <i class="fas fa-home fa-3x mb-3"></i>
                            <h5 class="card-title">Total Houses</h5>
                            <p class="card-text">100</p>
                            <a href="pendingbookings.php" class="btn btn-primary">View List</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h5 class="card-title">Total Tenants</h5>
                            <p class="card-text">500</p>
                            <a href="tenantdetails.php" class="btn btn-primary">View List</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <i class="fas fa-money-bill-alt fa-3x mb-3"></i>
                            <h5 class="card-title">Monthly Earnings</h5>
                            <p class="card-text">$10,000</p> <!-- Replace $10,000 with your actual monthly earnings -->
                            <a href="#" class="btn btn-primary">View Details</a> <!-- You can link this button to a page displaying detailed monthly earnings if needed -->
                        </div>
                    </div>
                </div>

            </div> <!-- /.row -->
        </div> <!-- /.content-container -->
    </div>
    <?php include 'footer.php'; ?>

    <script src="./assets/js/mainpage.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
