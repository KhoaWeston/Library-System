<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Add Member</h2>
            
            <?php 
                ob_start();
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display message
                    unset($_SESSION['add']); // Remove message
                }
            ?>

            <form action="" method="POST">
                <table class="width-full">
                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" placeholder="Your Username">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Your Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Address: </td>
                        <td>
                            <input type="text" name="address" placeholder="Your Address">
                        </td>
                    </tr>

                    <tr>
                        <td>Phone Number: </td>
                        <td>
                            <input type="number" name="phone_num" placeholder="Your Phone Number">
                        </td>
                    </tr>

                    <tr>
                        <td>Member Type: </td>
                        <td>
                            <input type="radio" name="mem_type" value="member"> Member
                            <input type="radio" name="mem_type" value="manager"> Manager
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-btns text-center">
                            <input type="submit" name="submit" value="Add Member" class="btn btn-primary">
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
        // Get data from form
        $username = $_POST['username'];
        $password = md5($_POST['password']); // password encryption
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num']; 
        $mem_type = $_POST['mem_type'];

        // SQL Query to save the data into the database
        $sql = "INSERT INTO user SET
            Username='$username',
            Password='$password',
            Address='$address',
            PhoneNum='$phone_num',
            MemberType='$mem_type'
        ";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Member added successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/member-list.php');
            ob_end_flush();
       }else{
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add member.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/add-member.php');
       }
    }
?>