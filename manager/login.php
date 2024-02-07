<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - ShelfSavvy</title>
        
        <!-- Link our CSS file -->
        <link rel="stylesheet" href="../css/manager.css">
    </head>

    <body>
        <div class="center">
            <h1>Login</h1>

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
            <form action"" method="POST">
                <div class="txt_field">
                    <input type="text" name="username"required>
                    <span></span>
                    <label>Username</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="pass">Forgot Password?</div>
                <div class="text-center"><input type="submit" name="submit" value="Login"></div>
                <div class="signup_link">
                    Not a member? <a href="index.php">Signup</a>
                </div>
            </form>
            <!-- Login Form Ends Here -->

        </div>
    </body>
</html>

<?php 
    if(isset($_POST['submit']))
    {
        // Get data from Login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM user WHERE Username='$username' AND Password='$password'";

        // Execute query and save data into database
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        // check whether the query is executed 
        if($count==1){        
            // User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // to check whether the user is logged in or not and logout will unset it

            // Redirect Page
            header("location:".SITEURL.'manager/');
        }else{
            // User not available and Login fail
            $_SESSION['login'] = "<div class='error'>Username or Password did not match.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/login.php');
        }
    }
?>