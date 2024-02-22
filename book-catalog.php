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
            // Successful order or return message
            if(isset($_SESSION['order'])){
                echo $_SESSION['order']; 
                unset($_SESSION['order']); 
            }
            if(isset($_SESSION['return'])){
                echo $_SESSION['return']; 
                unset($_SESSION['return']); 
            }

            // Query to get all books
            $sql_books = "SELECT * FROM books";
            // Execute the query
            $res_books = mysqli_query($conn, $sql_books);
            
            // Query to get all loaned books
            $sql_loan = "SELECT * FROM loaned";
            // Execute the query
            $res_loan = mysqli_query($conn, $sql_loan);

            // Check whether the queries is executed or not
            if($res_books==TRUE && $res_loan == TRUE){
                // Count Rows to check whether we have data in the database or not
                $count_books = mysqli_num_rows($res_books); 
                $count_loan = mysqli_num_rows($res_loan);

                if($count_books>0){
                    while($rows_books=mysqli_fetch_assoc($res_books)){
                        $isbn = $rows_books['BookID'];
                        $title = $rows_books['Title'];
                        $author = $rows_books['Author'];
                        $genre = $rows_books['Genre'];
                        $num_copies = $rows_books['NumofCopies'];
                        $image_name = $rows_books['image_name'];

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
                                        <td class="text-bold">ISBN: </td>
                                        <td><?php echo $isbn; ?></td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold">Number of Copies: </td>
                                        <td><?php echo $num_copies; ?></td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold">Genre: </td>
                                        <td><?php echo $genre; ?></td>
                                    </tr>
                                </table>

                                <?php 
                                    // Check if there are any copies to checkout
                                    if($num_copies > 0){ 
                                        // Check if book is already checked out
                                        if($count_loan > 0){
                                            $flag = FALSE;
                                            foreach($res_loan as $rows_loan){
                                                if($isbn == $rows_loan['BookID'] && $_SESSION['user']==$rows_loan['UID']){
                                                    echo "<div class='error'>Already checked out.</div>";
                                                    $flag = TRUE;
                                                }
                                            }
                                            if($flag == FALSE){
                                                // Book is available
                                                ?> 
                                                <a href="<?php echo SITEURL; ?>place-order.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Order Now</a>
                                                <?php
                                            }
                                        }else{
                                            // Book is not checked out by anybody
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
                    echo "<div class='error'>No books in catalog.</div>";
                }
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Book Catalog Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
