<?php 
    // Authorization
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user'])){
        // User is not logged in
        // Redirect to login page with message
        $_SESSION['no-login-manager'] = "<div class='error'>Please login to access Admin Panel</div>";
        // Redirect to Login Page
        header('location:'.SITEURL);
    }
?>