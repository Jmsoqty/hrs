<?php
include 'dbconfig.php';
session_start();

$username = trim($_POST['username']);
$password = $_POST['password'];

// Hash the provided password using MD5
$hashed_password = md5($password);

// Initialize an array to hold the JSON response
$response = [];

// Check user credentials
$query_users = "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$hashed_password'";
$result_users = mysqli_query($conn, $query_users);

if (mysqli_num_rows($result_users) > 0) {
    // User is found, fetch user details
    $user = mysqli_fetch_assoc($result_users);
    $usertype = $user['usertype']; // Assume the `usertype` field indicates the user type

    // Set session variables based on user type
    $_SESSION['username'] = $username;
    $_SESSION['usertype'] = $usertype;

    // Redirect based on user type
    if ($usertype === 'admin') {
        $_SESSION['loggedinasadmin'] = true;
        $response['success'] = 'Sign In Successful';
        $response['redirect'] = 'admindash.php';
    } elseif ($usertype === 'client') {
        $_SESSION['loggedinasuser'] = true;
        $_SESSION['email'] = $user['email'];
        $response['success'] = 'Sign In Successful';
        $response['redirect'] = 'userdash.php';
    } elseif ($usertype === 'staff') {
        $_SESSION['loggedinasstaff'] = true;
        $response['success'] = 'Sign In Successful';
        $response['redirect'] = 'staffdash.php';
    } else {
        // If the usertype is not recognized, handle the error
        $response['error'] = 'Unrecognized user type';
        echo json_encode($response);
        exit();
    }

    // Return success response
    echo json_encode($response);
    exit();
}

// If no user is found
$response['error'] = 'Invalid username or password';
echo json_encode($response);
exit();
?>
