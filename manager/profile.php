<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Admin Profile</h2>
            
            <?php 
                if(isset($_SESSION['update-account'])){
                    echo $_SESSION['update-account']; // Display message
                    unset($_SESSION['update-account']); // Remove message
                }
            ?>

            <?php 
                // Get the ID of the member
                $id = $_SESSION['user'];
                
                // Create SQL Query to get the details
                $sql="SELECT * FROM user WHERE UID=$id";

                // Execute the query
                $res=mysqli_query($conn, $sql);

                // Check whether the query is executed or not
                if($res==TRUE){
                    // Check whether the data is available or not
                    $count = mysqli_num_rows($res);
                    // Check whether we have member data or  not
                    if($count==1){
                        // Get the details
                        // echo "member available";
                        $row=mysqli_fetch_assoc($res);

                        $username = $row['Username']; 
                        $books_out = $row['BooksOut'];
                        $address = $row['Address']; 
                        $phone_num = $row['PhoneNum']; 
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'search-books.php');
                    }
                }
            ?>

            <form action="" method="POST" class="text-left">
                <div class="text-bold">ID Number: <?php echo $id; ?></div><br/>
                <div class="text-bold">Username: <?php echo $username; ?></div><br/>
                <div class="text-bold">Address: <?php echo $address; ?></div><br/>
                <div class="text-bold">Phone Number: <?php echo $phone_num; ?></div><br/>
                <div class="text-bold">Books Reserved: <?php echo $books_out; ?></div><br/>
                
            </form>
        </div>
        <br/><br/>

        <div class="confirm-container text-right">
            <h3 class="text-left">Logout</h3><br/>
            <div class="text-left">Do you want to logout of your account? </div><br/>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>
