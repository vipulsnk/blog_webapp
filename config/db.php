<?php
    require('config.php');
    session_start();
    if(isset($_SESSION['user_id'])){
        if(strcmp($_SESSION['role'], 'c_user')){
            // unmatched
            $db_user = $_SESSION['user_name'];
            $db_pass = $_SESSION['password'];
        }
    }
    // create connection
    $db_user = $db_user ? $db_user : DB_USER;
    $db_pass = $db_pass ? $db_pass : DB_PASS;
    $conn = mysqli_connect(DB_HOST, $db_user, $db_pass, DB_NAME);
    if(strcmp($_SESSION['role'], 'Admin') == 0){
        $conn_admin = mysqli_connect(DB_HOST, $db_user, $db_pass, 'mysql');
    }
    // check connection
    if(mysqli_connect_errno()){
        // connection failed
        echo 'Failed to connect to MySQL '.mysqli_connect_errno();
    }