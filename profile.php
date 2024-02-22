<?php include('partials-front/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <!-- Profile Change section begins here -->
    <div class="confirm-container">
        <h2 class="text-center">Profile</h2>
        
        <?php 
            // Turn on output buffering
            ob_start();

            // Display update messages
            if(isset($_SESSION['update-account'])){
                echo $_SESSION['update-account'];
                unset($_SESSION['update-account']);
            }
        ?>

        <?php 
            // Get the ID of the member
            $id = $_SESSION['user'];
            
            // Create SQL Query to get the details
            $sql_user="SELECT * FROM user WHERE UID=$id";

            // Execute the query
            $res_user=mysqli_query($conn, $sql_user);

            // Check whether the query is executed or not
            if($res_user==TRUE){
                // Get the details
                $row_user=mysqli_fetch_assoc($res_user);

                $username = $row_user['Username']; 
                $books_out = $row_user['BooksOut'];
                $address = $row_user['Address']; 
                $phone_num = $row_user['PhoneNum']; 
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
                <input type="submit" name="submit_profile" value="Save Changes" class="btn btn-primary">
            </div>
        </form>
    </div>
    <!-- Profile Change section ends here -->
    
    <br/><br/>

    <!-- Password Change section begins here -->
    <div class="confirm-container">
        <h3 class="text-left">Update Password</h2><br/>

        <?php 
            // Display update messages
            if(isset($_SESSION['update-pass'])){
                echo $_SESSION['update-pass']; 
                unset($_SESSION['update-pass']); 
            }
        ?>

        <form action="" method="POST" class="text-left">
            <div class="text-bold">Current Password: </div>
            <input type="password" name="current_password" required>

            <div class="text-bold">New Password: </div>
            <input type="password" name="new_password" required>

            <div class="text-bold">Confirm Password: </div>
            <input type="password" name="confirm_password" required>

            <br/>
            <div class="text-right">
                <input type="submit" name="submit_pass" value="Update Password" class="btn btn-primary">
            </div>
        </form>
    </div>
    <!-- Password Change section ends here -->
    
    <br/><br/>

    <!-- Logout section begins here -->
    <div class="confirm-container text-right">
        <h3 class="text-left">Logout</h3><br/>
        <div class="text-left">Do you want to logout of your account? </div><br/>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
    <!-- Logout section ends here -->
</section>
<!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<?php 
    if(isset($_POST['submit_profile']))
    {
        // Get all the values from form to update
        $id = $_SESSION['user'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num']; 

        // Query to get all users
        $sql_users = "SELECT * FROM user";
        // Execute the query
        $res_users = mysqli_query($conn, $sql_users);
        if($res_users==TRUE){
            while($rows_users=mysqli_fetch_assoc($res_users)){
                if($username == $rows_users['Username']){
                    if($id != $rows_users['UID']){
                        // Create a session variable to display message
                        $_SESSION['update'] = "<div class='error'>Username is taken. </div>";
                        // Redirect Page
                        header("location:".SITEURL.'manager/edit-member.php?id='.$id);
                        exit();
                    }
                }
            }
        }

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
    if(isset($_POST['submit_pass']))
    {
        // Get the data from form
        $id = $_SESSION['user'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']); 

        // Check whether the user with current ID and current password exist or not
        $sql_valid = "SELECT * FROM user WHERE UID='$id' AND Password='$current_password'";

        // Execute the query
        $res_valid = mysqli_query($conn, $sql_valid);

        $count_valid = mysqli_num_rows($res_valid);

        // check whether the query is executed 
        if($count_valid==1){        
            // Check whether the new password and confirm match or not
            if($new_password == $confirm_password){
                // Update the password
                $sql_update = "UPDATE user SET
                    Password='$new_password'
                WHERE UID='$id'";

                $res_update = mysqli_query($conn, $sql_update);
                if($res_update==TRUE){
                    // Create a session variable to display message
                    $_SESSION['update-pass'] = "<div class='success'>Password changed successfully.</div>";
                    // Redirect Page
                    header("location:".SITEURL.'profile.php');
                    // Flush output buffer and turn off output buffering
                    ob_end_flush();
                }else{
                    // Failed to update password
                    $_SESSION['update-pass'] = "<div class='error'>Failed to change password.</div>";
                    header("location:".SITEURL.'profile.php');
                }
            }else{
                // Passwords didnt match
                $_SESSION['update-pass'] = "<div class='error'>Passwords did not match.</div>";
                header("location:".SITEURL.'profile.php');
            }
        }else{
            // incorrect password
            $_SESSION['update-pass'] = "<div class='error'>Incorrect password.</div>";
            header("location:".SITEURL.'profile.php');
        }
    }
?>