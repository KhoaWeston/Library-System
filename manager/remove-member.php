<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Remove Member</h2>
            
            <?php 
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete']; // Display message
                    unset($_SESSION['delete']); // Remove message
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
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'manager/search-members.php');
                    }
                }
            ?>

            <form action="" method="POST">
                <table class="width-full">
                    <tr>
                        <td>ID: </td>
                        <td>
                            <?php echo $id; ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Username: </td>
                        <td>
                            <?php echo $username; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-btns text-center">
                            <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
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
        // Get the ID of member to be deleted
        $id = $_GET['id'];
            
        // Create SQL query to delete member
        $sql = "DELETE FROM user WHERE UID=$id";

        // Execute the query 
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed sucessfully or not
        if($res==TRUE){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='success'>Member deleted successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/search-members.php');
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete member.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/remove-member.php');
        }
    }
?>