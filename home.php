<?php include('partials-front/header.php'); ?>

        <!-- Main Section Starts Here -->
        <section class="page-container">
            <div class="container">
                <h2 class="text-center">ShelfSavvy</h2>
                <?php 
                    if(isset($_SESSION['login'])){
                        echo $_SESSION['login']; // Display message
                        unset($_SESSION['login']); // Remove message
                    }
                ?>
                <p>This is a library management system. </p>
                <div class="comp-container"> This will be a dashboard</div>
            </div>
        </section>
        <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
