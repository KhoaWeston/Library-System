<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Remove Member</h2>
        
        <?php 

            // Display error messages
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; // Display message
                unset($_SESSION['delete']); // Remove message
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
                }else{
                    // Redirect to members list
                    header('location:'.SITEURL.'manager/member-list.php');
                }
            }
        ?>

        <form action="" method="POST">
            <table class="width-full">
                <tr>
                    <td class="text-right text-bold">ID: </td>
                    <td> <?php echo $id; ?></td>
                </tr>
                
                <tr>
                    <td class="text-right text-bold">Username: </td>
                    <td> <?php echo $username; ?></td>
                </tr>

                <tr>
                    <td colspan="2" class="row-btns text-center">
                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
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
        // Get the ID of member to be deleted
        $id = $_GET['id'];
        
        if($id == $_SESSION['user']){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Cannot delete your own account.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/member-list.php');
            exit();
        }

        // Create SQL query to delete member
        $sql_delete = "DELETE FROM user WHERE UID=$id";

        // Execute the query 
        $res_delete = mysqli_query($conn, $sql_delete);

        // Check whether the query executed sucessfully or not
        if($res_delete==TRUE){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='success'>Member deleted successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/member-list.php');
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete member.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/remove-member.php?id='.$id);
        }
    }
?>