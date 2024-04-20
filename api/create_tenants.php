<?php
// Include database connection
include 'dbconfig.php';

// Initialize response array
$response = [];

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $houseNum = mysqli_real_escape_string($conn, $_POST['houseNum']);
    $monthlyRate = mysqli_real_escape_string($conn, $_POST['monthlyRate']);
    $registrationDate = mysqli_real_escape_string($conn, $_POST['registrationDate']);

    // Validate input data
    if (empty($email) || empty($fullname) || empty($contact) || empty($houseNum) || empty($monthlyRate) || empty($registrationDate)) {
        $response['error'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    // Check if email already exists in the tenants table
    $checkQuery = "SELECT * FROM tbl_tenants WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $response['error'] = 'Email already exists in the tenants table.';
        echo json_encode($response);
        exit();
    }

    // Generate a random transaction ID
    $transactionId = uniqid();

    // Prepare the SQL query to insert tenant details
    $insertQuery = "INSERT INTO tbl_tenants (email, fullname, contact, house_number, monthly_rate, registration_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'sssids', $email, $fullname, $contact, $houseNum, $monthlyRate, $registrationDate);

    // Execute the insert statement
    if (mysqli_stmt_execute($stmt)) {
        // Tenant added successfully

        // Insert the payment into tbl_payments
        $paymentQuery = "INSERT INTO tbl_payments (transaction_id, tenant_email, house_number, paid_amount, date_paid) VALUES (?, ?, ?, ?, NOW())";
        $paymentStmt = mysqli_prepare($conn, $paymentQuery);
        mysqli_stmt_bind_param($paymentStmt, 'ssds', $transactionId, $email, $houseNum, $monthlyRate);
        mysqli_stmt_execute($paymentStmt);
        mysqli_stmt_close($paymentStmt);

        // Update the vacancy status in `tbl_house_details` to 'Occupied'
        $updateHouseQuery = "UPDATE tbl_house_details SET vacancy = 'Occupied' WHERE house_number = ?";
        $updateStmt = mysqli_prepare($conn, $updateHouseQuery);
        mysqli_stmt_bind_param($updateStmt, 's', $houseNum);
        mysqli_stmt_execute($updateStmt);

        // Check if the update was successful
        if (mysqli_stmt_affected_rows($updateStmt) > 0) {
            $response['success'] = 'Tenant added and house status updated successfully.';
        } else {
            $response['error'] = 'Tenant added, but failed to update house status.';
        }

        // Close the update statement
        mysqli_stmt_close($updateStmt);
    } else {
        $response['error'] = 'Failed to add tenant: ' . mysqli_stmt_error($stmt);
    }

    // Close the insert statement
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);

// Output the response as JSON
echo json_encode($response);
?>
