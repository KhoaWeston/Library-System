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
            <h1>Member Signup</h1>

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
                <div class="txt_field">
                    <input type="text" name="address" required>
                    <span></span>
                    <label>Address</label>
                </div>
                <div class="txt_field">
                    <input type="number" name="phone_num" required>
                    <span></span>
                    <label>Phone Number</label>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" value="Signup" class="btn btn-primary">
                    <a href="<?php echo SITEURL; ?>login.php" class="btn btn-primary">Go Back</a>
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
        // Get data from form
        $username = $_POST['username'];
        $password = md5($_POST['password']); // password encryption
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num']; 

        // SQL Query to save the data into the database
        $sql = "INSERT INTO user SET
            Username='$username',
            Password='$password',
            Address='$address',
            PhoneNum='$phone_num'
        ";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['signup'] = "<div class='success'>Member signup successful.</div>";
            
            // Create Session with user's id
            $sql2 = "SELECT * FROM user WHERE Username='$username'";
            $res2 = mysqli_query($conn, $sql2);
            $row=mysqli_fetch_assoc($res2);
            $id = $row['UID'];
            $_SESSION['user'] = $id; // to check whether the user is logged in or not and logout will unset it

            // Redirect Page
            header("location:".SITEURL.'home.php');
       }else{
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to signup.</div>";
            // Redirect Page
            header("location:".SITEURL.'signup.php');
       }
    }
?>