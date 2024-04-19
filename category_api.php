<?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include your database connection file
        include 'assets/database/db_conn.php';

        // Sanitize input
        $category = mysqli_real_escape_string($conn, $_POST['category']);

        // Check if category already exists
        $check_query = "SELECT * FROM housetype WHERE category = '$category'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Category already exists
            echo "Category already exists";
        } else {
            // Insert new category
            $insert_query = "INSERT INTO housetype (category) VALUES ('$category')";
            if (mysqli_query($conn, $insert_query)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        }

        // Close connection
        mysqli_close($conn);
    }
?>
