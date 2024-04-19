<?php
// Include your database connection file
include 'dbconfig.php';

// Check if the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input data from the request
    $userId = intval($_POST['userId']); // Use intval to ensure it is an integer
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    $password = $_POST['password']; // Password before hashing

    // Initialize the response array
    $response = [];

    // Validate input data
    if (empty($name) || empty($username) || empty($usertype)) {
        $response['error'] = 'Name, username, and user type are required fields.';
        echo json_encode($response);
        exit();
    }

    // Check for duplicate usernames (other than the current user)
    $query_check_username = "SELECT * FROM tbl_users WHERE username = '$username' AND user_id != $userId";
    $result_check_username = mysqli_query($conn, $query_check_username);
    if (mysqli_num_rows($result_check_username) > 0) {
        $response['error'] = 'Username already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }

    // Check for duplicate email (other than the current user)
    $query_check_email = "SELECT * FROM tbl_users WHERE email = '$email' AND user_id != $userId";
    $result_check_email = mysqli_query($conn, $query_check_email);
    if (mysqli_num_rows($result_check_email) > 0) {
        $response['error'] = 'Email already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }

    // Check for duplicate contact number (other than the current user)
    $query_check_contact = "SELECT * FROM tbl_users WHERE contact_number = '$contact' AND user_id != $userId";
    $result_check_contact = mysqli_query($conn, $query_check_contact);
    if (mysqli_num_rows($result_check_contact) > 0) {
        $response['error'] = 'Contact number already exists. Please choose a different one.';
        echo json_encode($response);
        exit();
    }

    // If a new password is provided, hash it
    if (!empty($password)) {
        $hashed_password = md5($password);
        // Update the user data, including the password
        $query_update_user = "UPDATE tbl_users SET fullname = '$name', username = '$username', email = '$email', contact_number = '$contact', password = '$hashed_password', usertype = '$usertype' WHERE user_id = $userId";
    } else {
        // Update the user data, but don't change the password
        $query_update_user = "UPDATE tbl_users SET fullname = '$name', username = '$username', email = '$email', contact_number = '$contact', usertype = '$usertype' WHERE user_id = $userId";
    }

    // Execute the update query
    $result_update_user = mysqli_query($conn, $query_update_user);

    // Check if the update operation was successful
    if ($result_update_user) {
        $response['success'] = 'User updated successfully.';
        echo json_encode($response);
        exit();
    } else {
        // Handle database error
        $response['error'] = 'Error updating user: ' . mysqli_error($conn);
        echo json_encode($response);
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
