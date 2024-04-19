<?php
// Include the database connection file
include 'dbconfig.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user ID from the POST request
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Initialize the response array
    $response = [];

    // Perform the deletion query
    $query = "DELETE FROM tbl_users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if ($result) {
        $response['success'] = true;
    } else {
        // Handle error
        $response['error'] = 'Error deleting user: ' . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);

    // Return the response as JSON
    echo json_encode($response);
}
?>
