<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <!-- Profile Section begins here -->    
    <div class="confirm-container text-left">
        <h2 class="text-center">Manager Profile</h2>
        
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
                    $row=mysqli_fetch_assoc($res);

                    $username = $row['Username']; 
                    $books_out = $row['BooksOut'];
                    $address = $row['Address']; 
                    $phone_num = $row['PhoneNum']; 
                }else{
                    // Redirect to home
                    header('location:'.SITEURL.'/manager/home.php');
                }
            }
        ?>

        <div class="text-bold">ID Number: </div>
        <input type="text" name="id" value="<?php echo $id; ?>" disabled>

        <div class="text-bold">Username: </div>
        <input type="text" name="username" value="<?php echo $username; ?>" disabled>

        <div class="text-bold">Address: </div>
        <input type="text" name="address" value="<?php echo $address; ?>" disabled>

        <div class="text-bold">Phone Number: </div>
        <input type="number" name="phone_num" value="<?php echo $phone_num; ?>" disabled>

        <div class="text-bold">Books Reserved: </div>
        <input type="text" name="books_out" value="<?php echo $books_out; ?>" disabled>
    </div>
    <!-- Profile Section ends here -->

    <br/><br/>

    <!-- Logout Section begins here -->
    <div class="confirm-container text-right">
        <h3 class="text-left">Logout</h3><br/>
        <div class="text-left">Do you want to logout of your account? </div><br/>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
    <!-- Logout Section ends here -->
</section>
<!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>