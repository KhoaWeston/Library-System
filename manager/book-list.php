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
            // Display book changes messages
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; 
                unset($_SESSION['add']); 
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; 
                unset($_SESSION['delete']); 
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; 
                unset($_SESSION['update']); 
            }
        ?>
        <br />
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
                // Pagination 
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page = 1;
                }

                $num_per_page = 05; // Number of books displayed per page
                $start_from = ($page-1)*$num_per_page;

                // Query to get books for page
                $sql_page = "SELECT * FROM books ORDER BY reg_date DESC LIMIT $start_from, $num_per_page";
                // Execute the query
                $res_page = mysqli_query($conn, $sql_page);

                // Check whether the query is executed or not
                if($res_page==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count_page = mysqli_num_rows($res_page); // Function to get all the rows in the database

                    if($count_page>0){
                        while($rows_page=mysqli_fetch_assoc($res_page)){
                            $isbn = $rows_page['BookID'];
                            $title = $rows_page['Title'];
                            $author = $rows_page['Author'];
                            $genre = $rows_page['Genre'];
                            $num_copies = $rows_page['NumofCopies'];
                            $image_name = $rows_page['image_name'];

                            ?>
                            <tr>
                                <td class="col-id"><?php echo $isbn; ?></td>
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
        <br/>
        <?php
        // Query to get all books
        $sql_books = "SELECT * FROM books";
        $res_books = mysqli_query($conn ,$sql_books);
        $rows_books = mysqli_num_rows($res_books );
        
        $count_books = ceil($rows_books/$num_per_page);

        // Display Pagination buttons
        ?>
        <div class="clearfix"></div><br/>
        <div class="text-center">
            <?php
            if($page > 1){
                ?>
                <a href="<?php echo SITEURL; ?>manager/book-list.php?page=<?php echo $page-1; ?>" class="btn btn-primary">Previous</a>
                <?php
            }
            
            for($i = 1; $i <= $count_books; $i++){
                ?>
                <a href="<?php echo SITEURL; ?>manager/book-list.php?page=<?php echo $i; ?>" class="btn btn-primary"><?php echo $i; ?></a>
                <?php
            }

            if($page < $count_books){
                ?>
                <a href="<?php echo SITEURL; ?>manager/book-list.php?page=<?php echo $page+1; ?>" class="btn btn-primary">Next</a>
                <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Book Lists Section Ends Here -->

<?php include('partials/footer.php'); ?>