<?php include('partials-front/header.php'); ?>

    <!-- Book Catalog Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <h2 class="text-center">Reserved Books</h2>

            <?php 
                    // Query to get all members
                    $sql = "SELECT * FROM loaned";
                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Check whether the query is executed or not
                    if($res==TRUE){
                        // Count Rows to check whether we have data in the database or not
                        $count = mysqli_num_rows($res); // Function to get all the rows in the database

                        if($count>0){
                            while($rows=mysqli_fetch_assoc($res)){
                                $isbn = $rows['BookID'];
                                $from_date = $rows['LoanDate'];
                                $to_date = $rows['ToBeReturnedDate'];
                                
                                // Create SQL Query to get the details
                                $sql2="SELECT * FROM books WHERE BookID=$isbn";

                                // Execute the query
                                $res2=mysqli_query($conn, $sql2);

                                // Check whether the data is available or not
                                $count2 = mysqli_num_rows($res2);
                                // Check whether we have member data or  not
                                if($count2==1){
                                    // Get the details
                                    // echo "member available";
                                    $rows=mysqli_fetch_assoc($res2);

                                    $title = $rows['Title'];
                                    $author = $rows['Author'];
                                    $genre = $rows['Genre'];
                                    $num_copies = $rows['NumofCopies'];
                                    $image_name = $rows['image_name'];
                                }

                                ?>

                                <div class="book-catalog-box">
                                    <div class="book-catalog-img">
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

                                    <div class="book-catalog-desc">
                                        <table class="tbl width-full">
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
                                        </table>
                                        <a href="<?php echo SITEURL; ?>return-book.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Return Now</a>
                                    </div>

                                </div>

                                
                                <?php 
                            }
                        }else{
                            // No data
                        }
                    }
                ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Book Catalog Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
