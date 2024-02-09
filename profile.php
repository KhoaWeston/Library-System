<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container text-center">
        <div class="confirm-container">
            <h2 class="text-center">Profile</h2>
            
            <?php 
                // Get the ID of the member
                $id = $_SESSION['user'];
                
                
                // Create SQL Query to get the details
                $sql="SELECT * FROM user WHERE UID=$id";

                // Execute the query
                $res=mysqli_query($conn, $sql);

                // Check whether the query is executed or not
                if($res==TRUE){
                    // Check whether the data is available or not
                    $count = mysqli_num_rows($res);
                    // Check whether we have member data or  not
                    if($count==1){
                        // Get the details
                        // echo "member available";
                        $row=mysqli_fetch_assoc($res);

                        $username = $row['Username']; 
                        $books_out = $row['BooksOut'];
                        $address = $row['Address']; 
                        $phone_num = $row['PhoneNum']; 
                    }else{
                        // Redirect to search members
                        header('location:'.SITEURL.'search-books.php');
                    }
                }
            ?>

            <table class="tbl width-full">
                    <tr>
                        <td class="text-bold">ID: </td>
                        <td>
                            <?php echo $id; ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-bold">Username: </td>
                        <td>
                            <?php echo $username; ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold">Address: </td>
                        <td>
                            <?php echo $address; ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold">Phone Number: </td>
                        <td>
                            <?php echo $phone_num; ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold">Books Reserved: </td>
                        <td>
                            <?php echo $books_out; ?>
                        </td>
                    </tr>
                </table>
                <a href="login.php" class="btn btn-primary">Logout</a>

        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
