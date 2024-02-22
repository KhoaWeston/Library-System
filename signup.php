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
            <h1><img src="images/ShelfSavvy-Logo.png" alt="Library System Logo" class="img-logo-login"><br/>Member Sign Up</h1>

            <?php 
                // Displays error message
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; 
                    unset($_SESSION['login']); 
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
                <div class="txt_field">
                    <input type="text" name="address" required>
                    <label>Address</label>
                </div>
                <div class="txt_field">
                    <input type="number" name="phone_num" required>
                    <label>Phone Number</label>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" value="Signup" class="btn btn-primary width-full">
                    <br/><br/>
                    <a href="<?php echo SITEURL; ?>login.php" class="btn-login btn-primary">Return</a>
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
        // Get data from sign up form
        $username = $_POST['username'];
        $password = md5($_POST['password']); // password encryption
        $address = $_POST['address'];
        $phone_num = $_POST['phone_num']; 
        $member_type = 'member';

        // SQL Query to save the data into the database
        $sql = "INSERT INTO user SET
            Username='$username',
            Password='$password',
            Address='$address',
            PhoneNum='$phone_num',
            MemberType='$member_type'
        ";

       // Execute query and save data into database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

       // check whether the query is executed 
       if($res==TRUE){        
            // Create a session variable to display message
            $_SESSION['signup'] = "<div class='success'>Member sign up successful.</div>";
            
            // Create Session with user's id
            $sql_login = "SELECT * FROM user WHERE Username='$username'";
            $res_login = mysqli_query($conn, $sql_login);
            $row_login=mysqli_fetch_assoc($res_login);
            $id = $row_login['UID'];
            $_SESSION['user'] = $id; // to check whether the user is logged in or not and logout will unset it

            // Redirect Page
            header("location:".SITEURL.'home.php');
       }else{
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to sign up.</div>";
            // Redirect Page
            header("location:".SITEURL.'signup.php');
       }
    }
?>