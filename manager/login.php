<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - ShelfSavvy</title>
        
        <!-- Link our CSS file -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/login.css">
    </head>

    <body>
        <section class="background">
            <div class="center">
            <h1><img src="../images/ShelfSavvy-Logo.png" alt="Library System Logo" class="img-logo-login"><br/>Manager Login</h1>

                <br/>
                <?php 
                    // Display error messages
                    if(isset($_SESSION['login'])){
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }

                    if(isset($_SESSION['no-login-manager'])){
                        echo $_SESSION['no-login-manager'];
                        unset($_SESSION['no-login-manager']);
                    }
                ?>

                <!-- Login Form Starts Here -->
                <form action="" method="POST">
                    <div class="txt_field">
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary width-full">
                        <br/><br/>
                        <a href="<?php echo SITEURL; ?>" class="btn-login btn-primary">Return</a>
                    </div>
                    <br/><br/>
                </form>
                <!-- Login Form Ends Here -->

            </div>
        </section>
    </body>
</html>

<?php 
    if(isset($_POST['submit']))
    {
        // Get data from Login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // SQL to check whether the user with username and password exists or not
        $sql_match = "SELECT * FROM user WHERE Username='$username' AND Password='$password'";

        // Execute query and save data into database
        $res_match = mysqli_query($conn, $sql_match);

        $count_match = mysqli_num_rows($res_match);

        // check whether the query is executed 
        if($count_match==1){        
            // SQL to check whether the user is a manager
            $sql_man = "SELECT * FROM user WHERE Username='$username' AND MemberType='manager'";

            // Execute query and save data into database
            $res_man = mysqli_query($conn, $sql_man);
            
            $count_man = mysqli_num_rows($res_man);

            if($count_man == 1){
                // User Available and Login Success
                $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
                // Create Session with user's id
                $sql_login = "SELECT * FROM user WHERE Username='$username'";
                $res_login = mysqli_query($conn, $sql_login);
                $row_login=mysqli_fetch_assoc($res_login);
                $id = $row_login['UID'];
                $_SESSION['user'] = $id; // to check whether the user is logged in or not and logout will unset it

                // Redirect Page
                header("location:".SITEURL.'manager/home.php');
            }else{
                // User not available and Login fail
                $_SESSION['login'] = "<div class='error'>You are not permitted to login.</div>";
                // Redirect Page
                header("location:".SITEURL.'manager/login.php');
            }
            
        }else{
            // User not available and Login fail
            $_SESSION['login'] = "<div class='error'>Username or Password did not match.</div>";
            // Redirect Page
            header("location:".SITEURL.'manager/login.php');
        }
    }
?>