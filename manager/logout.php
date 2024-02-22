<?php
    // inlcude constants.php for SITEURL
    include('../config/constants.php');
    // Destroy the session
    session_destroy(); // Unsets $_SESSION['user']

    // Redirect to login page
    header('location:'.SITEURL)
?>