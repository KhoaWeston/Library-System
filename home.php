<?php include('partials-front/header-home.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container">
        <div class="container">
            <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display message
                    unset($_SESSION['login']); // Remove message
                }
                
                // Query to get all books
                $sql = "SELECT * FROM books ORDER BY reg_date DESC";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                if($res==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in the database
                }

                // Query to get all loaned books
                $sql2 = "SELECT * FROM loaned";
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);
                if($res2==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count2 = 0;
                    $count3 = 0;
                    while($rows2=mysqli_fetch_assoc($res2)){
                        if($rows2['UID'] == $_SESSION['user']){
                            $count2++;
                        }
                        if($rows2['ToBeReturnedDate'] < date("Y-m-d H:i:s")){
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
                <p>Genres</p>
            </div>

            <div class="comp-container"> 
                <h2>Recently Added</h2>
                <?php 
                    $ctr = 0;
                    while($rows=mysqli_fetch_assoc($res)){
                        $image_name = $rows['image_name'];
                        if($image_name != ""){
                            // Display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/books/<?php echo $image_name; ?>" class="img-home img-curve" >

                            <?php 
                            $ctr++;
                        }
                        if($ctr >= 3){
                            break;
                        }
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
