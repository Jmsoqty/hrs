<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Check if the request is made using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the house number from the request
    $houseNum = mysqli_real_escape_string($conn, $_POST['houseNum']);

    // Check if house number exists
    $checkQuery = "SELECT * FROM tbl_house_details WHERE house_number = '$houseNum'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) === 0) {
        // House number does not exist
        $response['error'] = 'House number does not exist.';
        echo json_encode($response);
        exit();
    }

    // Prepare the SQL query to delete house details
    $query = "DELETE FROM tbl_house_details WHERE house_number = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the house number parameter
    mysqli_stmt_bind_param($stmt, "s", $houseNum);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = 'House detail deleted successfully.';
    } else {
        $response['error'] = 'Failed to delete house detail: ' . mysqli_stmt_error($stmt);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
    
    // Output the response as JSON
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
