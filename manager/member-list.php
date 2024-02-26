<?php include('partials/header.php'); ?>

<!-- Member Search Section Starts Here -->
<section class="book-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>manager/search-members.php" method="POST">
            <input type="search" name="search" placeholder="Search for Member...." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- Member Search Section Ends Here -->

<!-- Member List Section Starts Here -->
<section class="page-container">  
    <div class="container">
        <h2 class="text-center">Member List</h2>

        <?php 
            // Display messages
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Display message
                unset($_SESSION['add']); // Remove message
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; 
                unset($_SESSION['delete']); 
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; 
                unset($_SESSION['update']); 
            }

            if(isset($_SESSION['update-pass'])){
                echo $_SESSION['update-pass']; 
                unset($_SESSION['update-pass']); 
            }
        ?>
        <br />
        <a href="add-member.php" class="btn btn-primary">Add Member</a>
        
        <table class="tbl-list">
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Username</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Member Type</th>
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

                // Query to get members for page
                $sql_page = "SELECT * FROM user ORDER BY UID DESC LIMIT $start_from, $num_per_page";

                // Execute the query
                $res_page = mysqli_query($conn, $sql_page);

                // Check whether the query is executed or not
                if($res_page==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count_page = mysqli_num_rows($res_page); // Function to get all the rows in the database

                    if($count_page>0){
                        while($rows_page=mysqli_fetch_assoc($res_page)){
                            $id = $rows_page['UID'];
                            $username = $rows_page['Username'];
                            $address = $rows_page['Address'];
                            $phone_num = $rows_page['PhoneNum'];
                            $member_type = $rows_page['MemberType'];

                            ?>
                            <tr>
                                <td class="col-id"><?php echo $id; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $phone_num; ?></td>
                                <td><?php echo $member_type; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>manager/update-password.php?id=<?php echo $id; ?>" class="btn btn-primary">Update Password</a>
                                    <a href="<?php echo SITEURL; ?>manager/edit-member.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit Member</a>
                                    <a href="<?php echo SITEURL; ?>manager/remove-member.php?id=<?php echo $id; ?>" class="btn btn-primary">Remove Member</a>
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
                <a href="<?php echo SITEURL; ?>manager/member-list.php?page=<?php echo $page-1; ?>" class="btn btn-primary">Previous</a>
                <?php
            }
            
            for($i = 1; $i <= $count_books; $i++){
                ?>
                <a href="<?php echo SITEURL; ?>manager/member-list.php?page=<?php echo $i; ?>" class="btn btn-primary"><?php echo $i; ?></a>
                <?php
            }

            if($page < $count_books){
                ?>
                <a href="<?php echo SITEURL; ?>manager/member-list.php?page=<?php echo $page+1; ?>" class="btn btn-primary">Next</a>
                <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Member List Section Ends Here -->

<?php include('partials/footer.php'); ?>