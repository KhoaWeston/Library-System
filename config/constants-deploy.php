<?php 
    // Start Session
    session_start();
    
    // Create constant to store non repeating values
    define('SITEURL', 'http://shelfsavvy.infinityfreeapp.com/');
    
    define('DB_SERVER', 'sql212.infinityfree.com');
    define('DB_USERNAME', 'if0_36056082');
    define('DB_PASSWORD', 'QN9jT7E0my');
    define('DB_NAME', 'if0_36056082_shelfsavvy');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); // Database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Databse selection
?>