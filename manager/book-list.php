<?php include('partials/header.php'); ?>

    <!-- Book Search Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>manager/search-books.php" method="POST">
                <input type="search" name="search" placeholder="Search for Book...." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Book Search Section Ends Here -->

    <!-- Book Lists Section Starts Here -->
    <section class="page-container">  
        <div class="container">
            <h2 class="text-center">Book List</h2>

            <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display message
                    unset($_SESSION['add']); // Remove message
                }

                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete']; // Display message
                    unset($_SESSION['delete']); // Remove message
                }

                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display message
                    unset($_SESSION['update']); // Remove message
                }
            ?>
            <br /><br /><br />
            <a href="add-book.php" class="btn btn-primary">Add Book</a>
            
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
                    // Query to get all members
                    $sql = "SELECT * FROM books";
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
    <!-- Book Lists Section Ends Here -->

<?php include('partials/footer.php'); ?>