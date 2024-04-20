<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $houseNum = mysqli_real_escape_string($conn, $_POST['housenum']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Check if house number exists
    $checkQuery = "SELECT * FROM tbl_house_details WHERE house_number = '$houseNum'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) === 0) {
        // House number does not exist
        $response['error'] = 'House number does not exist.';
        echo json_encode($response);
        exit();
    }

    // Prepare the SQL query and statement
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        // Read the file and store it as a blob
        $avatarBlob = file_get_contents($_FILES['avatar']['tmp_name']);
        // Update query with image
        $query = "UPDATE tbl_house_details SET category = ?, description = ?, price = ?, image = ? WHERE house_number = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssdss", $category, $description, $price, $avatarBlob, $houseNum);
    } else {
        // Update query without image
        $query = "UPDATE tbl_house_details SET category = ?, description = ?, price = ? WHERE house_number = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssds", $category, $description, $price, $houseNum);
    }

    // Execute the update statement
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = 'House detail updated successfully.';
    } else {
        $response['error'] = 'Failed to update house detail: ' . mysqli_stmt_error($stmt);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
    
    // Output the response as JSON
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
