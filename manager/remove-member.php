<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="book-catalog">
        <div class="container">
            <h2 class="text-center">Remove Member</h2>
            
            <form action="" method="POST">
                <table class="tbl-full">
                    <tr>
                        <td>ID: </td>
                        <td>
                            <?php 
                                echo $id = $_GET['id'];
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Username: </td>
                        <td>
                            <?php 
                                echo $username = $_GET['username'];
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
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