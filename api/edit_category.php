<?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include your database connection file
        include 'dbconfig.php';

        // Sanitize input
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $category_id = mysqli_real_escape_string($conn, $_POST['id']);

        $update_query = "UPDATE tbl_housetypes SET housetype_name = '$category' WHERE housetype_id = '$category_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
?>