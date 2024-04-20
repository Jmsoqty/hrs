<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Fetch house details from the database
$query = "SELECT house_number AS houseNum, description AS houseDetail FROM tbl_house_details WHERE vacancy = 'Vacant'";
$result = $conn->query($query);

if ($result) {
    $houses = [];
    while ($row = $result->fetch_assoc()) {
        $houses[] = [
            'houseNum' => $row['houseNum'],
            'houseDetail' => $row['houseDetail']
        ];
    }
    $response['success'] = true;
    $response['houses'] = $houses;
} else {
    $response['error'] = 'Failed to fetch house details: ' . $conn->error;
}

// Close database connection
mysqli_close($conn);

// Output the response as JSON
echo json_encode($response);
?>
