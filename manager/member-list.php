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
                // Query to get all members
                $sql = "SELECT * FROM user ORDER BY UID DESC";
                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Check whether the query is executed or not
                if($res==TRUE){
                    // Count Rows to check whether we have data in the database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in the database

                    if($count>0){
                        while($rows=mysqli_fetch_assoc($res)){
                            $id = $rows['UID'];
                            $username = $rows['Username'];
                            $address = $rows['Address'];
                            $phone_num = $rows['PhoneNum'];
                            $member_type = $rows['MemberType'];

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
        <div class="clearfix"></div>
    </div>
</section>
<!-- Member List Section Ends Here -->

<?php include('partials/footer.php'); ?>