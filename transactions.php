<?php include 'header_user.php'; ?>
    <!-- Include Bootstrap CSS -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> 

<body> 
<?php include 'sidebar_user.php'; ?>
<script src="https://www.paypal.com/sdk/js?client-id=Abs-N-M4WYrdHc1qxT_uzaGW88PryBVPS36QImte-DMDvnU7oCWPFSQHEllGcCKUE_lT0asYfezU3-zt&currency=USD"></script>

<?php $email = $_SESSION['email']; ?>
        <div class="content">
            <?php include 'navbar.php'; ?>
            
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <h2 class="mt-3 mb-3" style="color: #bb5340;">Transactions</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <button id="addPaymentButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add Payment</button>
                    </div>
                </div>
                <hr id="line"> <!-- Separation line -->

                <!-- Modal -->
                <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ewallet-modal-label">E-Wallet Balance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <h1 class="text-center" name="balance" id="balance">₱
                                    <?php
                                    $current_balance = '0.00';

                                    $sql = "SELECT ewallet_value FROM tbl_users WHERE email = '$email'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        echo $current_balance = $row['ewallet_value'];
                                    }
                                    ?></h1>
                                <label for="balance">Current Balance</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="payment" name="payment" step="0.01" min="1" max="100000" placeholder="Insert your desired amount">
                                <label for="payment">Pay</label>
                            </div>
                            <div id="paypal-button-container-1"></div>
                        </div>
                    </div>
                </div>
            </div>


                <table id="datatableid" class="table mt-4">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>House Number</th>
                            <th>Paid Amount</th>
                            <th>Date Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_payments WHERE tenant_email = '$email'";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['transaction_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['house_number']) . '</td>';
                        echo '<td>' . '₱' . htmlspecialchars($row['paid_amount']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['date_paid']) . '</td>';
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
    paypal.Buttons({
        createOrder: function(data, actions) {
            var amount = parseFloat($('#payment').val());
            // Check if current balance is sufficient
            var currentBalance = parseFloat($('#balance').text().replace('$', ''));
            if (isNaN(amount) || amount <= 0) {
                alert('Invalid amount! Please enter a valid payment amount.');
                return false;
            }
            if (currentBalance < amount) {
                alert('Top-up more. Your current balance is insufficient.');
                return false;
            }
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: amount.toFixed(2),
                        currency_code: 'USD'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                var amount = $('#payment').val();
                var transactionId = data.orderID;

                console.log(transactionId);
                $.ajax({
                    type: "POST",
                    url: "api/add_payment.php",
                    data: {
                        payment: amount,
                        transaction_id: transactionId
                    },
                    success: function(response) {
                        console.log(response); // Log the response for debugging
                        try {
                            var parsedResponse = JSON.parse(response);
                            if (parsedResponse.success) {
                                alert(parsedResponse.message); // Display success message
                            } else {
                                alert(parsedResponse.message); // Display error message
                            }
                        } catch (error) {
                            alert('An error occurred while processing the response.'); // Display error message
                            console.error(error);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 0) {
                            alert('Network error occurred. Please check your internet connection.');
                        } else {
                            alert('An error occurred while making the request. Please try again later.');
                        }
                        console.error(error);
                    }
                });
            });
        },
        onCancel: function(data) {
            alert('Payment cancelled');
        },
        onError: function(err) {
            alert('Invalid Payment');
            console.error(err);
        }
    }).render('#paypal-button-container-1');
</script>







<script>
    $(document).ready(function() {
        // When the page loads, check if a payment is required
        checkPaymentRequired();

        // Function to check if a payment is required
        function checkPaymentRequired() {
            $.ajax({
                url: 'api/check_payment.php', // Replace with the actual API endpoint
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.add_payment) {
                        // Enable the "Add Payment" button
                        $('#addPaymentButton').prop('disabled', false);
                    } else {
                        // Disable the "Add Payment" button if no payment is required
                        $('#addPaymentButton').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
</script>

</body>
</html>