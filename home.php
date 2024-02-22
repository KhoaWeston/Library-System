<?php include('partials-front/header-home.php'); ?>

<!-- Main Section Starts Here -->
<section class="page-container">
    <div class="container">
        <?php 
            // Successful login message
            if(isset($_SESSION['login'])){
                echo $_SESSION['login']; 
                unset($_SESSION['login']); 
            }
            if(isset($_SESSION['signup'])){
                echo $_SESSION['signup']; 
                unset($_SESSION['signup']); 
            }
            
            // Query to get all books
            $sql_books = "SELECT * FROM books ORDER BY reg_date DESC";
            $res_books = mysqli_query($conn, $sql_books);
            if($res_books==TRUE){
                $count_books = mysqli_num_rows($res_books); // Count number of rows i.e. number of books
            }

            // Query to get all loaned books
            $sql_loaned = "SELECT * FROM loaned";
            $res_loaned = mysqli_query($conn, $sql_loaned);
            if($res_loaned==TRUE){
                $count_loaned = 0;
                $count_due = 0;
                while($rows_loaned=mysqli_fetch_assoc($res_loaned)){
                    if($rows_loaned['UID'] == $_SESSION['user']){
                        $count_loaned++; // Count number of books are loaned
                    }
                    if($rows_loaned['UID'] == $_SESSION['user'] && $rows_loaned['ToBeReturnedDate'] < date("Y-m-d H:i:s")){
                        $count_due++; // Count number of loaned books are overdue
                    }
                }
            }

            // Query to get number of genres
            $sql_genres = "SELECT COUNT(DISTINCT Genre) AS count_genres FROM books";
            $res_genres = mysqli_query($conn, $sql_genres);
            if($res_genres==TRUE){
                $rows_genres=mysqli_fetch_assoc($res_genres);
                $count_genres = $rows_genres['count_genres'];
            }
        ?>
        
        <!-- Quick Info Section Begins Here -->
        <br/>
        <div class="dash-container"> 
            <h2><?php echo $count_books; ?></h2>
            <p>Number of books in catalog</p>
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
            <h2><?php echo $count_genres; ?></h2>
            <p>Number of genres</p>
        </div>
        <!-- Quick Info Section Ends Here -->

        <!-- Recently Added Section Begins Here --> 
        <div class="comp-container"> 
            <h2>Recently Added</h2>
            <?php 
                $ctr = 0;
                while($rows_books=mysqli_fetch_assoc($res_books)){
                    $image_name = $rows_books['image_name'];
                    // Display book cover if available
                    if($image_name != ""){
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>place-order.php?isbn=<?php echo $rows_books['BookID']; ?>">
                            <img src="<?php echo SITEURL; ?>images/books/<?php echo $image_name; ?>" class="img-home img-curve" >
                        </a>

                        <?php 
                        $ctr++;
                    }
                    // Displays only 3 most recently added books
                    if($ctr >= 3){
                        break;
                    }
                }
            ?>
        </div>
        <!-- Recently Added Section Ends Here --> 

        <!-- Upcoming Deadlines Section Begins Here -->
        <div class="comp-container"> 
            <h2>Upcoming Deadlines</h2>
            <?php 
                $flag = FALSE;
                foreach($res_loaned as $rows_loaned0){
                    // Displays books with deadlines within 3 days of the current date
                    if($rows_loaned0['ToBeReturnedDate'] < date('Y-m-d H:i:s', strtotime('+3 day'))){
                        $isbn = $rows_loaned0['BookID']; // Gets ISBN of book
                        // Query to get all title of book given its isbn
                        $sql_title = "SELECT Title AS title FROM books WHERE BookID='$isbn'";
                        $res_title = mysqli_query($conn, $sql_title);
                        if($res_title==TRUE){
                            $rows_title=mysqli_fetch_assoc($res_title);
                            echo $rows_title['title'], " to be returned by ", date("m-d-Y", strtotime($rows_loaned0['ToBeReturnedDate']));
                        }
                        $flag=TRUE;
                        ?> <br/><br/> <?php
                    }
                }
                // If no upcoming deadlines then display message
                if($flag==FALSE){
                    echo "No upcoming deadlines";
                }
            ?>
        </div>
        <!-- Upcoming Deadlines Section Ends Here -->

    </div>
</section>
<!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>