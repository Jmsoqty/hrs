<?php

include 'dbconfig.php';
session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment']) && isset($_POST['transaction_id'])) {
        $ewallet_value = floatval($_POST['payment']);
        $transaction_id = $_POST['transaction_id'];
        $email = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];

        // Validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Prepare the SQL statement
            $update_sql = "UPDATE tbl_users SET ewallet_value = ewallet_value + ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);

            if ($update_stmt) {
                $update_stmt->bind_param("ds", $ewallet_value, $email);

                if ($update_stmt->execute()) {
                    // Success response
                    $response = array("message" => "Top-up successfully!");
                } else {
                    // Error response
                    http_response_code(500);
                    $response = array("error" => "Error updating balance: " . $update_stmt->error);
                }

                $update_stmt->close();
            } else {
                http_response_code(500);
                $response = array("error" => "Failed to prepare the statement: " . $conn->error);
            }
        } else {
            http_response_code(400);
            $response = array("error" => "Invalid email format");
        }
    } else {
        http_response_code(400);
        $response = array("error" => "Missing required data");
    }
} else {
    http_response_code(405);
    $response = array("error" => "Invalid request method");
}

echo json_encode($response);
mysqli_close($conn);

?>
