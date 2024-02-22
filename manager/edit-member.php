<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Update Member</h2>
        
        <?php 
            // Turn on output buffering
            ob_start();

            // Display error messages
            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; // Display message
                unset($_SESSION['update']); // Remove message
            }
            if(isset($_SESSION['missing'])){
                echo $_SESSION['missing']; 
                unset($_SESSION['missing']); 
            }
        ?>

        <?php 
            // Get the ID of the selected member
            $id=$_GET['id'];

            // Create SQL Query to get the details
            $sql_details="SELECT * FROM user WHERE UID=$id";

            // Execute the query
            $res_details=mysqli_query($conn, $sql_details);

            // Check whether the query is executed or not
            if($res_details==TRUE){
                // Check whether the data is available or not
                $count_details = mysqli_num_rows($res_details);
                // Check whether we have member data or  not
                if($count_details==1){
                    // Get the details
                    $row_details=mysqli_fetch_assoc($res_details);

                    $username = $row_details['Username'];
                    $address = $row_details['Address'];
                    $phone_num = $row_details['PhoneNum'];
                }else{
                    // Redirect to member list
                    header('location:'.SITEURL.'manager/member-list.php');
                }
            }
        ?>

        <form action="" method="POST">
            <table class="width-full">
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="address" value="<?php echo $address; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Phone Number: </td>
                    <td>
                        <input type="number" name="phone_num" value="<?php echo $phone_num; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Member Type: </td>
                    <td>
                        <input type="hidden" name="mem_type" value="error">
                        <input type="radio" name="mem_type" value="member"> Member
                        <input type="radio" name="mem_type" value="manager"> Manager
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="row-btns text-center">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Member" class="btn btn-primary">
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
        // Get all the values from form to update
        $id = $_POST['id'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num'];
        $mem_type = $_POST['mem_type']; 

        if($mem_type == "error"){
            // Create a session variable to display message
            $_SESSION['missing'] = "<div class='error'>Select Member Type</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/edit-member.php?id='.$id);
            ob_end_flush();
            exit();
        }

        // Query to get all users
        $sql_users = "SELECT * FROM user";
        // Execute the query
        $res_users = mysqli_query($conn, $sql_users);
        if($res_users==TRUE){
            while($rows_users=mysqli_fetch_assoc($res_users)){
                if($username == $rows_users['Username']){
                    // Create a session variable to display message
                    $_SESSION['update'] = "<div class='error'>Username is taken. </div>";
                    // Redirect Page
                    header("location:".SITEURL.'edit-member.php?id='.$id);
                    exit();
                }
            }
        }

        // SQL Query to save the data into the database
        $sql_update = "UPDATE user SET
            Username='$username',
            Address='$address',
            PhoneNum='$phone_num',
            MemberType='$mem_type'
        WHERE UID='$id'";

        // Execute query and save data into database
        $res_update = mysqli_query($conn, $sql_update);

        // check whether the query is executed 
        if($res_update==TRUE){        
            // Create a session variable to display message
            $_SESSION['update'] = "<div class='success'>Member updated successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/member-list.php');
        }else{
            // Create a session variable to display message
            $_SESSION['update'] = "<div class='error'>Failed to update member.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/edit-member.php?id='.$id);
        }
    }
?>