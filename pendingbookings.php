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
                        <h2 class="mt-3 mb-3" style="color: #bb5340;">House Details</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add House Details</button>
                    </div>
                </div>
                <hr id="line"> <!-- Separation line -->

                <!-- Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">House Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                        <label for="categoryInput" class="form-label">House Number</label>
                                        <input type="text" class="form-control" id="housenum" name="housenum" placeholder="Enter House Number">
                                    </div>    
                                    <div class="mb-3">
                                        <label for="categorySelect" class="form-label">Category</label>
                                        <select class="form-select" id="categorySelect" name="category">
                                            <option value="">Select Category</option>
                                            <?php
                                                // Fetch categories from the database
                                                $sql = "SELECT * FROM tbl_housetypes";
                                                $result = $conn->query($sql);
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['housetype_name'] . "'>" . $row['housetype_name'] . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" min="1" step="0.01">
                                    </div>

                                    <div class="mb-3">
                                    <label for="categoryInput" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept=".jpg, .jpeg">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save_house_details">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $sql = "SELECT * FROM tbl_house_details";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>

                <div class="modal fade" id="editModal_<?php echo $row['house_number'];?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">House Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="housenum" class="form-label">House Number</label>
                                    <input type="text" class="form-control" id="housenum" name="housenum" value="<?php echo htmlspecialchars($row['house_number']); ?>" readonly>
                                </div>    
                                <div class="mb-3">
                                    <label for="categorySelect" class="form-label">Category</label>
                                    <select class="form-select" id="categorySelect" name="category">
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetch categories from the database
                                        $categorySql = "SELECT * FROM tbl_housetypes";
                                        $categoryResult = $conn->query($categorySql);
                                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                                            $selected = ($categoryRow['housetype_name'] == $row['category']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($categoryRow['housetype_name']) . "' $selected>" . htmlspecialchars($categoryRow['housetype_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($row['description']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" min="1" step="0.01">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Vacancy</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['vacancy']); ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept=".jpg, .jpeg">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="update_house_details">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <table id="datatableid" class="table mt-4">
                    <thead>
                        <tr>
                            <th>House Number</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Vacant/Occupied</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_house_details";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $imageBlob = $row['image']; 
                        $base64Image = base64_encode($imageBlob);

                        $imageDataUrl = 'data:image/jpeg;base64,' . $base64Image;
                        $i++;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['house_number']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                        echo '<td>' . '₱' . htmlspecialchars($row['price']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['vacancy']) . '</td>';
                        echo '<td><img src="' . $imageDataUrl . '" alt="House Image" style="width:100px;height:100px;"></td>';
                        echo '<td>';
                        echo "<button class='btn btn-primary btn-sm mr-2' data-bs-toggle='modal' data-bs-target='#editModal_{$row['house_number']}'>Edit</button>";
                        echo "<button class='btn btn-danger btn-sm delete-btn' data-house-number='{$row['house_number']}'>Delete</button>";
                        echo '</td>';
                        echo '</tr>';
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

<script>
    $(document).ready(function () {
        $('#datatableid').DataTable({
            responsive: true,
            scrollY: 200,
            deferRender: true,
            scroller: true
        });

        // Optional: Show modal when 'Add House Type' button is clicked
        // $('#createModal').modal('show'); // Uncomment this line to test modal display
    });
</script>

<script>
$(document).ready(function() {
    $('#save_house_details').click(function(e) {
        e.preventDefault();
        
        // Create a FormData object and append form data
        var formData = new FormData();
        formData.append('housenum', $('#housenum').val());
        formData.append('category', $('#categorySelect').val());
        formData.append('description', $('#description').val());
        formData.append('price', $('#price').val());
        formData.append('avatar', $('#avatar')[0].files[0]);
        
        // Make an AJAX request
        $.ajax({
            url: 'api/save_house_details.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Parse JSON response
                var result = JSON.parse(response);
                
                if (result.success) {
                    alert(result.success);
                    // Reload the page or update the data in your table dynamically if needed
                    location.reload();
                } else {
                    alert(result.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('An error occurred while saving house details. Please try again.');
            }
        });
    });
});

</script>

<script>
    $(document).ready(function() {
    // Handle the form submission for updating house details
    $('.modal').on('click', '#update_house_details', function() {
        // Find the modal that contains the button
        var modal = $(this).closest('.modal');

        // Create a FormData object to hold the form data
        var formData = new FormData();
        formData.append('housenum', modal.find('#housenum').val());
        formData.append('category', modal.find('#categorySelect').val());
        formData.append('description', modal.find('#description').val());
        formData.append('price', modal.find('#price').val());

        // Handle the image file input if it exists
        var avatarInput = modal.find('#avatar')[0];
        if (avatarInput.files && avatarInput.files[0]) {
            formData.append('avatar', avatarInput.files[0]);
        }

        // Send the form data using AJAX
        $.ajax({
            url: 'api/update_house_details.php', // Replace with your API URL for updating house details
            type: 'POST',
            data: formData,
            contentType: false, // Needed to handle file uploads
            processData: false, // Needed to handle file uploads
            success: function(response) {
                // Parse the response JSON
                var data = JSON.parse(response);

                // Handle success or error messages
                if (data.success) {
                    alert(data.success); // Display success message
                    location.reload();
                } else {
                    alert(data.error); // Display error message
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error: ' + error);
                alert('Failed to update house detail. Please try again.');
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
    // Handle delete button click
    $('.delete-btn').on('click', function() {
        var houseNumber = $(this).data('house-number');
        
        // Ask for confirmation before deleting
        if (confirm('Are you sure you want to delete this house?')) {
            // Send an AJAX request to the delete API
            $.ajax({
                url: 'api/delete_house_details.php',
                type: 'POST',
                data: {
                    houseNum: houseNumber
                },
                success: function(response) {
                    // Parse the response JSON
                    var data = JSON.parse(response);
                    
                    // Handle success or error messages
                    if (data.success) {
                        alert(data.success);
                        // Reload the page or update the table to reflect the changes
                        location.reload();
                    } else {
                        alert(data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error: ' + error);
                    alert('Failed to delete house detail. Please try again.');
                }
            });
        }
    });
});

</script>
</body>
</html>