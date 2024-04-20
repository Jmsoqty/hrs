<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Get the house number from the request
$houseNum = mysqli_real_escape_string($conn, $_POST['houseNum']);

// Fetch monthly rate for the house number
$query = "SELECT price FROM tbl_house_details WHERE house_number = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind parameter
mysqli_stmt_bind_param($stmt, 's', $houseNum);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $response['success'] = true;
    $response['monthly_rate'] = $row['price'];
} else {
    $response['error'] = 'Failed to fetch house rate';
}

// Close database connection
mysqli_close($conn);

// Output the response as JSON
echo json_encode($response);
?>
