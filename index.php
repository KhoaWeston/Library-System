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
        <section class="background">
            <div class="center text-center">
                <h1><img src="images/ShelfSavvy-Logo.png" alt="Library System Logo" class="img-logo-login"></h1>
                
                <!-- Login Selection Starts Here -->
                <br/>
                <h3>Choose Account Type</h3>
                <br/>
                <div>
                    <a href="<?php echo SITEURL; ?>login.php" class="btn btn-primary">Member</a>
                    <a href="<?php echo SITEURL; ?>manager/login.php" class="btn btn-primary indent">Manager</a>
                </div>
                <br/><br/>
                <!-- Login Selection Ends Here -->

            </div>
        </section>
    </body>
</html>

