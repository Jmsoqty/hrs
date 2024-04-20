<?php
// Include database connection
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

    // Check if house number already exists
    $checkQuery = "SELECT * FROM tbl_house_details WHERE house_number = '$houseNum'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // House number already exists
        $response['error'] = 'House number already exists.';
        echo json_encode($response);
        exit();
    }

    // Handle the uploaded image file
    $avatarBlob = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        // Read the file and store it as a blob
        $avatarBlob = file_get_contents($_FILES['avatar']['tmp_name']);
    }

    // Validate input data
    if (empty($houseNum) || empty($category) || empty($description) || empty($price)) {
        $response['error'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    // Prepare the statement for inserting data into the database
    $stmt = mysqli_prepare($conn, "INSERT INTO tbl_house_details (house_number, category, description, price, image) VALUES (?, ?, ?, ?, ?)");

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssds", $houseNum, $category, $description, $price, $avatarBlob);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = 'House detail saved successfully.';
    } else {
        $response['error'] = 'Failed to save house detail: ' . mysqli_stmt_error($stmt);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
    
    // Output the response as JSON
    echo json_encode($response);
    exit();
}

// Close database connection
mysqli_close($conn);
?>
