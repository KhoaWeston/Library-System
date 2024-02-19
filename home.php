<?php include('partials-front/header.php'); ?>

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
                }

                // Query to get all books
                $sql2 = "SELECT * FROM loaned";
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);
                if($res2==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count2 = 0;
                    $count3 = 0;
                    while($rows=mysqli_fetch_assoc($res2)){
                        if($rows['UID'] == $_SESSION['user']){
                            $count2++;
                        }
                        if($rows['ToBeReturnedDate'] < date("Y-m-d H:i:s")){
                            $count3++;
                        }
                    }
                }
            ?>
            
            <div class="dash-container"> 
                <h2><?php echo $count; ?></h2>
                <p>Number of books in catalog</p>
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
                <h2>0</h2>
                <p>Something</p>
            </div>
            
            <p>This is a library management system. </p>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
