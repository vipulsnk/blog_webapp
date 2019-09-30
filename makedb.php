<?php
    require('config/config.php');
    require('config/db.php');
    // $q1 = "SELECT first_name, last_name FROM dummy LIMIT 200";
    // $r1 = mysqli_query($conn, $q1);
    // $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);
    // foreach($res as $r){
    //     $user_name = $r['first_name'];
    //     $last_name = $r['last_name'];
    //     $hashed_password = password_hash($last_name, PASSWORD_DEFAULT);
    //     $query = "INSERT INTO user_base(first_name, last_name, user_name, password, role) 
    //                 VALUES('$user_name', '$last_name', '$user_name', '$hashed_password', 'c_user')";
    //     if(mysqli_query($conn, $query)){
    //         header('Location: '.ROOT_URL.'index.php');
    //     }else{
    //         echo 'ERROR '.mysqli_error($conn);
    //     } 
    // }

    $user = ['ansh', 'akshay', 'sonu', 'shaurya', 'yash', 'priyanshi', 'shreya', 'pratham'];
    
    foreach($user as $u){
        // $q1 = "CREATE USER '$u'@'localhost' IDENTIFIED WITH mysql_native_password BY '12345'";
        // $q2 = "GRANT 'dev'@'localhost' TO '$u'@'localhost'";
        // $q3 = "SET DEFAULT ROLE 'dev'@'localhost' TO '$u'@'localhost'";
        // if(mysqli_query($conn, $q1)){
        //     // header('Location: '.ROOT_URL.'index.php');
        // }else{
        //     echo 'ERROR '.mysqli_error($conn);
        // } 
        // if(mysqli_query($conn, $q2)){
        //     // header('Location: '.ROOT_URL.'index.php');
        // }else{
        //     echo 'ERROR '.mysqli_error($conn);
        // } 
        // if(mysqli_query($conn, $q3)){
        //     // header('Location: '.ROOT_URL.'index.php');
        // }else{
        //     echo 'ERROR '.mysqli_error($conn);
        // } 
        // $user_name = 
        // $last_name = $r['last_name'];
        $hashed_password = password_hash('12345', PASSWORD_DEFAULT);
        $query = "INSERT INTO user_base(first_name, last_name, user_name, password, role) 
                    VALUES('$u', 'shankhpal', '$u', '$hashed_password', 'dev')";
        if(mysqli_query($conn, $query)){
            // header('Location: '.ROOT_URL.'index.php');
        }else{
            echo 'ERROR '.mysqli_error($conn);
            break;
        } 
    }
    

?>