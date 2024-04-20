<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'dbconfig.php';

    // Sanitize the input (convert tenant_id to an integer to prevent SQL injection)
    $tenant_id = intval($_POST['tenant_id']);

    // Check if the tenant ID is valid
    if ($tenant_id > 0) {
        // Start a transaction
        mysqli_begin_transaction($conn);

        try {
            // Get the house number associated with the tenant
            $house_query = "SELECT house_number FROM tbl_tenants WHERE tenant_id = ?";
            $stmt = mysqli_prepare($conn, $house_query);
            mysqli_stmt_bind_param($stmt, 'i', $tenant_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $house_number = $row['house_number'];

                // Close the statement
                mysqli_stmt_close($stmt);

                // Proceed with deletion
                $delete_query = "DELETE FROM tbl_tenants WHERE tenant_id = ?";
                $stmt = mysqli_prepare($conn, $delete_query);
                mysqli_stmt_bind_param($stmt, 'i', $tenant_id);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Update the vacancy status to 'Vacant' in tbl_house_details
                    $update_query = "UPDATE tbl_house_details SET vacancy = 'Vacant' WHERE house_number = ?";
                    $stmt = mysqli_prepare($conn, $update_query);
                    mysqli_stmt_bind_param($stmt, 's', $house_number);
                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        // Tenant deleted and house status updated successfully
                        mysqli_commit($conn);
                        echo json_encode([
                            'success' => true,
                            'message' => 'Tenant deleted and house status updated to Vacant successfully'
                        ]);
                    } else {
                        // Failed to update house status
                        mysqli_rollback($conn);
                        echo json_encode([
                            'success' => false,
                            'message' => 'Tenant deleted, but failed to update house status to Vacant'
                        ]);
                    }
                } else {
                    // Failed to delete the tenant
                    mysqli_rollback($conn);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error deleting tenant: ' . mysqli_stmt_error($stmt)
                    ]);
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                // Tenant ID not found
                mysqli_rollback($conn);
                echo json_encode([
                    'success' => false,
                    'message' => 'Tenant ID not found'
                ]);
            }
        } catch (Exception $e) {
            // An error occurred; rollback the transaction
            mysqli_rollback($conn);
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    } else {
        // Invalid tenant ID
        echo json_encode([
            'success' => false,
            'message' => 'Invalid Tenant ID'
        ]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
