<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Place Order?</h2>
            
            <?php 
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display message
                    unset($_SESSION['update']); // Remove message
                }
            ?>

            <?php 
                // Get the ID of the member
                $id = $_SESSION['user'];
                
                // Get the ID of the selected book
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
                        header('location:'.SITEURL.'book-catalog.php');
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
                                    <td>
                                        <?php echo $id; ?>
                                    </td>
                                </tr>    
                            
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
    if(isset($_POST['submit'])){  
        // Get date data from form 
        $from_date = date("Y-m-d H:i:s");
        $to_date = date('Y-m-d H:i:s', strtotime('+1 week'));
        
        // SQL Query to save the data into the loaned database
        $sql1 = "INSERT INTO loaned SET
            UID='$id',
            BookID='$isbn',
            LoanDate='$from_date',
            ToBeReturnedDate='$to_date'
        ";

        // Execute query and save data into database
        $res1 = mysqli_query($conn, $sql1) or die(mysqli_error());

        // check whether the query is executed 
        if($res1==TRUE){                  
            // Create SQL Query to get user details
            $sql2="SELECT * FROM user WHERE UID=$id";

            // Execute the query
            $res2=mysqli_query($conn, $sql2);

            // Check whether the query is executed or not
            if($res2==TRUE){
                // Get the details
                $row2=mysqli_fetch_assoc($res2);

                // Add 1 to current books out value
                $books_out = $row2['BooksOut'];

                if($books_out == 6){
                    // Create SQL Query to update books out value
                    $sql3 = "UPDATE user SET BooksOut='($books_out+1)' WHERE UID=$id";

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

                            $num_copies = $row4['NumofCopies'];
                            if($num_copies != 0){
                                // Create SQL Query to update books out value
                                $sql5 = "UPDATE books SET NumofCopies='($new_num_copies-1)' WHERE BookID=$isbn";

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
                                // Create a session variable to display message
                                $_SESSION['ordered'] = "<div class='error'>No more copies</div>";
                                // Redirect Page
                                header("location:".SITEURL.'book-catalog.php');
                            }
                        }else{
                            // Redirect to search members
                            header('location:'.SITEURL.'book-catalog.php');
                        }
                    }else{
                        // Failed to update user value
                    }
                }else{
                    // Create a session variable to display message
                    $_SESSION['ordered'] = "<div class='error'>Max reserved</div>";
                    // Redirect Page
                    header("location:".SITEURL.'book-catalog.php');
                }
            }else{
                // Redirect to search members
                header('location:'.SITEURL.'book-catalog.php');
            }
       }else{
            // Create a session variable to display message
            $_SESSION['ordered'] = "<div class='error'>Failed to checkout.</div>";
            // Redirect Page
            header("location:".SITEURL.'place-order.php');
       }
    }
?>