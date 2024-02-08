<?php 
    include('..\config\constants.php');
    include('login-check.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShelfSavvy</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/manager.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="home.php" title="Logo">
                    <img src="../images/Trine_logo.jpg" alt="Library System Logo" class="img-logo">
                </a>
            </div>

            <div class="header text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>manager/home.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>manager/search-books.php">Search Books</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>manager/search-members.php">Search Members</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>manager/profile.php">Profile</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->