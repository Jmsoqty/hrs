<?php
// Include your database connection file
include 'dbconfig.php';

// Check if the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data from the request
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $password = $_POST['password']; // Password before hashing
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);

    // Initialize the response array
    $response = [];

    // Validate input data
    if (empty($name) || empty($username) || empty($password) || empty($usertype)) {
        $response['error'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    $query_check_username = "SELECT * FROM tbl_users WHERE username = '$username'";
    $result_check_username = mysqli_query($conn, $query_check_username);
    if (mysqli_num_rows($result_check_username) > 0) {
        $response['error'] = 'Username already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }

    // Check for email
    $query_check_email = "SELECT * FROM tbl_users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $query_check_email);
    if (mysqli_num_rows($result_check_email) > 0) {
        $response['error'] = 'Email already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }

    // Check for contact number
    $query_check_contact = "SELECT * FROM tbl_users WHERE contact_number = '$contact'";
    $result_check_contact = mysqli_query($conn, $query_check_contact);
    if (mysqli_num_rows($result_check_contact) > 0) {
        $response['error'] = 'Contact number already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }


    // Hash the password
    $hashed_password = md5($password);

    // Insert the new user data into tbl_users
    $query_insert_user = "INSERT INTO tbl_users (fullname, username, email, contact_number, password, usertype) VALUES ('$name', '$username', '$email', '$contact', '$hashed_password', '$usertype')";
    $result_insert_user = mysqli_query($conn, $query_insert_user);

    // Check if the insert operation was successful
    if ($result_insert_user) {
        $response['success'] = 'User registered successfully.';
        echo json_encode($response);
        exit();
    } else {
        // Handle database error
        $response['error'] = 'Error registering user: ' . mysqli_error($conn);
        echo json_encode($response);
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
