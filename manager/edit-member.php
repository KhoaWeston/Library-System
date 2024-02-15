<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Update Member</h2>
            
            <?php 
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display message
                    unset($_SESSION['update']); // Remove message
                }
            ?>

            <?php 
                // Get the ID of the selected member
                $id=$_GET['id'];

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
                        $address = $row['Address'];
                        $phone_num = $row['PhoneNum'];
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'manager/search-members.php');
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
                        <td colspan="2" class="row-btns text-center">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Member" class="btn btn-primary">
                            <a href="member-list.php" class="btn btn-primary">Cancel</a>
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
            $_SESSION['update'] = "<div class='success'>Member updated successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/search-members.php');
       }else{
            // Create a session variable to display message
            $_SESSION['update'] = "<div class='success'>Member updated successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/edit-member.php');
       }
    }
?>