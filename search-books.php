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
    <section class="page-container">
        <div class="container">
            <h2 class="text-center">Book Catalog</h2>

            <div class="book-catalog-box">
                <div class="book-catalog-img">
                    <img src="" alt="Wizard Image" class="img-responsive img-curve">
                </div>

                <div class="book-catalog-desc">
                    <h4>Harry Potter</h4>
                    <p class="book-author">[author_name]</p>
                    <p class="book-ISBN">[ISBN_num]</p>
                    <p class="book-num-copies">[num_copies]</p>
                    <p class="book-detail">
                        [Description]
                    </p>
                    <br>

                    <a href="place-order.php" class="btn btn-primary">Order Now</a>
                </div>
            </div>

            <div class="book-catalog-box">
                <div class="book-catalog-img">
                    <img src="" alt="God Image" class="img-responsive img-curve">
                </div>

                <div class="book-catalog-desc">
                    <h4>Percy Jackson</h4>
                    <p class="book-author">[author_name]</p>
                    <p class="book-ISBN">[ISBN_num]</p>
                    <p class="book-num-copies">[num_copies]</p>
                    <p class="book-detail">
                        [Description]
                    </p>
                    <br>

                    <a href="place-order.php" class="btn btn-primary">Order Now</a>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Book Catalog Section Ends Here -->

    <?php include('partials/footer.php'); ?>
