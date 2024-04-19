<?php
include 'header.php'; 
include 'admindash.php';
?>


    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner"
                class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border" style="width: 3rem; height: 3rem; color: #bb5340;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->


            <?php include 'sidebar.php'; ?>


            <!-- Content Start -->
            <div class="content">
                <?php include 'navbar.php' ?>


                <!-- Sales Chart End -->



                <?php include 'footer.php'; ?>
            </div>
            <!-- Content End -->



    </body>
