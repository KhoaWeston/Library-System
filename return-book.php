<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Return Book</h2>
            
            <?php 
                // Get the isbn of the selected book
                $isbn=$_GET['isbn'];

                // Create SQL Query to get the details
                $sql1="SELECT * FROM books WHERE BookID=$isbn";

                // Execute the query
                $res1=mysqli_query($conn, $sql1);

                // Check whether the query is executed or not
                if($res1==TRUE){
                    // Check whether the data is available or not
                    $count1 = mysqli_num_rows($res1);
                    // Check whether we have member data or  not
                    if($count1==1){
                        // Get the details
                        $row1=mysqli_fetch_assoc($res1);
                        
                        // Create SQL Query to get the details
                        $sql2="SELECT * FROM loaned WHERE BookID=$isbn";

                        // Execute the query
                        $res2=mysqli_query($conn, $sql2);

                        // Get the details
                        $row2=mysqli_fetch_assoc($res2);


                        $title = $row1['Title']; 
                        $author = $row1['Author'];
                        $genre = $row1['Genre']; 
                        $num_copies = $row1['NumofCopies']; 
                        $image_name = $row1['image_name'];

                        $from_date = $row2['LoanDate'];
                        $to_date = $row2['ToBeReturnedDate'];
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'/reserved.php');
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
                                    <td class="text-bold">Date Checked Out: </td>
                                    <td>
                                        <?php echo $from_date; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-bold">Return Date: </td>
                                    <td>
                                        <?php echo $to_date; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="submit" name="submit" value="Confirm" class="btn btn-primary">
                                    </td>
                                    <td>
                                        <a href="reserved.php" class="btn btn-primary">Cancel</a>
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
        $sql1 = "DELETE FROM loaned WHERE BookID=$isbn";

        // Execute the query 
        $res1 = mysqli_query($conn, $sql1);

        // Check whether the query executed sucessfully or not
        if($res1==TRUE){
            // Get id of user
            $id = $_SESSION['user'];
            
            // Create SQL Query to get user details
            $sql2="SELECT * FROM user WHERE UID=$id";

            // Execute the query
            $res2=mysqli_query($conn, $sql2);

            // Check whether the query is executed or not
            if($res2==TRUE){
                // Get the details
                $row2=mysqli_fetch_assoc($res2);

                // Add 1 to current books out value
                $new_books_out = $row2['BooksOut'] - 1;

                // Create SQL Query to update books out value
                $sql3 = "UPDATE user SET BooksOut='$new_books_out' WHERE UID=$id";

                // Execute the query
                $res3=mysqli_query($conn, $sql3);

                // Check whether the query is executed or not
                if($res3==TRUE){
                    // Create SQL Query to get user details
                    $sql4="SELECT * FROM books WHERE BookID=$isbn";

                    // Execute the query
                    $res4=mysqli_query($conn, $sql4);

                    // Check whether the query is executed or not
                    if($res4==TRUE){
                        // Get the details
                        $row4=mysqli_fetch_assoc($res4);

                        // Add 1 to current books out value
                        $new_num_copies = $row4['NumofCopies'] + 1;

                        // Create SQL Query to update books out value
                        $sql5 = "UPDATE books SET NumofCopies='$new_num_copies' WHERE BookID=$isbn";

                        // Execute the query
                        $res5=mysqli_query($conn, $sql5);

                        // Check whether the query is executed or not
                        if($res5==TRUE){
                            // Create a session variable to display message
                            $_SESSION['ordered'] = "<div class='success'>Checkout Successful</div>";
                            // Redirect Page
                            header("location:".SITEURL.'book-catalog.php');
                        }else{
                            // Failed to update user value
                        }
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'book-catalog.php');
                    }
                }else{
                    // Failed to update user value
                }
            }else{
                // Redirect to search members
                header('location:'.SITEURL.'book-catalog.php');
            }
        }else{
            // Create a session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete book.</div>";
            // Redirect Page
            header("location:".SITEURL.'/reserved.php');
        }
    }
?>