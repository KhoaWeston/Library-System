<?php include('partials-front/header.php'); ?>

<!-- Book Search Section Starts Here -->
<section class="book-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>search-books.php" method="POST">
            <input type="search" name="search" placeholder="Search for Book...." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- Book Search Section Ends Here -->

<!-- Book Catalog Section Starts Here -->
<section class="page-container">
    <div class="container">
        <h2 class="text-center">Book Catalog</h2>

        <?php 
            // Query to get all books
            $sql = "SELECT * FROM books";
            // Execute the query
            $res = mysqli_query($conn, $sql);
            
            // Query to get all loaned books
            $sql2 = "SELECT * FROM loaned";
            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Check whether the query is executed or not
            if($res==TRUE && $res2 == TRUE){
                // Count Rows to check whether we have data in the database or not
                $count = mysqli_num_rows($res); // Function to get all the rows in the database
                $count2 = mysqli_num_rows($res2);

                if($count>0){
                    while($rows=mysqli_fetch_assoc($res)){
                        $isbn = $rows['BookID'];
                        $title = $rows['Title'];
                        $author = $rows['Author'];
                        $genre = $rows['Genre'];
                        $num_copies = $rows['NumofCopies'];
                        $image_name = $rows['image_name'];

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
                                        <td class="text-bold">ISBN: </td>
                                        <td>
                                            <?php echo $isbn; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold">Number of Copies: </td>
                                        <td>
                                            <?php echo $num_copies; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold">Genre: </td>
                                        <td>
                                            <?php echo $genre; ?>
                                        </td>
                                    </tr>
                                </table>

                                <?php 
                                    if($num_copies > 0){ 
                                        if($count2 > 0){
                                            $flag = FALSE;
                                            foreach($res2 as $rows2){
                                                if($isbn == $rows2['BookID']){
                                                    echo "<div class='error'>Already checked out.</div>";
                                                    $flag = TRUE;
                                                }
                                            }
                                            if($flag == FALSE){
                                                ?> 
                                                <a href="<?php echo SITEURL; ?>place-order.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Order Now</a>
                                                <?php
                                            }
                                        }else{
                                            ?> 
                                            <a href="<?php echo SITEURL; ?>place-order.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Order Now</a>
                                            <?php
                                        }
                                    }else{
                                        echo "<div class='error'>No copies to checkout.</div>";
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <?php 
                    }
                }else{
                    // No data
                    echo "<div class='error'>No books yet.</div>";
                }
            }
        ?>

        <div class="clearfix"></div>

    </div>

</section>
<!-- Book Catalog Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
