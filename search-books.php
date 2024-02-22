<?php include('partials-front/header.php'); ?>

<!-- Book Search Section Starts Here -->
<section class="book-search text-center">
    <div class="container">
        <?php 
            // Get the search keyword
            $search = $_POST['search'];
        ?>  
        <h2 class="">Books on your search <a href="<?php echo SITEURL; ?>book-catalog.php" class="">"<?php echo $search;?>"</a></h2>
    </div>
</section>
<!-- Book Search Section Ends Here -->

<!-- Book Catalog Section Starts Here -->
<section class="page-container">
    <div class="container">
        <?php
            //SQL Query to get books based on search keyword
            $sql = "SELECT * FROM books WHERE 
            Title LIKE '%$search%' OR 
            Genre LIKE '%$search%' OR 
            Author LIKE '%$search%'";
            
            // Execute the query
            $res = mysqli_query($conn, $sql);
            // Count rows
            $count = mysqli_num_rows($res);

            // Query to get all loaned books
            $sql_loan = "SELECT * FROM loaned";
            // Execute the query
            $res_loan = mysqli_query($conn, $sql_loan);
            // Count Rows to check whether we have data in the database or not
            $count_loan = mysqli_num_rows($res_loan);

            // Check whether book available
            if($count>0){
                // Food available
                while($row=mysqli_fetch_assoc($res)){
                    // Get the details
                    $isbn = $row['BookID'];
                    $title = $row['Title'];
                    $author = $row['Author'];
                    $genre = $row['Genre'];
                    $num_copies = $row['NumofCopies'];
                    $image_name = $row['image_name'];
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
                echo "<div class='error'>Book not found.</div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Book Catalog Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
