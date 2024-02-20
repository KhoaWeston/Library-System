<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Profile</h2>
            
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
                <div class="text-bold">ID Number: </div>
                <input type="text" name="id" value="<?php echo $id; ?>" disabled>

                <div class="text-bold">Username: </div>
                <input type="text" name="username" value="<?php echo $username; ?>">

                <div class="text-bold">Address: </div>
                <input type="text" name="address" value="<?php echo $address; ?>">

                <div class="text-bold">Phone Number: </div>
                <input type="number" name="phone_num" value="<?php echo $phone_num; ?>">

                <div class="text-bold">Books Reserved: </div>
                <input type="text" name="books_out" value="<?php echo $books_out; ?>" disabled>
                <br/>
                <div class="text-right">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit1" value="Save Changes" class="btn btn-primary">
                </div>
            </form>
        </div>
        <br/><br/>

        <div class="confirm-container">
            <h3 class="text-left">Update Password</h2><br/>
            <?php 
                if(isset($_SESSION['update-pass'])){
                    echo $_SESSION['update-pass']; // Display message
                    unset($_SESSION['update-pass']); // Remove message
                }
            ?>
            <form action="" method="POST" class="text-left">
                <div class="text-bold">Current Password</div>
                <input type="password" name="current_password">

                <div class="text-bold">New Password</div>
                <input type="password" name="new_password">

                <div class="text-bold">Confirm Password</div>
                <input type="password" name="confirm_password">

                <br/>
                <div class="text-right">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit2" value="Update Password" class="btn btn-primary">
                </div>
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

<?php include('partials-front/footer.php'); ?>

<?php 
    if(isset($_POST['submit1']))
    {
        // Get all the values from form to update
        $id = $_POST['id'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num']; 

        // SQL Query to save the data into the database
        $sql = "UPDATE user SET
            Username='$username',
            Address='$address',
            PhoneNum='$phone_num'
        WHERE UID='$id'";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql);

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['update-account'] = "<div class='success'>Changes Saved Successfully.</div>";
            // Refresh Page
            ?><meta http-equiv="refresh" content="0"> <?php
       }else{
            // Create a session variable to display message
            $_SESSION['update-account'] = "<div class='success'>Failed to Save Changes.</div>";
            // Redirect Page
            header("location:".SITEURL.'edit-profile.php');
       }
    }
?>

<?php 
    if(isset($_POST['submit2']))
    {
        // Get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']); 

        // Check whether the user with current ID and current password exist or not
        $sql = "SELECT * FROM user WHERE UID=$id AND Password='$current_password'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        if($res==TRUE){
            $count=mysqli_num_rows($res);

            if($count==1){
                // User exists and password can be changed

                // Check whether the new password and confirm match or not
                if($new_password == $confirm_password){
                    // Update the password
                    $sql2 = "UPDATE user SET
                        Password='$new_password'
                    WHERE UID=$id";

                    // Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // check whether the query is executed 
                    if($res2==TRUE){
                        // Create a session variable to display message
                        $_SESSION['update-pass'] = "<div class='success'>Password changed successfully.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'profile.php');
                    }else{
                        // Create a session variable to display message
                        $_SESSION['update-pass'] = "<div class='error'>Failed to change password.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'profile.php');
                    }
                }else{
                    // Redirect to search members page with error message
                    $_SESSION['update-pass'] = "<div class='error'>Password did not match.</div>";
                    // Redirect the User
                    header("location:".SITEURL.'profile.php');
                }
            }else{
                // user does not exist set message and redirect
                $_SESSION['update-pass'] = "<div class='error'>User not found.</div>";
                // Redirect the user
                header("location:".SITEURL.'profile.php');
            }
        }

       
    }
?>