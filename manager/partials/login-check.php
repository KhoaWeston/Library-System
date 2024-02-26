<?php 
    // Authorization
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user'])){
        // User is not logged in
        // Redirect to login page with message
        $_SESSION['no-login-manager'] = "<div class='error'>Please login to access Admin Panel</div>";
        // Redirect to Login Page
        header('location:'.SITEURL);
    }else{
        $id = $_SESSION['user'];

        // SQL to check whether the user is a manager
        $sql_man = "SELECT * FROM user WHERE UID='$id' AND MemberType='manager'";

        // Execute query and save data into database
        $res_man = mysqli_query($conn, $sql_man);
        
        $count_man = mysqli_num_rows($res_man);
        if($count_man != 1){
            // User is not a manager
            // Redirect to login page with message
            $_SESSION['no-login-manager'] = "<div class='error'>You do not have authorization to access Admin Panel</div>";
            // Redirect to Login Page
            header('location:'.SITEURL);
        }
    }
?>