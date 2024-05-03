<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include the header -->
    <?php include 'header_user.php'; ?>
</head>

<body>
    <!-- Include the sidebar -->
    <?php include 'sidebar_user.php'; ?>

    <div class="content">
        <!-- Include the navbar -->
        <?php include 'navbar.php'; ?>

        <!-- Container for the main content -->
        <div class="container" style="background-color: #FEFAF6;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <!-- Title for the page -->
                    <h2 class="mt-3 mb-3" style="color: black;">Rented House</h2>
                </div>
            </div>
            <!-- Separation line -->
            <hr id="line">
        </div>

         <?php
        // Get the sessioned email
        $email = $_SESSION['email'];

        // SQL query with a condition to match tenant's email with sessioned email
        $sql = "SELECT t.house_number, t.monthly_rate, t.email, t.registration_date, h.description, h.image
                FROM tbl_tenants t
                JOIN tbl_house_details h ON t.house_number = h.house_number
                WHERE t.email = '$email'";

        $result = $conn->query($sql);

        // Check if there are any rented houses for the current tenant
        if ($result->num_rows > 0) {
            // Loop through the rented houses
            while ($row = $result->fetch_assoc()) {
        ?>
                <!-- House details card -->
                <div class="container">
                    <div class="card house-details-card mb-4">
                        <div class="row g-0">
                            <!-- House image -->
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <?php
                                // Convert the BLOB image data to a Base64-encoded string
                                $base64_image = base64_encode($row['image']);
                                ?>
                                <!-- Use the Base64-encoded string as the source for the img tag -->
                                <img src="data:image/jpeg;base64,<?php echo $base64_image; ?>" class="img-fluid rounded img-house" alt="House Image">
                            </div>

                            <!-- Details -->
                            <div class="col-md-8">
                                <div class="card-body text-center">
                                    <!-- House number -->
                                    <div class="mb-2">
                                        <strong>House Number:</strong> <span><?php echo htmlspecialchars($row['house_number']); ?></span>
                                    </div>

                                    <!-- Monthly rate -->
                                    <div class="mb-2">
                                        <strong>Monthly Rate:</strong> <span>₱ <?php echo htmlspecialchars(number_format($row['monthly_rate'], 2)); ?></span>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-2">
                                        <strong>Description:</strong>
                                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>

                                    <!-- Balance -->
                                    <div class="mb-2">
                                        <strong>Balance:</strong> <span>₱ <?php echo htmlspecialchars(number_format($row['monthly_rate'], 2)); ?></span>
                                    </div>

                                    <!-- Start date -->
                                    <div class="mb-2">
                                        <strong>Start Date:</strong> <span><?php echo htmlspecialchars(date("F d, Y", strtotime($row['registration_date']))); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            // If no rented houses found for the tenant, display a message
            echo "<div class='container text-center'><h4>No currently rented house</h4></div>";
        }
        ?>

    </div>

    <!-- Include the footer -->
    <?php include 'footer.php'; ?>

    <!-- JS scripts -->
    <script src="./assets/js/mainpage.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
