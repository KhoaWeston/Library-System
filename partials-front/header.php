<?php 
    include('./config/constants.php');
    include('login-check.php');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ShelfSavvy</title>

        <!-- Link our CSS file -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/member.css">
    </head>

    <body>
        <!-- Navbar Section Starts Here -->
        <section class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <a href="<?php echo SITEURL; ?>home.php" title="Logo">
                        <img src="images/ShelfSavvy-Logo.png" alt="Library System Logo" class="img-logo">
                    </a>
                </div>

                <div class="tabs-container text-right">
                    <ul>
                        <li>
                            <a href="<?php echo SITEURL; ?>home.php">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL; ?>book-catalog.php">Books</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL; ?>reserved.php">Reserved</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL; ?>profile.php">Profile</a>
                        </li>
                    </ul>
                </div>

                <div class="clearfix"></div>
            </div>
        </section>
        <!-- Navbar Section Ends Here -->