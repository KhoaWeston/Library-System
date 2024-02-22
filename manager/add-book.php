<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Add Book</h2>
            
            <?php 
                // Start output buffering
                ob_start();
                // Display error messages
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display message
                    unset($_SESSION['add']); // Remove message
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="width-full">
                    <tr>
                        <td>ISBN: </td>
                        <td>
                            <input type="number" name="isbn" placeholder="Book ISBN" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Book Title" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Author: </td>
                        <td>
                            <input type="text" name="author" placeholder="Book Author" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Genre: </td>
                        <td>
                            <input type="text" name="genre" placeholder="Book Genre" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Number of Copies: </td>
                        <td>
                            <input type="number" name="num_copies" placeholder="Number of Copies" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="row-btns text-center">
                            <input type="submit" name="submit" value="Add Book" class="btn btn-primary">
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
        // Get data from form
        $isbn = $_POST['isbn'];
        $title = $_POST['title']; 
        $author = $_POST['author'];
        $genre = $_POST['genre']; 
        $num_copies = $_POST['num_copies']; 

        // Check whether the image is selected or not and set the calue for image name 
        if(isset($_FILES['image']['name'])){
            // Upload the image
            // To upload the image we need the image name, source path, and dest path
            $image_name = $_FILES['image']['name'];

            // Auto rename our image
            // Get the extension of our image (.jpg...)
            $ext = end(explode('.', $image_name)); // NOTICE: Only variables should be passed by reference in

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
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                // Redirect Page
                header("location:".SITEURL.'manager/add-book.php');
                // Stop the process
                die();
            }
        }else{
            // Dont upload image and set the image
            $image_name="";
        }

        // SQL Query to save the data into the database
        $sql = "INSERT INTO books SET
            BookID='$isbn',
            Title='$title',
            Author='$author',
            Genre='$genre',
            NumofCopies='$num_copies',
            image_name='$image_name'
        ";

        // Execute query and save data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // Check whether the query is executed 
        if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Book added successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/book-list.php'); 
            // Flush output buffer and turn off output buffering
            ob_end_flush();
        }else{
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add book.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/add-book.php');
        }
    }
?>