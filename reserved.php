<?php include('partials-front/header.php'); ?>

<!-- Book Catalog Section Starts Here -->
<section class="page-container">
    <div class="container">
        <h2 class="text-center">Reserved Books</h2>

        <?php 
            // Get user id
            $id = $_SESSION['user'];
            // Query to get all loaned books
            $sql_loaned = "SELECT * FROM loaned WHERE UID='$id'";
            // Execute the query
            $res_loaned = mysqli_query($conn, $sql_loaned);

            // Check whether the query is executed or not
            if($res_loaned==TRUE){
                // Count Rows to check whether we have data in the database or not
                $count_loaned = mysqli_num_rows($res_loaned); // Function to get all the rows in the database

                if($count_loaned>0){
                    while($rows_loaned=mysqli_fetch_assoc($res_loaned)){
                        $isbn = $rows_loaned['BookID'];
                        $from_date = $rows_loaned['LoanDate'];
                        $to_date = $rows_loaned['ToBeReturnedDate'];
                        
                        // Create SQL Query to get the loaned books details
                        $sql_detail="SELECT * FROM books WHERE BookID=$isbn";

                        // Execute the query
                        $res_detail=mysqli_query($conn, $sql_detail);

                        // Check whether the data is available or not
                        $count_detail = mysqli_num_rows($res_detail);
                        // Check whether we have book data or not
                        if($count_detail==1){
                            // Get the details
                            // echo "member available";
                            $rows_detail=mysqli_fetch_assoc($res_detail);

                            $title = $rows_detail['Title'];
                            $author = $rows_detail['Author'];
                            $genre = $rows_detail['Genre'];
                            $num_copies = $rows_detail['NumofCopies'];
                            $image_name = $rows_detail['image_name'];
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
                                <div class="error">
                                    <?php 
                                        if(date("Y-m-d H:i:s") > $to_date){
                                            echo "Book is overdue";
                                        }
                                    ?>
                                </div>
                                <a href="<?php echo SITEURL; ?>return-book.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Return Now</a>
                            </div>
                        </div>
                        <?php 
                    }
                }else{
                    // No data
                    echo "No books reserved";
                }
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Book Catalog Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
