<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <h2 class="text-center">ShelfSavvy</h2>
            <?php 
                // Display login message
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; 
                    unset($_SESSION['login']); 
                }
                
                // Query to get all the books details
                $sql_books = "SELECT * FROM books";
                // Execute the query
                $res_books = mysqli_query($conn, $sql_books);
                // Check if query is executed 
                if($res_books==TRUE){
                    $count_books = mysqli_num_rows($res_books); // Count number of rows i.e. number of distinct books
                    $count_total = 0;
                    while($rows_books=mysqli_fetch_assoc($res_books)){
                        $count_total += $rows_books['NumofCopies']; // Count total number of copies of books
                    }
                }

                // Query to get all users
                $sql_users = "SELECT * FROM user";
                $res_users = mysqli_query($conn, $sql_users);
                if($res_users==TRUE){
                    $count_users = mysqli_num_rows($res_users); // Count number of users
                }

                // Query to get all loaned books
                $sql_loaned = "SELECT * FROM loaned";
                $res_loaned = mysqli_query($conn, $sql_loaned);
                if($res_loaned==TRUE){
                    $count_loaned = mysqli_num_rows($res_loaned); // Count number of books are being loaned 
                }
                
                $count_due = 0;
                while($rows_due=mysqli_fetch_assoc($res_loaned)){
                    if($rows_due['ToBeReturnedDate'] < date("Y-m-d H:i:s")){
                        $count_due++; // Count number of books are overdue
                    }
                }

                // Query to get number of genres
                $sql_genres = "SELECT COUNT(DISTINCT Genre) AS count_genres FROM books";
                $res_genres = mysqli_query($conn, $sql_genres);
                if($res_genres==TRUE){
                    $rows_genres=mysqli_fetch_assoc($res_genres);
                    $count_genres = $rows_genres['count_genres']; // Count number of genres
                }

                // Query to get number of authors
                $sql_authors = "SELECT COUNT(DISTINCT Author) AS count_authors FROM books";
                $res_authors = mysqli_query($conn, $sql_authors);
                if($res_authors==TRUE){
                    $rows_authors=mysqli_fetch_assoc($res_authors);
                    $count_authors = $rows_authors['count_authors'];
                }
            ?>
            <br/>
            <div class="dash-container"> 
                <h2><?php echo $count_books; ?></h2>
                <p>Number of distinct books</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_users; ?></h2>
                <p>Number of Users</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_loaned; ?></h2>
                <p>Number of books reserved</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_due; ?></h2>
                <p>Number of books overdue</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_total; ?></h2>
                <p>Total number of books</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_genres; ?></h2>
                <p>Number of genres</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count_authors; ?></h2>
                <p>Number of authors</p>
            </div>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>