<?php include('partials/header.php'); ?>

<!-- Book Search Section Starts Here -->
<section class="book-search text-center">
    <div class="container">
        <?php 
            // Get the search keyword
            $search = $_POST['search'];
        ?>  
        <h2 class="">Members on your search <a href="<?php echo SITEURL; ?>manager/member-list.php" class="">"<?php echo $search;?>"</a></h2>

    </div>
</section>
<!-- Book Search Section Ends Here -->

<!-- Book Catalog Section Starts Here -->
<section class="page-container">
    <div class="container">
        <?php 
            //SQL Query to get foods based on search keyword
            $sql = "SELECT * FROM user WHERE 
            Username LIKE '%$search%' OR 
            MemberType LIKE '%$search%'";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if($res==TRUE){
                // Count Rows to check whether we have data in the database or not
                $count = mysqli_num_rows($res); // Function to get all the rows in the database

                if($count>0){
                    ?>
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
                        ?>
                    </table>
                    <?php
                }else{
                    // No data
                    echo "<div class='error'>No matches</div>";
                }
            }
        ?> 
        <div class="clearfix"></div>
    </div>
</section>
<!-- Book Catalog Section Ends Here -->

<?php include('partials/footer.php'); ?>
