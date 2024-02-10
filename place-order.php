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
                        header('location:'.SITEURL.'search-books.php');
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
    if(isset($_POST['submit']))
    {   
        $from_date = date("Y-m-d H:i:s");
        $to_date = date('Y-m-d H:i:s', strtotime('+1 week'));
        
        // SQL Query to save the data into the database
        $sql = "INSERT INTO loaned SET
            UID='$id',
            BookID='$isbn',
            LoanDate='$from_date',
            ToBeReturnedDate='$to_date'
        ";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['ordered'] = "<div class='success'>Checkout Successful</div>";
            // Redirect Page
            header("location:".SITEURL.'book-catalog.php');
       }else{
            // Create a session variable to display message
            $_SESSION['ordered'] = "<div class='error'>Failed to checkout.</div>";
            // Redirect Page
            header("location:".SITEURL.'place-order.php');
       }
    }
?>