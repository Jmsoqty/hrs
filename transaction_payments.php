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
                        <h2 class="mt-3 mb-3" style="color: #bb5340;">Transaction Details</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Print Reports</button>
                    </div>
                </div>
                <hr id="line"> <!-- Separation line -->

    
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Print Reports</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="month">Month</label>
                                    <select class="form-select" id="month">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="year">Year</label>
                                    <select class="form-select" id="year">
                                        <?php
                                        // Generate options for years, adjust as needed
                                        $currentYear = date('Y');
                                        for ($i = $currentYear - 10; $i <= $currentYear; $i++) {
                                            echo "<option value=\"$i\">$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-info" name="print">Print</button>
                            </div>
                        </div>
                    </div>
                </div>


                            
                <table id="datatableid" class="table mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transaction ID</th>
                            <th>Tenant's Email</th>
                            <th>House Number</th>
                            <th>Paid Amount</th>
                            <th>Date of Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "SELECT * FROM tbl_payments";

                        $result = $conn->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $conn->error);
                        }

                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            $i++;
                            $lastPayment = $row['date_paid'] ?  date('M d, Y', strtotime($row['date_paid'])) : 'No payment made';
                            echo "
                            <tr>
                                <td>{$i}</td>
                                <td>{$row['transaction_id']}</td>
                                <td>{$row['tenant_email']}</td>
                                <td>{$row['house_number']}</td>
                                <td>₱ {$row['paid_amount']}</td>
                                <td>{$lastPayment}</td>
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
    $(document).ready(function() {

        $('#save_tenant').on('click', function() {
        // Collect data from form fields
        var formData = {
            email: $('#email').val(),
            fullname: $('#fullname').val(),
            contact: $('#contact').val(),
            houseNum: $('#house').val(),
            monthlyRate: $('#monthly_rate').val(),
            registrationDate: $('#date').val()
        };

        // Send AJAX request to create a new tenant
        $.ajax({
            url: 'api/create_tenants.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
                
                if (data.success) {
                    // Display success message
                    alert(data.success);
                    // Optionally, refresh the page or update the list of tenants
                    location.reload();
                } else {
                    // Display error message
                    alert('Error: ' + data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });
    // Fetch and populate emails and house details select options
    fetchEmailsAndHouses();

    // Event listener for email selection change
    $('#email').on('change', function() {
        var selectedEmail = $(this).val();
        
        if (selectedEmail) {
            // Fetch fullname and contact number for the selected email
            $.ajax({
                url: 'api/get_tenant_details.php',
                type: 'POST',
                data: {
                    email: selectedEmail
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#fullname').val(data.fullname);
                        $('#contact').val(data.contact_number);
                    } else {
                        console.error('Failed to fetch tenant details:', data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        } else {
            // Clear fields if no email is selected
            $('#fullname').val('');
            $('#contact').val('');
        }
    });

    // Event listener for house detail selection change
    $('#house').on('change', function() {
        var selectedHouse = $(this).val();
        
        if (selectedHouse) {
            // Fetch monthly rate for the selected house detail
            $.ajax({
                url: 'api/get_house_rate.php',
                type: 'POST',
                data: {
                    houseNum: selectedHouse
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#monthly_rate').val(data.monthly_rate);
                    } else {
                        console.error('Failed to fetch house rate:', data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        } else {
            // Clear fields if no house detail is selected
            $('#monthly_rate').val('');
        }
    });
});

// Function to fetch and populate emails and house details
function fetchEmailsAndHouses() {
    // Fetch emails
    $.ajax({
        url: 'api/get_emails.php',
        type: 'GET',
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
                // Populate email select option
                var emailSelect = $('#email');
                emailSelect.empty().append('<option value="">Select Email</option>');
                data.emails.forEach(function(email) {
                    emailSelect.append('<option value="' + email + '">' + email + '</option>');
                });
            } else {
                console.error('Failed to fetch emails:', data.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });

    // Fetch house details
    $.ajax({
        url: 'api/get_houses.php',
        type: 'GET',
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
                // Populate house detail select option
                var houseSelect = $('#house');
                houseSelect.empty().append('<option value="">Select House Number</option>');
                data.houses.forEach(function(house) {
                    houseSelect.append('<option value="' + house.houseNum + '">' + house.houseNum + '</option>');
                });
            } else {
                console.error('Failed to fetch house details:', data.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


</script>

<script>
$(document).ready(function() {
    // Event listener for edit buttons
    $('.btn-primary').on('click', function() {
        var tenantId = $(this).attr('id').split('_')[2]; // Get tenant_id from button id
        var modalId = '#editModal_' + tenantId;
        
        // Fetch tenant details
        $.ajax({
            url: 'api/get_tenants.php',
            type: 'POST',
            data: {
                tenant_id: tenantId
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // Populate the modal with tenant details
                    $(modalId + ' #email_' + tenantId).val(data.email);
                    $(modalId + ' #fullname_' + tenantId).val(data.fullname);
                    $(modalId + ' #contact_' + tenantId).val(data.contact_number);
                    $(modalId + ' #house_' + tenantId).val(data.house_number);
                    $(modalId + ' #monthly_rate_' + tenantId).val(data.monthly_rate);
                    $(modalId + ' #date_' + tenantId).val(data.registration_date);
                } else {
                    console.error('Failed to fetch tenant details:', data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

    // Event listener for update button
    $('[id^="update_tenant_"]').on('click', function() {
        var tenantId = $(this).attr('id').split('_')[2]; // Get tenant_id from button id
        var modalId = '#editModal_' + tenantId;
        
        // Update tenant details
        $.ajax({
            url: 'api/update_tenant.php',
            type: 'POST',
            data: {
                tenant_id: tenantId,
                email: $(modalId + ' #email_' + tenantId).val(),
                fullname: $(modalId + ' #fullname_' + tenantId).val(),
                contact_number: $(modalId + ' #contact_' + tenantId).val(),
                house_number: $(modalId + ' #house_' + tenantId).val(),
                monthly_rate: $(modalId + ' #monthly_rate_' + tenantId).val(),
                registration_date: $(modalId + ' #date_' + tenantId).val()
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert(data.success);
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Error: ' + data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });
});
</script>
<script>
    $(document).on('click', '.delete-btn', function() {
    // Get the tenant ID from the button's data attribute
    var tenantId = $(this).data('tenant-id');

    // Call the deleteTenant function
    deleteTenant(tenantId);
});

function deleteTenant(tenantId) {
    // Confirm with the user before deleting the tenant
    if (confirm('Are you sure you want to delete this tenant?')) {
        // Send an AJAX request to the server to delete the tenant
        $.ajax({
            url: 'api/delete_tenant.php', // The API endpoint for deleting a tenant
            type: 'POST',
            data: {
                tenant_id: tenantId
            },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
                
                if (data.success) {
                    // Display success message
                    alert(data.message);
                    // Optionally, reload the page to reflect changes
                    location.reload();
                } else {
                    // Display error message
                    alert('Error: ' + data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('AJAX error: ' + error);
            }
        });
    }
}

</script>
<script>
    $(document).ready(function() {
        // When the "Print" button is clicked
        $('button[name="print"]').click(function() {
            // Get the selected month and year values
            var month = $('#month').val();
            var year = $('#year').val();
            
            // Open the generated PDF in a new tab with the selected month and year as parameters
            window.open('api/report.php?month=' + month + '&year=' + year, '_blank');
        });
    });
</script>



</body>
</html>