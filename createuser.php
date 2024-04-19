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
                        <h2 class="mt-3 mb-3" style="color: #bb5340;">Create User Account </h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add User</button>
                    </div>
                </div>
                <hr id="line"> <!-- Separation line -->

                <!-- Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                    </div>    
                                <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryInput" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact Number">
                                    </div>

                                <div class="mb-3">
                                    <label for="categoryInput" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" min="6" placeholder="Enter Password">
                                </div>

                                <div class="mb-3">
                                    <label for="categoryInput" class="form-label">Select User Type</label>
                                    <select class="form-select" aria-label="Default select example">
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="client">Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save_user">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="datatableid" class="table mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tbl_users";
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
                                <td>{$row['fullname']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact_number']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['usertype']}</td>
                                <td>
                                    <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal_{$row['user_id']}'>Edit</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-category-id='{$row['user_id']}'>Delete</button>
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

<script>
$(document).ready(function() {
    // Attach click event listener to the "Save" button
    $('#save_user').on('click', function() {
        // Get the input values from the form
        var name = $('#name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var password = $('#password').val();
        var usertype = $('select').val(); // Get the selected user type from the dropdown

        // Create the data object to send to the API
        var data = {
            name: name,
            username: username,
            email: email,
            contact: contact,
            password: password,
            usertype: usertype
        };

        // Send AJAX request to the API
        $.ajax({
            url: 'api/register.php', // Your API endpoint for user registration
            type: 'POST',
            data: data,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                // Handle successful response
                if (response.success) {
                    // Display success message and refresh the page to reflect changes
                    alert(response.success);
                    location.reload();
                } else if (response.error) {
                    // Display error message
                    alert(response.error);
                }
            },
            error: function(xhr, status, error) {
                // Handle request error
                alert('An error occurred: ' + error);
            }
        });
    });
});
</script>

</body>
</html>