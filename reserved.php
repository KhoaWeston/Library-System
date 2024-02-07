<?php include('partials-front/header.php'); ?>

    <!-- Main Section Starts Here -->
    <section class="page-container"> 
        <div class="container">
            <h2 class="text-center">Reserved Books</h2>

            <div class="book-catalog-box">
                <div class="book-catalog-desc">
                    <h4>Harry Potter</h4>
                    <p class="book-author">[author_name]</p>
                    <br>
                    
                    <a href="return-book.php" class="btn btn-primary">Return Now</a>
                </div>

                <div class="book-catalog-img">
                    <p class="book-author">[issue_date]</p>
                    <p class="book-author">[expire_date]</p>
                </div>

                
            </div>

            <div class="book-catalog-box">
                <div class="book-catalog-desc">
                    <h4>Percy Jackson</h4>
                    <p class="book-author">[author_name]</p>
                    <br>

                    <a href="return-book.php" class="btn btn-primary">Return Now</a>
                </div>

                <div class="book-catalog-img">
                    <p class="date-issue">[issue_date]</p>
                    <p class="date-expire">[expire_date]</p>
                </div>


            </div>

            <div class="clearfix"></div>

        </div>
    </section>
    <!-- Main Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
