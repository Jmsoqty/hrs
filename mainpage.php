<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Side</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="assets/css/mainpage.css">
    
</head>
<body>


    <div class="row flex-nowrap">
        <div class="col-auto col-md-2 min-vh-100 sidebar">
            <div class=" p-2">
                    <a href="admindash.php" class="text-black">
                        <span class="font-weight-bold" style="font-size: 24px; display: block;">HRS</span> <!-- Adjusted font weight and size, and added display block -->
                    </a>
                <hr> <!-- Separation line -->
                <ul class="nav nav-pills flex-column mt-4">
                    <li class="nav-item">
                        <a href="admindash.php" class="nav-link text-white">
                            <i class="fas fa-tachometer-alt mr-2"></i><span class="fs-7 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="housetype.php" class="nav-link text-white" >
                            <i class="fas fa-home mr-2"></i><span class="fs-9 d-none d-sm-inline">House Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pendingbookings.php" class="nav-link text-white" >
                            <i class="fas fa-calendar-check mr-2"></i><span class="fs-7 d-none d-sm-inline">House Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="tenantdetails.php" class="nav-link text-white" >
                            <i class="fas fa-users mr-2"></i><span class="fs-7 d-none d-sm-inline">Tenant Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="paymentstatus.php" class="nav-link text-white" >
                            <i class="fas fa-money-check-alt mr-2"></i><span class="fs-7 d-none d-sm-inline">Payment Status</span>
                        </a>
                    </li>
                    <hr> <!-- Separation line -->
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white" >
                            <i class="fas fa-cogs mr-2"></i><span class="fs-7 d-none d-sm-inline">Account Settings</span>
                        </a>
                        <ul class="pl-4"> <!-- Nested list for Account Settings sub-items -->
                            <li>
                                <a href="createuser.php" class="nav-link text-white" >
                                    <i class="fas fa-user-circle mr-2"></i><span class="fs-9 d-none d-sm-inline">Create User Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <hr> <!-- Separation line -->
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white logout-link" > <!-- Added class for logout link -->
                            <i class="fas fa-sign-out-alt mr-2"></i><span class="fs-7 d-none d-sm-inline">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- SweetAlert JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="./assets/js/mainpage.js"></script>
<script>
    $(document).ready(function(){
        $('.logout-link').click(function(){
            // Use SweetAlert for logout confirmation
            swal({
                title: "Are you sure?",
                text: "You are about to log out",
                icon: "warning",
                buttons: ["Cancel", "Logout"],
                dangerMode: true,
            })
            .then((willLogout) => {
                if (willLogout) {
                    // User clicked the Logout button
                    swal("You have been logged out!", {
                        icon: "success",
                    }).then(() => {
                        // Redirect to index.php after logout confirmation
                        window.location.href = 'index.php';
                    });
                } else {
                    // User clicked the Cancel button or closed the alert
                    swal("Logout canceled!", {
                        icon: "info",
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        // Get the current page URL
        var currentUrl = window.location.href;

        // Loop through each sidebar link
        $('.sidebar a').each(function() {
            // Get the href attribute of the sidebar link
            var linkUrl = $(this).attr('href');

            // Check if the current page URL contains the sidebar link URL
            if (currentUrl.includes(linkUrl)) {
                // Remove 'active' class from all sidebar links
                $('.sidebar a').removeClass('active');
                
                // Add the 'active' class to the parent li element
                $(this).addClass('active');
            }
        });
    });
    
</script>

</body>
</html>