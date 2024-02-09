<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Return Book</h2>
            
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
                        $image_name = $row['image_name'];
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'/search-books.php');
                    }
                }
            ?>

            <table class="tbl-confirm width-full">
                <tr>
                    <td>
                        <div class="img-confirm">
                            <?php 
                                // Check whether image name is avaible or not
                                if($image_name != ""){
                                    // Display the image
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/books/<?php echo $image_name; ?>" class="img-responsive img-curve" >

                                    <?php 
                                }else{
                                    // Display the message
                                    echo "<div class='error'>Image not added.</div>";
                                }
                            ?>    
                        </div>
                    </td>
                
                    <td>
                        <form action="" method="POST" class="confirm-desc">
                            <table class="tbl width-full">
                                <tr>
                                    <td class="text-bold">ISBN: </td>
                                    <td>
                                        <?php echo $isbn; ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="text-bold">Title: </td>
                                    <td>
                                        <?php echo $title; ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="text-bold">Author: </td>
                                    <td>
                                        <?php echo $author; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-bold">Number of Copies: </td>
                                    <td>
                                        <?php echo $num_copies; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
                                    </td>
                                    <td>
                                        <a href="book-catalog.php" class="btn btn-primary">Cancel</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<?php 
    if(isset($_POST['submit']))
    {
        // Get the ID of member to be deleted
        $isbn = $_GET['isbn'];
            
        // Create SQL query to delete member
        $sql = "DELETE FROM loaned WHERE BookID=$isbn";

        // Execute the query 
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed sucessfully or not
        if($res==TRUE){
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='success'>Book deleted successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'/search-books.php');
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete book.</div>";
            // Redirect Page
            header("location:".SITEURL.'/remove-book.php');
        }
    }
?>