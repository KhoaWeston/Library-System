<?php include('partials-front/header.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container text-center">
    <div class="confirm-container">
        <h2 class="text-center">Place Order?</h2>
        
        <?php 
            // Turn on output buffering
            ob_start(); 

            // Display error messages
            if(isset($_SESSION['order-error'])){
                echo $_SESSION['order-error']; 
                unset($_SESSION['order-error']); 
            }
        ?>

        <?php 
            // Get the ID of the member
            $id = $_SESSION['user'];
            
            // Get the ID of the selected book
            $isbn=$_GET['isbn'];

            // Create SQL Query to get the books details
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

                    $title = $row_detail['Title']; 
                    $author = $row_detail['Author'];
                    $genre = $row_detail['Genre']; 
                    $num_copies = $row_detail['NumofCopies']; 
                    $image_name = $row_detail['image_name'];
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
                                <td class="text-bold">User ID : </td>
                                <td><?php echo $id; ?></td>
                            </tr>    
                        
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
                                <td class="text-bold">Number of Copies: </td>
                                <td><?php echo $num_copies; ?></td>
                            </tr>

                            <tr>
                                <td class="text-bold">Reservation Duration: </td>
                                <td>
                                    <input type="hidden" name="res_time" value="error">
                                    <input type="radio" name="res_time" value="1_week"> 1 Week
                                    <input type="radio" name="res_time" value="4_week"> 4 Week
                                </td>
                            </tr>
                        </table>

                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary indent">
                        <a href="book-catalog.php" class="btn btn-primary indent">Cancel</a>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</section>
<!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<?php 
    if(isset($_POST['submit'])){  
        // Set reservation and due dates 
        $from_date = date("Y-m-d H:i:s");
        $res_timee = $_POST['res_time'];
        if($res_timee == "1_week"){
            $to_date = date('Y-m-d H:i:s', strtotime('+1 week'));
        }else if($res_timee == "4_week"){
            $to_date = date('Y-m-d H:i:s', strtotime('+4 week'));
        }else if($res_timee == "error"){
            // Create a session variable to display message
            $_SESSION['order-error'] = "<div class='error'>Select Reservation Duration</div>";
            // Redirect Page
            header("location:".SITEURL.'place-order.php?isbn='.$isbn);
            exit();
        }

        // Create SQL Query to get book details
        $sql_book="SELECT * FROM books WHERE BookID=$isbn";
        // Execute the query
        $res_book=mysqli_query($conn, $sql_book);

        // Check whether the query is executed or not
        if($res_book==TRUE){
            // Get the details
            $row_book=mysqli_fetch_assoc($res_book);
            $num_copies = $row_book['NumofCopies'];
            
            if($num_copies > 0){
                // Create SQL Query to get user details
                $sql_user="SELECT * FROM user WHERE UID=$id";
                $res_user=mysqli_query($conn, $sql_user);
                if($res_user==TRUE){
                    $row_user=mysqli_fetch_assoc($res_user);
                    $books_out = $row_user['BooksOut'];

                    if(($books_out < 6 && $row_user['MemberType']=="member") || ($books_out < 12 && $row_user['MemberType']=="manager")){
                        // SQL Query to save the data into the loaned database
                        $sql_order = "INSERT INTO loaned SET
                        UID='$id',
                        BookID='$isbn',
                        LoanDate='$from_date',
                        ToBeReturnedDate='$to_date'
                        ";

                        $res_order = mysqli_query($conn, $sql_order) or die(mysqli_error());
                        if($res_order==TRUE){ 
                            // Add 1 to user's current books out value
                            $new_books_out = $books_out + 1;

                            // Create SQL Query to update user's books out value
                            $sql_user_update = "UPDATE user SET BooksOut='$new_books_out' WHERE UID=$id";
                            $res_user_update=mysqli_query($conn, $sql_user_update);
                            if($res_user_update==TRUE){
                                // Subtract 1 to current book's number of copies value
                                $new_num_copies = $num_copies - 1;

                                // Create SQL Query to update books out value
                                $sql_book_update = "UPDATE books SET NumofCopies='$new_num_copies' WHERE BookID=$isbn";
                                $res_book_update=mysqli_query($conn, $sql_book_update);
                                if($res_book_update==TRUE){
                                    // Successfuly checked book out
                                    // Create a session variable to display message
                                    $_SESSION['return'] = "<div class='success'>Book Ordered Successfully</div>";
                                    // Redirect Page
                                    header("location:".SITEURL.'book-catalog.php');
                                    // Flush the output buffer and turn off output buffering
                                    ob_end_flush();
                                }else{
                                    // Failed to update book
                                    $_SESSION['order'] = "<div class='error'>Failed to update book.</div>";
                                    header("location:".SITEURL.'book-catalog.php');
                                }
                            }else{
                                // Failed to update user
                                $_SESSION['order'] = "<div class='error'>Failed to update user.</div>";
                                header("location:".SITEURL.'book-catalog.php');
                            }
                        }else{
                            // Failed to update loaned database
                            $_SESSION['order'] = "<div class='error'>Failed to order book.</div>";
                            header("location:".SITEURL.'book-catalog.php');
                        }
                    }else{
                        // Max number of books reserved
                        $_SESSION['order'] = "<div class='error'>You've reached the maximum number of books checked out.</div>";
                        header("location:".SITEURL.'book-catalog.php');
                    }
                }else{
                    // Failed to get user details
                    $_SESSION['order'] = "<div class='error'>Failed to get user details.</div>";
                    header("location:".SITEURL.'book-catalog.php');
                }
            }else{
                // No copies available
                $_SESSION['order'] = "<div class='error'>No copies are available.</div>";
                header("location:".SITEURL.'book-catalog.php');
            }
        }else{
            // Failed to get book details
            $_SESSION['order'] = "<div class='error'>Failed to get book details.</div>";
            header("location:".SITEURL.'book-catalog.php');
        }
    }
?>