<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header_user.php'; ?>
</head>
<body> 
    <?php include 'sidebar_user.php'; ?>
    <script src="https://www.paypal.com/sdk/js?client-id=Abs-N-M4WYrdHc1qxT_uzaGW88PryBVPS36QImte-DMDvnU7oCWPFSQHEllGcCKUE_lT0asYfezU3-zt&currency=USD"></script>
    <div class="content">
        <?php include 'navbar.php'; ?>

        <div class="container" style="background-color: #FEFAF6;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <h2 class="mt-3 mb-3" style="color: black;">E-wallet</h2>
                </div>
            </div>
            <hr id="line"> <!-- Separation line -->
       
        </div>
        <?php $email = $_SESSION['email']; ?>
        <div class="container">
    <!-- Balance display -->
    <div class="text-center mb-3">
        <h1 id="balance" class="fw-bold">
        ₱
            <?php
            $current_balance = '0.00';
            $sql = "SELECT ewallet_value FROM tbl_users WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo number_format((float)$row['ewallet_value'], 2, '.', '');
            }
            ?>
        </h1>
        <label for="balance" class="form-label">Current Balance</label>
    </div>

    <!-- Top-up input -->
    <div class="mb-3">
        <label for="payment" class="form-label">Top-up Amount</label>
        <input type="number" class="form-control" id="payment" name="payment" step="0.01" min="1" max="100000" placeholder="Enter amount to top up" required>
    </div>

    <!-- PayPal button container -->
    <div class="d-flex justify-content-center">
    <div class="align-items-center" id="paypal-button-container-1"></div>
</div>

</div>

    <?php include 'footer.php'; ?>

    <script src="./assets/js/mainpage.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    </script>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                var amount = $('#payment').val();
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount,
                            currency_code: 'USD'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    var amount = $('#payment').val();
                    var transactionId = data.orderID;
                    $.ajax({
                        type: "POST",
                        url: "api/topup.php",
                        data: { 
                            payment: amount,
                            transaction_id: transactionId
                        },
                        success: function(response) {
                            alert('Top-up successful. Please reload the page.');
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred, please try again later');
                            console.error(error);
                        }
                    });
                });
            },
            onCancel: function(data) {
                alert('Payment cancelled');
            },
            onError: function(err) {
                alert('Invalid Amount');
                console.error(err);
            }
        }).render('#paypal-button-container-1');
    </script>

</body>
</html>
