<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Get the email from the request
$email = mysqli_real_escape_string($conn, $_POST['email']);

// Fetch tenant details from the database
$query = "SELECT fullname, contact_number FROM tbl_users WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind parameter
mysqli_stmt_bind_param($stmt, 's', $email);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $response['success'] = true;
    $response['fullname'] = $row['fullname'];
    $response['contact_number'] = $row['contact_number'];
} else {
    $response['error'] = 'Failed to fetch tenant details';
}

// Close database connection
mysqli_close($conn);

// Output the response as JSON
echo json_encode($response);
?>
