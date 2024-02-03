<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <h2 class="text-center">Add Book</h2>
            
            <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display message
                    unset($_SESSION['add']); // Remove message
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-full">
                    <tr>
                        <td>ISBN: </td>
                        <td>
                            <input type="number" name="isbn" placeholder="Book ISPN">
                        </td>
                    </tr>

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Book Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Author: </td>
                        <td>
                            <input type="text" name="author" placeholder="Book Author">
                        </td>
                    </tr>

                    <tr>
                        <td>Genre: </td>
                        <td>
                            <input type="text" name="genre" placeholder="Book Genre">
                        </td>
                    </tr>

                    <tr>
                        <td>Number of Copies: </td>
                        <td>
                            <input type="number" name="num_copies" placeholder="Number of Copies">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Book" class="btn btn-primary">
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
        // Get data from form
        $isbn = $_POST['isbn'];
        $title = $_POST['title']; 
        $author = $_POST['author'];
        $genre = $_POST['genre']; 
        $num_copies = $_POST['num_copies']; 

        // SQL Query to save the data into the database
        $sql = "INSERT INTO books SET
            BookID='$isbn',
            Title='$title',
            Author='$author',
            Genre='$genre',
            NumofCopies='$num_copies'
        ";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Book added successfully.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/search-books.php');
       }else{
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add book.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/add-book.php');
       }
    }
?>