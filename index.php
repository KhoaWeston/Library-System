<?php include('./config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - ShelfSavvy</title>
        
        <!-- Link our CSS file -->
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/login.css">
    </head>

    <body>
        <div class="center">
            <h1>What user type?</h1>

            <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display message
                    unset($_SESSION['login']); // Remove message
                }

                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message']; // Display message
                    unset($_SESSION['no-login-message']); // Remove message
                }
            ?>

            <!-- Login Form Starts Here -->
            <a href="<?php echo SITEURL; ?>login.php" class="btn btn-primary">member</a>
            <a href="<?php echo SITEURL; ?>manager/login.php" class="btn btn-primary">Manager</a>

            <!-- Login Form Ends Here -->

        </div>
    </body>
</html>

