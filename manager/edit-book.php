<?php include('partials/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Edit Book</h2>
        
        <?php 
            // Turn on output buffering
            ob_start(); 

            // Display error message
            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; // Display message
                unset($_SESSION['update']); // Remove message
            }
        ?>

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
                // Check whether we have member data or not
                if($count_details==1){
                    // Get the details
                    $row_details=mysqli_fetch_assoc($res_details);

                    $title = $row_details['Title']; 
                    $author = $row_details['Author'];
                    $genre = $row_details['Genre']; 
                    $num_copies = $row_details['NumofCopies']; 
                    $current_image = $row_details['image_name'];
                }else{
                    // Redirect to search books
                    header('location:'.SITEURL.'manager/search-book.php');
                }
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="width-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Author: </td>
                    <td>
                        <input type="text" name="author" value="<?php echo $author; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Genre: </td>
                    <td>
                        <input type="text" name="genre" value="<?php echo $genre; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Number of Copies: </td>
                    <td>
                        <input type="number" name="num_copies" value="<?php echo $num_copies; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php 
                            if($current_image != ""){
                                // Display the image 
                                ?>
                                <img src="<?php echo SITEURL; ?>images/books/<?php echo $current_image; ?>" width="150px">
                                <?php 
                            }else{
                                // Display the message
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                        <br/><br/>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="row-btns text-center">
                        <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                        <a href="book-list.php" class="btn btn-primary indent">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                // Get all the values from form to update
                $isbn = $_POST['isbn'];
                $title = $_POST['title'];
                $author = $_POST['author'];
                $genre = $_POST['genre']; 
                $num_copies = $_POST['num_copies']; 
                $current_image = $_POST['current_image'];

                // Updating new image if selected 
                // Check whether the image is selected or not
                if(isset($_FILES['image']['name'])){
                    echo "check";
                    // Get the image details
                    $image_name = $_FILES['image']['name'];

                    // Check whether the image is available or not
                    if($image_name != ""){
                        // Image available
                        // Auto rename our image
                        // Get the extension of our image (.jpg...)
                        $ext = end(explode('.', $image_name));

                        // Rename the image
                        $image_name = "Book_cover_".rand(000, 999).'.'.$ext; 

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/books/".$image_name;

                        // Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Check whether the image is uploaded or not
                        // And if the image is not uploaded then
                        if($upload==false){
                            // Set message
                            $_SESSION['update'] = "<div class='error'>Failed to upload image.</div>";
                            // Redirect Page
                            header("location:".SITEURL.'manager/edit-book.php?isbn='.$isbn);
                            // Stop the process
                            die();
                        }

                        // Remove the current image
                        if($current_image != ""){
                            $remove_path = "../images/books/".$current_image;

                            $remove = unlink($remove_path);

                            // Check whether the image is removed
                            // If failed to remove then display
                            if($remove==false){
                                // Failed to remove image
                                $_SESSION['update'] = "<div class='error'>Failed to remove current image.</div>";
                                // Redirect Page
                                header("location:".SITEURL.'manager/edit-book.php?isbn='.$isbn);
                                // Stop the process
                                die();
                            }
                        }
                    }else{
                        $image_name = $current_image;
                    }
                }else{
                    $image_name = $current_image;
                }

                // SQL Query to save the data into the database
                $sql_update = "UPDATE books SET
                    Title='$title',
                    Author='$author',
                    Genre='$genre',
                    NumofCopies='$num_copies',
                    image_name='$image_name'
                WHERE BookID='$isbn'";

                // Execute query and save data into database
                $res_update = mysqli_query($conn, $sql_update);

                // check whether the query is executed 
                if($res_update==TRUE){        
                    // Create a session variable to display message
                    $_SESSION['update'] = "<div class='success'>Book updated successfully.</div>";
                    // Redirect Page
                    header("location:".SITEURL.'manager/book-list.php');
                    // Flush output buffer and turn off output buffering
                    ob_end_flush();
                }else{
                    // Create a session variable to display message
                    $_SESSION['update'] = "<div class='success'>Failed to update book</div>";
                    // Redirect Page
                    header("location:".SITEURL.'manager/book-list.php');
                }
            }
        ?>
    </div>
</section>
<!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>
