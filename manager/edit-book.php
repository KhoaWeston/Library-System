<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="book-catalog">
        <div class="container">
            <h2 class="text-center">Edit Book</h2>
            
            <?php 
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display message
                    unset($_SESSION['update']); // Remove message
                }
            ?>

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
                        $current_image = $row['image_name'];
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'manager/search-book.php');
                    }
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-full">
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
                                    <img src="<?php echo SITEURL; ?>images/books/<?php echo $current_image; ?>" width="150px" >

                                    <?php 
                                }else{
                                    // Display the message
                                    echo "<div class='error'>Image not added.</div>";
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>New Image: </td>
                        <td>
                            <input type="file" name="new_image">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
                            <input type="submit" name="submit" value="Update Book" class="btn btn-primary">
                        </td>
                        <td>
                            <a href="search-books.php" class="btn btn-primary">Cancel</a>
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
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre']; 
        $num_copies = $_POST['num_copies']; 

        // SQL Query to save the data into the database
        $sql = "UPDATE books SET
            Title='$title',
            Author='$author',
            Genre='$genre',
            NumofCopies='$num_copies'
        WHERE BookID='$isbn'";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql);

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['update'] = "<div class='success'>Book updated successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/search-books.php');
       }else{
            // Create a session variable to display message
            $_SESSION['update'] = "<div class='success'>Book updated successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/edit-book.php');
       }
    }
?>