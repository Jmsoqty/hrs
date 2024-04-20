<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header_user.php'; ?>
</head>
<body> 
    <?php include 'sidebar_user.php'; ?>

    <div class="content">
        <?php include 'navbar.php'; ?>

        <div class="container" style="background-color: #FEFAF6;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <h2 class="mt-3 mb-3" style="color: black;">User Dashboard</h2>
                </div>
            </div>
            <hr id="line"> <!-- Separation line -->
        <?php
        // Fetch total houses count from tbl_house_details
        $house_query = "SELECT COUNT(*) AS total_houses FROM tbl_house_details";
        $house_result = mysqli_query($conn, $house_query);
        $house_data = mysqli_fetch_assoc($house_result);
        $total_houses = $house_data['total_houses'];

        // Fetch total tenants count from tbl_tenants
        $tenant_query = "SELECT COUNT(*) AS total_tenants FROM tbl_tenants";
        $tenant_result = mysqli_query($conn, $tenant_query);
        $tenant_data = mysqli_fetch_assoc($tenant_result);
        $total_tenants = $tenant_data['total_tenants'];
        ?>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <i class="fas fa-home fa-3x mb-3"></i>
                            <h5 class="card-title">Total Houses</h5>
                            <p class="card-text"><?php echo $total_houses; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h5 class="card-title">Total Tenants</h5>
                            <p class="card-text"><?php echo $total_tenants; ?></p>
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


    </script>

</body>
</html>
