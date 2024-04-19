<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'dbconfig.php';

    // Sanitize the input (convert category_id to an integer to prevent SQL injection)
    $category_id = intval($_POST['category_id']);

    // Check if the category ID is valid
    if ($category_id > 0) {
        // Proceed with deletion
        $delete_query = "DELETE FROM tbl_housetypes WHERE housetype_id = $category_id";

        if (mysqli_query($conn, $delete_query)) {
            // Category deleted successfully
            echo json_encode([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } else {
            // Error deleting category
            echo json_encode([
                'success' => false,
                'message' => 'Error deleting category: ' . mysqli_error($conn)
            ]);
        }
    } else {
        // Invalid category ID
        echo json_encode([
            'success' => false,
            'message' => 'Invalid category ID'
        ]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
