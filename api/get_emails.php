<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Define the query to fetch emails from `tbl_users` where the usertype is 'client' 
// and emails are not present in `tbl_tenants`
$query = "
    SELECT email 
    FROM tbl_users
    WHERE usertype = 'client' 
    AND email NOT IN (
        SELECT email
        FROM tbl_tenants
    )
";

$result = $conn->query($query);

if ($result) {
    // Initialize an array to store the emails
    $emails = [];
    while ($row = $result->fetch_assoc()) {
        // Add each email to the array
        $emails[] = $row['email'];
    }
    
    // If emails were fetched successfully, set success response
    $response['success'] = true;
    $response['emails'] = $emails;
} else {
    // There was an error executing the query
    $response['success'] = false;
    $response['error'] = 'Failed to fetch emails: ' . $conn->error;
}

// Close the database connection
mysqli_close($conn);

// Output the response as JSON
echo json_encode($response);
?>
