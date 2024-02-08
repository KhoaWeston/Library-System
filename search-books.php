<?php include('partials-front/header.php'); ?>

    <!-- Book Search Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            <?php 
                // Get the search keyword
                $search = $_POST['search'];
            ?>  
            
            <h2 class="text-white">Books on your search <a href="#" class="text-white">"<?php echo $search;?>"</a></h2>

        </div>
    </section>
    <!-- Book Search Section Ends Here -->

    <!-- Book Catalog Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <?php
                //SQL Query to get foods based on search keyword
                $sql = "SELECT * FROM books WHERE Title LIKE '%$search%'";
                
                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count rows
                $count = mysqli_num_rows($res);

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
                                <h4><?php echo $title; ?></h4>
                                <p class="book-author"><?php echo $author; ?></p>
                                <p class="book-ISBN"><?php echo $isbn; ?></p>
                                <p class="book-num-copies"><?php echo $num_copies; ?></p>
                                <p class="book-num-copies"><?php echo $genre; ?></p>
                                <p class="book-detail">
                                    [Description]
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>place-order.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Order Now</a>
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
