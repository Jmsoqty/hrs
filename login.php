<?php
session_start();
include 'api/dbconfig.php';
if (isset($_SESSION['loggedinasadmin']) && $_SESSION['loggedinasadmin'] === true) {
  header('Location: admindash.php');
  exit();
}

if (isset($_SESSION['loggedinasuser']) && $_SESSION['loggedinasuser'] === true) {
  header('Location: userdash.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>HRS | House Rental System</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/register.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <h1>HRS</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="properties.php">Property Details</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                            <li><a href="login.php" style="padding-left: 15px;">Login </a></li>
                        </ul>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Login</h2>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="username" id="username">
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" id="password">
                    <label for="password">Password</label>
                </div>
                <button type="button" id="btnSignIn" class="btn">Login</button>
        </div>
    </div>

    <script type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


        <script>
        $(document).ready(function() {
            $("#btnSignIn").click(function(event) {
                event.preventDefault(); // Prevent default form submission behavior
                signIn();
            });
        });

        function signIn() {
            var username = $("#username").val();
            var password = $("#password").val();

            var send_data = {
                username: username,
                password: password
            };

            $.ajax({
                url: "api/sign_in.php",
                type: "POST",
                data: send_data,
                dataType: "json", // Expecting JSON response
                beforeSend: function() {
                    // You can show a loading spinner or any indication that the request is being processed
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    if (response.hasOwnProperty('error')) {
                        // Display error message if 'error' property exists in response
                        Swal.fire({
                            icon: 'error',
                            title: 'Sign In Error',
                            text: response.error
                        });
                    } else if (response.hasOwnProperty('success')) {
                        // Display success message if 'success' property exists in response
                        Swal.fire({
                            icon: 'success',
                            title: 'Sign In Successful',
                            text: response.success,
                            // Redirect to dashboard if provided in response
                            didClose: () => {
                                if (response.hasOwnProperty('redirect')) {
                                    window.location.href = response.redirect;
                                }
                            }
                        });
                    }
                    // Redirect or perform any necessary action upon successful sign-in
                },
                error: function(error) {
                    // Handle error
                    console.log(error);
                }
            });
        }
        </script>
</body>

</html>