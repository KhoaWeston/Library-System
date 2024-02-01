<?php include('partials/header.php'); ?>

    <!-- Book Search Section Starts Here -->
    <section class="book-search text-center">
        <div class="container">
            
            <form action="#" method="POST">
                <input type="search" name="search" placeholder="Search for Book...." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Book Search Section Ends Here -->

    <!-- Book Catalog Section Starts Here -->
    <section class="book-catalog">
        <div class="container">
            <h2 class="text-center">Member List</h2>

            <a href="add-member.php" class="btn btn-primary">Add Member</a>
            
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <tr>
                    <td>1. </td>
                    <td>Khoa Weston</td>
                    <td>Khoa Weston</td>
                    <td>
                        <a href="#" class="btn btn-primary">Edit Member</a>
                        <a href="remove-member.php" class="btn btn-primary">Remove Member</a>
                    </td>
                </tr>

                <tr>
                    <td>2. </td>
                    <td>Khoa Weston</td>
                    <td>Khoa Weston</td>
                    <td>
                        <a href="#" class="btn btn-primary">Edit Member</a>
                        <a href="remove-member.php" class="btn btn-primary">Remove Member</a>
                    </td>
                </tr>

                <tr>
                    <td>3. </td>
                    <td>Khoa Weston</td>
                    <td>Khoa Weston</td>
                    <td>
                        <a href="#" class="btn btn-primary">Edit Member</a>
                        <a href="remove-member.php" class="btn btn-primary">Remove Member</a>
                    </td>
                </tr>
            </table>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Book Catalog Section Ends Here -->

<?php include('partials/footer.php'); ?>