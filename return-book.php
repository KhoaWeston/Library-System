<?php include('partials-front/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Return Book</h2>
        
        <?php 
            // Turn on output buffering
            ob_start();

            // display error messages
            if(isset($_SESSION['return-error'])){
                echo $_SESSION['return-error']; 
                unset($_SESSION['return-error']); 
            }

            // Get the isbn of the selected book
            $isbn=$_GET['isbn'];

            // Create SQL Query to get the book details 
            $sql_detail="SELECT * FROM books WHERE BookID=$isbn";

            // Execute the query
            $res_detail=mysqli_query($conn, $sql_detail);

            // Check whether the query is executed or not
            if($res_detail==TRUE){
                // Check whether the data is available or not
                $count_detail = mysqli_num_rows($res_detail);
                // Check whether we have member data or  not
                if($count_detail==1){
                    // Get the details
                    $row_detail=mysqli_fetch_assoc($res_detail);
                    
                    // Create SQL Query to get the loan details
                    $sql_loan="SELECT * FROM loaned WHERE BookID=$isbn";

                    // Execute the query
                    $res_loan=mysqli_query($conn, $sql_loan);

                    // Get the details
                    $row_loan=mysqli_fetch_assoc($res_loan);


                    $title = $row_detail['Title']; 
                    $author = $row_detail['Author'];
                    $genre = $row_detail['Genre']; 
                    $num_copies = $row_detail['NumofCopies']; 
                    $image_name = $row_detail['image_name'];

                    $from_date = $row_loan['LoanDate'];
                    $to_date = $row_loan['ToBeReturnedDate'];
                }
            }
        ?>

        <table class="tbl-confirm width-full">
            <tr>
                <td class="confirm-col-img">
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
                    <form action="" method="POST">
                        <table class="tbl width-full">
                            <tr>
                                <td class="text-bold">ISBN: </td>
                                <td><?php echo $isbn; ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-bold">Title: </td>
                                <td><?php echo $title; ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-bold">Author: </td>
                                <td><?php echo $author; ?></td>
                            </tr>

                            <tr>
                                <td class="text-bold">Date Checked Out: </td>
                                <td><?php echo date("m-d-Y", strtotime($from_date)); ?></td>
                            </tr>

                            <tr>
                                <td class="text-bold">Return Date: </td>
                                <td><?php echo date("m-d-Y", strtotime($to_date)); ?></td>
                            </tr>                            
                        </table>

                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary indent">
                        <a href="reserved.php" class="btn btn-primary indent">Cancel</a>
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
        // Get id of user
        $id = $_SESSION['user'];
        // Get the ID of member to be deleted
        $isbn = $_GET['isbn'];
            
        // Create SQL query to delete member
        $sql_delete = "DELETE FROM loaned WHERE BookID='$isbn' AND UID='$id'";

        // Execute the query 
        $res_delete = mysqli_query($conn, $sql_delete);

        // Check whether the query executed sucessfully or not
        if($res_delete==TRUE){
            // Create SQL Query to get user details
            $sql_user="SELECT * FROM user WHERE UID=$id";

            // Execute the query
            $res_user=mysqli_query($conn, $sql_user);

            // Check whether the query is executed or not
            if($res_user==TRUE){
                // Get the details
                $row_user=mysqli_fetch_assoc($res_user);

                // Subtract 1 to user's books out value
                $new_books_out = $row_user['BooksOut'] - 1;

                // Create SQL Query to update books out value
                $sql_user_update = "UPDATE user SET BooksOut='$new_books_out' WHERE UID=$id";

                // Execute the query
                $res_user_update=mysqli_query($conn, $sql_user_update);

                // Check whether the query is executed or not
                if($res_user_update==TRUE){
                    // Create SQL Query to get user details
                    $sql_book="SELECT * FROM books WHERE BookID=$isbn";

                    // Execute the query
                    $res_book=mysqli_query($conn, $sql_book);

                    // Check whether the query is executed or not
                    if($res_book==TRUE){
                        // Get the details
                        $row_book=mysqli_fetch_assoc($res_book);

                        // Add 1 to current number of copies value
                        $new_num_copies = $row_book['NumofCopies'] + 1;

                        // Create SQL Query to update books out value
                        $sql_book_update = "UPDATE books SET NumofCopies='$new_num_copies' WHERE BookID=$isbn";

                        // Execute the query
                        $res_book_update=mysqli_query($conn, $sql_book_update);

                        // Check whether the query is executed or not
                        if($res_book_update==TRUE){
                            // Create a session variable to display message
                            $_SESSION['return'] = "<div class='success'>Book Returned Successfully</div>";
                            // Redirect Page
                            header("location:".SITEURL.'book-catalog.php');
                            // Flush the output buffer and turn off output buffering
                            ob_end_flush();
                        }else{
                            // Failed to update book value
                            $_SESSION['return'] = "<div class='error'>Failed to update book value</div>";
                            // Redirect Page
                            header("location:".SITEURL.'reserved.php');
                        }
                    }else{
                        // Failed to get book details
                        $_SESSION['return'] = "<div class='error'>Failed to get book details</div>";
                        header("location:".SITEURL.'reserved.php');
                    }
                }else{
                    // Failed to update user value
                    $_SESSION['return'] = "<div class='error'>Failed to update user value</div>";
                    header("location:".SITEURL.'reserved.php');
                }
            }else{
                // Failed to get user details
                header('location:'.SITEURL.'book-catalog.php');
                $_SESSION['return'] = "<div class='error'>Failed to get user details</div>";
                header("location:".SITEURL.'reserved.php');
            }
        }else{
            // Failed to delete loaned book
            $_SESSION['return'] = "<div class='error'>Failed to Return book.</div>";
            header("location:".SITEURL.'reserved.php');
        }
    }
?>