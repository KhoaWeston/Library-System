<?php include('partials/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <h2 class="text-center">ShelfSavvy</h2>
            <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display message
                    unset($_SESSION['login']); // Remove message
                }
                
                // Query to get all books
                $sql = "SELECT * FROM books";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                if($res==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in the database
                    $count5 = 0;
                    while($rows=mysqli_fetch_assoc($res)){
                        $count5 += $rows['NumofCopies'];
                    }
                }

                // Query to get all users
                $sql3 = "SELECT * FROM user";
                // Execute the query
                $res3 = mysqli_query($conn, $sql3);
                if($res3==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count4 = mysqli_num_rows($res3); // Function to get all the rows in the database
                }

                // Query to get all loaned books
                $sql2 = "SELECT * FROM loaned";
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);
                if($res2==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count2 = mysqli_num_rows($res2); // Function to get all the rows in the database
                }
                
                $count3 = 0;
                while($rows2=mysqli_fetch_assoc($res2)){
                    if($rows2['ToBeReturnedDate'] < date("Y-m-d H:i:s")){
                        $count3++;
                    }
                }

                // Query to get number of genres
                $sql4 = "SELECT COUNT(DISTINCT Genre) AS count6 FROM books";
                // Execute the query
                $res4 = mysqli_query($conn, $sql4);
                if($res4==TRUE){
                    $rows4=mysqli_fetch_assoc($res4);
                    $count6 = $rows4['count6'];
                }

                // Query to get number of authors
                $sql5 = "SELECT COUNT(DISTINCT Author) AS count7 FROM books";
                // Execute the query
                $res5 = mysqli_query($conn, $sql5);
                if($res5==TRUE){
                    $rows5=mysqli_fetch_assoc($res5);
                    $count7 = $rows5['count7'];
                }
            ?>
            
            <div class="dash-container"> 
                <h2><?php echo $count; ?></h2>
                <p>Number of distinct books</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count4; ?></h2>
                <p>Number of Users</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count2; ?></h2>
                <p>Number of books reserved</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count3; ?></h2>
                <p>Number of books overdue</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count5; ?></h2>
                <p>Total number of books</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count6; ?></h2>
                <p>Number of genres</p>
            </div>
            <div class="dash-container"> 
                <h2><?php echo $count7; ?></h2>
                <p>Number of authors</p>
            </div>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials/footer.php'); ?>