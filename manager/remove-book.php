<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Remove Book</h2>
            
            <?php 
                // Get the ID of the selected member
                $isbn=$_GET['isbn'];

                // Create SQL Query to get the details
                $sql="SELECT * FROM books WHERE BookID=$isbn";

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

                        $title = $row['Title']; 
                        $author = $row['Author'];
                        $genre = $row['Genre']; 
                        $num_copies = $row['NumofCopies']; 
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'manager/search-books.php');
                    }
                }
            ?>

            <form action="" method="POST">
                <table class="width-full">
                    <tr>
                        <td>ISBN: </td>
                        <td>
                            <?php echo $isbn; ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Title: </td>
                        <td>
                            <?php echo $title; ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Author: </td>
                        <td>
                            <?php echo $author; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Number of Copies: </td>
                        <td>
                            <?php echo $num_copies; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-btns text-center">
                            <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
                            <a href="book-list.php" class="btn btn-primary">Cancel</a>
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
        $sql = "DELETE FROM books WHERE BookID=$isbn";

        // Execute the query 
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed sucessfully or not
        if($res==TRUE){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='success'>Book deleted successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/search-books.php');
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete book.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/remove-book.php');
        }
    }
?>