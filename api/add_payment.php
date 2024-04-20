<?php
// Include the database connection
include 'dbconfig.php';

session_start();
// Initialize the response array
$response = array();

// Set the timezone to Manila
date_default_timezone_set('Asia/Manila');

// Check if the payment data is provided
if (isset($_POST['payment']) && isset($_POST['transaction_id'])) {
    // Sanitize the input
    $payment = floatval($_POST['payment']);
    $transaction_id = $_POST['transaction_id'];
    $email = $_SESSION['email'] ?? $_POST['email']; // Assuming you have a session variable for the user's email

    // Get the tenant's registration date and monthly rate from tbl_tenants
    $tenant_query = "SELECT registration_date, monthly_rate, house_number FROM tbl_tenants WHERE email = ?";
    $tenant_stmt = $conn->prepare($tenant_query);
    $tenant_stmt->bind_param("s", $email);
    $tenant_stmt->execute();
    $tenant_result = $tenant_stmt->get_result();

    if ($tenant_result->num_rows > 0) {
        $tenant_row = $tenant_result->fetch_assoc();
        $registration_date = $tenant_row['registration_date'];
        $monthly_rate = $tenant_row['monthly_rate'];
        $house_number = $tenant_row['house_number'];

        // Calculate the next due date
        $next_due_date = date('Y-m-d', strtotime('+1 month', strtotime($registration_date)));

        // Check if the current date is before the next due date
        $current_date = date('Y-m-d');
        if ($current_date < $next_due_date) {
            // Payment made before the next due date, do not process
            $response = array("success" => false, "message" => "Payment made before the next due date. Please wait until the Next due date: " . $next_due_date);
        } else {
            // Calculate the number of months to cover
            $num_months_to_cover = (strtotime($current_date) - strtotime($registration_date)) / (60 * 60 * 24 * 30); // Assuming 30 days in a month

            // Calculate the total amount required to cover the remaining months
            $required_payment = $monthly_rate * ceil($num_months_to_cover);

            // Check if the payment covers the required amount
            if ($payment == $monthly_rate) {
                // Insert the payment into tbl_payments
                $insert_query = "INSERT INTO tbl_payments (transaction_id, tenant_email, house_number, paid_amount, date_paid)
                                 VALUES (?, ?, ?, ?, NOW())";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("sssd", $transaction_id, $email, $house_number, $payment);
                $insert_stmt->execute();

                // Check if the payment was successfully inserted
                if ($insert_stmt->affected_rows > 0) {
                    // Deduct the payment amount from the user's e-wallet value
                    $update_query = "UPDATE tbl_users SET ewallet_value = ewallet_value - ? WHERE email = ?";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bind_param("ds", $payment, $email);
                    $update_stmt->execute();

                    // Check if the e-wallet update was successful
                    if ($update_stmt->affected_rows > 0) {
                        // Payment successful
                        $response = array("success" => true, "message" => "Payment successful. Next due date: " . $next_due_date);
                    } else {
                        // Failed to deduct from e-wallet
                        $response = array("success" => false, "message" => "Failed to deduct payment from e-wallet.");
                    }
                } else {
                    // Failed to insert payment
                    $response = array("success" => false, "message" => "Failed to insert payment.");
                }
                
                // Close the insert statement
                $insert_stmt->close();
            } else if($payment < $monthly_rate) {
                // Insufficient payment amount
                $remaining_payment = $monthly_rate - $payment;
                $response = array("success" => false, "message" => "Insufficient payment amount. Please top-up an additional ₱" . $remaining_payment);
            } else if($payment > $monthly_rate) {
                // Insufficient payment amount
                $extra = $payment - $monthly_rate;
                $response = array("success" => false, "message" => "You paid an extra ₱" . $extra. " Please try again.");
            }
        }
    } else {
        // Tenant not found
        $response = array("success" => false, "message" => "Tenant not found.");
    }

    // Close the tenant statement
    $tenant_stmt->close();
} else {
    // Payment data not provided
    $response = array("success" => false, "message" => "Payment data not provided.");
}

// Close the database connection
mysqli_close($conn);

// Encode the response array to JSON and echo it
echo json_encode($response);
?>
