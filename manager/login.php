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
        <div class="center">
            <h1>Manager Login</h1>

            <br/>
            <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display message
                    unset($_SESSION['login']); // Remove message
                }

                if(isset($_SESSION['no-login-manager'])){
                    echo $_SESSION['no-login-manager']; // Display message
                    unset($_SESSION['no-login-manager']); // Remove message
                }
            ?>

            <!-- Login Form Starts Here -->
            <form action="" method="POST">
                <div class="txt_field">
                    <input type="text" name="username" required>
                    <span></span>
                    <label>Username</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" value="Login" class="btn btn-primary">
                    <a href="<?php echo SITEURL; ?>" class="btn btn-primary">Go Back</a>
                </div>
                <br/><br/>
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
            // SQL to check whether the user with username and password exists or not
            $sql1 = "SELECT * FROM user WHERE Username='$username' AND MemberType='manager'";

            // Execute query and save data into database
            $res1 = mysqli_query($conn, $sql1);
            
            $count1 = mysqli_num_rows($res1);

            if($count1 == 1){
                // User Available and Login Success
                $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
                // Create Session with user's id
                $sql2 = "SELECT * FROM user WHERE Username='$username'";
                $res2 = mysqli_query($conn, $sql2);
                $row=mysqli_fetch_assoc($res2);
                $id = $row['UID'];
                $_SESSION['user'] = $id; // to check whether the user is logged in or not and logout will unset it

                // Redirect Page
                header("location:".SITEURL.'manager/home.php');
            }else{
                // User not available and Login fail
                $_SESSION['login'] = "<div class='error'>Not a manager.</div>";
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