<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="book-catalog">
        <div class="container">
            <h2 class="text-center">Update Password</h2>
            
            <?php 
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display message
                    unset($_SESSION['update']); // Remove message
                }
            ?>

            <?php 
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-full">
                    <tr>
                        <td>Current Password: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Old Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn btn-primary">
                        </td>
                        <td>
                            <a href="search-members.php" class="btn btn-primary">Cancel</a>
                        </td>
                    </tr>
                </table>
            </form>

        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>

<?php 
    if(isset($_POST['submit']))
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
                // echo "user found";

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
                        $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'manager/search-members.php');
                    }else{
                        // Create a session variable to display message
                        $_SESSION['change-pwd'] = "<div class='success'>Failed to change password.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'manager/update-password.php');
                    }
                }else{
                    // Redirect to search members page with error message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
                    // Redirect the User
                    header("location:".SITEURL.'manager/search-members.php');
                }
            }else{
                // user does not exist set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not found.</div>";
                // Redirect the user
                header("location:".SITEURL.'manager/search-members.php');
            }
        }

       
    }
?>