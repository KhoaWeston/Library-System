<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Remove Book</h2>
        
        <?php 
            // Get the ID of the selected book
            $isbn=$_GET['isbn'];

            // Create SQL Query to get the details
            $sql_details="SELECT * FROM books WHERE BookID=$isbn";

            // Execute the query
            $res_details=mysqli_query($conn, $sql_details);

            // Check whether the query is executed or not
            if($res_details==TRUE){
                // Check whether the data is available or not
                $count_details = mysqli_num_rows($res_details);
                // Check whether we have member data or  not
                if($count_details==1){
                    // Get the details
                    // echo "member available";
                    $row_details=mysqli_fetch_assoc($res_details);

                    $title = $row_details['Title']; 
                    $author = $row_details['Author'];
                    $genre = $row_details['Genre']; 
                    $num_copies = $row_details['NumofCopies']; 
                }else{
                    // Redirect to book list
                    header('location:'.SITEURL.'manager/book-list.php');
                }
            }
        ?>

        <form action="" method="POST">
            <table class="width-full">
                <tr>
                    <td>ISBN: </td>
                    <td><?php echo $isbn; ?></td>
                </tr>
                
                <tr>
                    <td>Title: </td>
                    <td><?php echo $title; ?></td>
                </tr>
                
                <tr>
                    <td>Author: </td>
                    <td><?php echo $author; ?></td>
                </tr>

                <tr>
                    <td>Number of Copies: </td>
                    <td><?php echo $num_copies; ?></td>
                </tr>

                <tr>
                    <td colspan="2" class="row-btns text-center">
                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
                        <a href="book-list.php" class="btn btn-primary indent">Cancel</a>
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
        $isbn = $_GET['isbn'];
            
        // Create SQL query to delete member
        $sql_delete = "DELETE FROM books WHERE BookID=$isbn";

        // Execute the query 
        $res_delete = mysqli_query($conn, $sql_delete);

        // Check whether the query executed sucessfully or not
        if($res_delete==TRUE){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='success'>Book deleted successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/book-list.php');
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete book.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/book-list.php');
        }
    }
?>