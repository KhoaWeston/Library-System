<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Update Password</h2>
        
        <?php 
            // Turn on output buffering
            ob_start();

            // Display error message
            if(isset($_SESSION['update-pass'])){
                echo $_SESSION['update-pass']; // Display message
                unset($_SESSION['update-pass']); // Remove message
            }
            
            // Get id of selected user
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="width-full">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Old Password" required>
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="row-btns text-center">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn btn-primary">
                        <a href="member-list.php" class="btn btn-primary indent">Cancel</a>
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
        $sql_valid = "SELECT * FROM user WHERE UID='$id' AND Password='$current_password'";

        // Execute the query
        $res_valid = mysqli_query($conn, $sql_valid);

        if($res_valid==TRUE){
            $count_valid=mysqli_num_rows($res_valid);

            if($count_valid==1){
                // User exists and password can be changed
                // Check whether the new password and confirm match or not
                if($new_password == $confirm_password){
                    // Update the password
                    $sql_update = "UPDATE user SET
                        Password='$new_password'
                    WHERE UID=$id";

                    // Execute the query
                    $res_update = mysqli_query($conn, $sql_update);

                    // check whether the query is executed 
                    if($res_update==TRUE){
                        // Create a session variable to display message
                        $_SESSION['update-pass'] = "<div class='success'>Password changed successfully.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'manager/member-list.php');
                        // Flush output buffer and turn off output buffering
                        ob_end_flush();
                    }else{
                        // Create a session variable to display message
                        $_SESSION['update-pass'] = "<div class='error'>Failed to change password.</div>";
                        // Redirect Page
                        header("location:".SITEURL.'manager/update-password.php?id='.$id);
                    }
                }else{
                    $_SESSION['update-pass'] = "<div class='error'>Password did not match.</div>";
                    header("location:".SITEURL.'manager/update-password.php?id='.$id);
                }
            }else{
                $_SESSION['update-pass'] = "<div class='error'>Incorrect Password.</div>";
                header("location:".SITEURL.'manager/update-password.php?id='.$id);
            }
        }
    }
?>