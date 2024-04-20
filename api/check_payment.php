<?php
include 'dbconfig.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the email of the logged-in user
    $email = $_SESSION['email'];

    // Fetch the registration date and monthly rate of the user from tbl_tenants
    $tenantQuery = "SELECT registration_date, monthly_rate FROM tbl_tenants WHERE email = ?";
    $tenantStmt = mysqli_prepare($conn, $tenantQuery);
    mysqli_stmt_bind_param($tenantStmt, "s", $email);
    mysqli_stmt_execute($tenantStmt);
    $tenantResult = mysqli_stmt_get_result($tenantStmt);

    if ($tenantResult && $tenantRow = mysqli_fetch_assoc($tenantResult)) {
        $registrationDate = $tenantRow['registration_date'];
        $monthlyRate = $tenantRow['monthly_rate'];

        // Calculate the next due date based on the registration date
        $nextDueDate = date('Y-m-d', strtotime('+1 month', strtotime($registrationDate)));

        // Check if the user has made a payment this month
        $paymentQuery = "SELECT SUM(paid_amount) AS total_paid FROM tbl_payments WHERE tenant_email = ? AND MONTH(date_paid) = MONTH(CURRENT_DATE()) AND YEAR(date_paid) = YEAR(CURRENT_DATE())";
        $paymentStmt = mysqli_prepare($conn, $paymentQuery);
        mysqli_stmt_bind_param($paymentStmt, "s", $email);
        mysqli_stmt_execute($paymentStmt);
        $paymentResult = mysqli_stmt_get_result($paymentStmt);

        if ($paymentResult && $paymentRow = mysqli_fetch_assoc($paymentResult)) {
            $totalPaid = $paymentRow['total_paid'];

            // Check if the total paid amount is less than the monthly rate
            if ($totalPaid < $monthlyRate) {
                // If the total paid amount is less than the monthly rate, set add_payment to true
                $addPayment = true;
            } else {
                // If the total paid amount is equal to or greater than the monthly rate, set add_payment to false
                $addPayment = false;
            }
        } else {
            // If no payment exists for this month, set add_payment to true
            $addPayment = true;
        }

        // Return the response as JSON
        $response = [
            'add_payment' => $addPayment,
            'next_due_date' => $nextDueDate,
            'monthly_rate' => $monthlyRate
        ];
        echo json_encode($response);
    } else {
        // Error fetching tenant data
        http_response_code(500);
        echo json_encode(['error' => 'Error fetching tenant data']);
    }

    // Close the prepared statements and database connection
    mysqli_stmt_close($tenantStmt);
    mysqli_stmt_close($paymentStmt);
    mysqli_close($conn);
}
?>
