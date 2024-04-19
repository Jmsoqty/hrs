<?php include 'header.php'; ?>
    <!-- Include Bootstrap CSS -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> 

<body> 
<?php include 'sidebar.php'; ?>

<div class="content">
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6">
                <h2 class="mt-3 mb-3" style="color: #bb5340;">House Type</h2>
            </div>
            <div class="col-md-6 text-md-right">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add House Type</button>
            </div>
        </div>
        <hr id="line"> <!-- Separation line -->

        <!-- Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add House Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formCategory" class="forms-sample">
                            <div class="mb-3">
                                <label for="categoryInput" class="form-label">Category</label>
                                <input type="text" class="form-control" id="categoryInput" name="category" placeholder="Enter category">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveHouseType">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM tbl_housetypes";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
        ?>

        <div class="modal fade" id="editModal_<?php echo $row['housetype_id']; ?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Edit House Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formCategory_<?php echo $row['housetype_id']; ?>" class="forms-sample">
                            <div class="mb-3">
                                <label for="categoryInput_<?php echo $row['housetype_id']; ?>" class="form-label">Category</label>
                                <input type="text" class="form-control" id="categoryInput_<?php echo $row['housetype_id']; ?>" name="category" placeholder="Enter category" value="<?php echo $row['housetype_name']; ?>">
                                <!-- Add a hidden input field to store the category ID -->
                                <input type="hidden" id="categoryId_<?php echo $row['housetype_id']; ?>" name="categoryId" value="<?php echo $row['housetype_id']; ?>">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary updateHouseType" data-id="<?php echo $row['housetype_id']; ?>">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <table id="datatableid" class="table mt-4">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM tbl_housetypes";
        $result = $conn->query($sql);

        if (!$result) {
            die("Invalid query: " . $conn->error);
        }

        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $i++;
            echo "
            <tr>
                <td>{$i}</td>
                <td>{$row['housetype_name']}</td>
                <td>
                    <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal_{$row['housetype_id']}'>Edit</button>
                    <button class='btn btn-danger btn-sm delete-btn' data-category-id='{$row['housetype_id']}'>Delete</button>
                </td>
            </tr>
            ";
        }
        ?>
    </tbody>
</table>

        <?php include 'footer.php'; ?>
    </div>  
</div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {
        $('#datatableid').DataTable({
            responsive: true,
            deferRender: true,
            scroller: true // If you want to keep scroller functionality
        });
    });

</script>

<script>
    $(document).ready(function() {
        $("#saveHouseType").click(function() {
            // Get the category value from the form
            var category = $("#categoryInput").val();

            // Send an AJAX request to your API endpoint
            $.ajax({
                type: "POST",
                url: "api/add_category.php",
                data: { category: category },
                success: function(response) {
                    // Display the response message (e.g., success or error)
                    alert(response);
                    // Close the modal if the request was successful
                    if (response === "New record created successfully") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Request failed, handle the error
                    alert("Error: " + error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".updateHouseType").click(function() {
            var id = $(this).data('id');
            var category = $("#categoryInput_" + id).val();

            // Send an AJAX request to update the category
            $.ajax({
                type: "POST",
                url: "api/edit_category.php",
                data: {
                    id: id,
                    category: category
                },
                success: function(response) {
                    alert(response); // Display the response message
                    // Close the modal if the update was successful
                    if (response === "Record updated successfully") {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error); // Display the error message
                }
            });
        });
    });
</script>

<script>
$(document).ready(function() {
    // Add event listener for delete button click
    $('.delete-btn').on('click', function() {
        // Get the category ID from the data-category-id attribute
        var categoryId = $(this).data('category-id');

        // Ask for confirmation before deleting the category
        var confirmation = confirm('Do you want to remove this category?');

        // If the user confirms the action, proceed with the AJAX request
        if (confirmation) {
            // Send AJAX request to delete category
            $.ajax({
                url: 'api/delete_category.php', // Your PHP script for deleting a category
                type: 'POST',
                data: {
                    category_id: categoryId // Send the category ID to the PHP script
                },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        // Category deleted successfully
                        // Optionally, you can remove the row from the table or refresh the page
                        alert('Category deleted successfully.');
                        location.reload(); // Refresh the page to reflect the change
                    } else {
                        // Handle error
                        alert('Error deleting category: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('An error occurred while deleting the category: ' + error);
                }
            });
        }
    });
});
</script>


</body>
</html>
