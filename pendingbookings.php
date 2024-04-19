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
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add House Type</button>
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
                                <form action="" method="POST" id="Formcategory" class="forms-sample">
                                    
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
                                                $sql = "SELECT * FROM housetype";
                                                $result = $connection->query($sql);
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
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
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price">
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Vacant/Occupied</label>
                                        <select class="form-select" aria-label="Default select example">
                                        <option value="1">None</option>
                                        <option value="1">Vacant</option>
                                        <option value="2">Occupied</option>
                                    </select>
                                    </div>

                                    <div class="mb-3">
                                    <label for="categoryInput" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Enter Avatar">
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
                        <!-- User data will be populated here -->
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
    $(document).ready(function () {
        $('#saveHouseType').click(function (e) {
            e.preventDefault();

            // Fetch form data
            var formData = $('#Formcategory').serialize();

            // Send AJAX request to category_api.php
            $.ajax({
                type: 'POST',
                url: 'category_api.php',
                data: formData,
                success: function (response) {
                    // Check the response from the server
                    if(response == 1){
                        alert("House type saved successfully!");
                        window.location.href = 'pendingbookings.php';
                    }else{
                        alert("Failed to save house type. Unexpected response.");
                    }
                   
                },
                
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message (AJAX request failed)
                    alert("An error occurred while processing your request. Please try again later.");
                }
            });
        });
    });
</script>


</body>
</html>