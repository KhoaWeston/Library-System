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
        <div class="center text-center">
            <h1>What user type?</h1>
            <br/><br/>
            <!-- Login Form Starts Here -->
            <div>
                <a href="<?php echo SITEURL; ?>login.php" class="btn btn-primary">Member</a>
                <a href="<?php echo SITEURL; ?>manager/login.php" class="btn btn-primary">Manager</a>
            </div>
            <!-- Login Form Ends Here -->

        </div>
    </body>
</html>

