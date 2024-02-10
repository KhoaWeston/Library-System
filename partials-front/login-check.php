<?php 
    // Authorization
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user'])){
        // User is not logged in
        // Redirect to login page with message
        $_SESSION['no-login-member'] = "<div class='error'>Please login to access Member panel</div>";
        // Redirect to Login Page
        header('location:'.SITEURL);
    }
?>