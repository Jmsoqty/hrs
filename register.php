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
                            <li><a href="register.php">Login </a></li>
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
            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" id="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" id="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember Me</label>
                    <a href="#"> Forgot Password? </a>
                </div>
                <button type="button" id="btnSubmit" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="login.php" class="register-link">Register</a>
                </div>

        </div>
    </div>

    <script type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        $(document).ready(function () {
            $('#btnSubmit').click(function () {
                username = $('#email').val();
                userpass = $('#password').val();
                if (username == "" || userpass == "") {
                    Swal.fire({
                        title: "Error!",
                        text: "Please Enter Username or Password",
                        icon: "error"
                    });
                    return;
                }
                if (username == "") {
                    $('#msg').html('Please Enter Username');
                    return;
                }
                if (userpass == "") {
                    $('#msg').html('Please Enter Password');
                    return;
                }
                Login_Account('qwerty123', username, userpass);
            });
        });

        function Login_Account(token, user, pass) {
            var send_data = {
                'token': token,
                'username': user,
                'password': pass
            };

            $.ajax({
                url: "login_api.php",
                type: "POST",
                data: send_data,
                beforeSend: function () {},
                success: function (rs) {
                    if (rs == "Login Success!") {
                        Swal.fire({
                            title: "Welcome!",
                            text: "Login Successful!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "admindash.php";
                            }
                        });
                    } else {
                        // Display alert for incorrect username or password
                        if (username == "") {
                            $('#msg').html('Incorrect username');
                        } else {
                            $('#msg').html('Incorrect password');
                        }
                        Swal.fire({
                            title: "Error!",
                            text: "Incorrect username or password!",
                            icon: "error"
                        });
                    }
                },
                async: true,
                error: function (e) {
                    console.log(e);
                },
                cache: false,
            });
        }
    </script>
</body>

</html>