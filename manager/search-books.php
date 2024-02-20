<?php include('partials/header.php'); ?>

    <!-- Book Search Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            <?php 
                // Get the search keyword
                $search = $_POST['search'];
            ?>  
            
            <h2 class="">Books on your search <a href="<?php echo SITEURL; ?>manager/book-list.php" class="">"<?php echo $search;?>"</a></h2>

        </div>
    </section>
    <!-- Book Search Section Ends Here -->

    <!-- Book Catalog Section Starts Here -->
    <section class="page-container">
        <div class="container">
        <table class="tbl-list">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Copies</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php 
                    //SQL Query to get foods based on search keyword
                    $sql = "SELECT * FROM books WHERE 
                    Title LIKE '%$search%' OR 
                    Genre LIKE '%$search%' OR 
                    Author LIKE '%$search%'";
                    
                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Check whether the query is executed or not
                    if($res==TRUE){
                        // Count Rows to check whether we have data in the database or not
                        $count = mysqli_num_rows($res); // Function to get all the rows in the database

                        if($count>0){
                            while($rows=mysqli_fetch_assoc($res)){
                                $isbn = $rows['BookID'];
                                $title = $rows['Title'];
                                $author = $rows['Author'];
                                $genre = $rows['Genre'];
                                $num_copies = $rows['NumofCopies'];
                                $image_name = $rows['image_name'];

                                ?>
                                <tr>
                                    <td><?php echo $isbn; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $author; ?></td>
                                    <td><?php echo $genre; ?></td>
                                    <td><?php echo $num_copies; ?></td>
                                    <td>
                                        <?php 
                                            // Check whether image name is avaible or not
                                            if($image_name != ""){
                                                // Display the image
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/books/<?php echo $image_name; ?>" width="100px" >

                                                <?php 
                                            }else{
                                                // Display the message
                                                echo "<div class='error'>Image not added.</div>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>manager/edit-book.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Edit Book</a>
                                        <a href="<?php echo SITEURL; ?>manager/remove-book.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary">Remove Book</a>
                                    </td>
                                </tr>
                                <?php 
                            }
                        }else{
                            // No data
                        }
                    }
                ?> 

            </table>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Book Catalog Section Ends Here -->

    <?php include('partials/footer.php'); ?>
