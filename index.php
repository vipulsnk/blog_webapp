<?php

    require('config/config.php');
    require('config/db.php');   
    // msg vars
    // check session
    session_start();
    if(isset($_SESSION['user_id'])){
        // no user should be logged in
        unset($_SESSION['user_id']);
    }
    session_destroy();
    $msg = '';
    $msgClass = '';
    // check for submit

    if(filter_has_var(INPUT_POST, 'submit')){
        $user_name = htmlspecialchars($_POST['user_name']);
        $password = htmlspecialchars($_POST['password']);
        $user_name = mysqli_real_escape_string($conn, $user_name);
        $password = mysqli_real_escape_string($conn, $password);
        //check required fields
        if(!empty($user_name) && !empty($password)){
            // passed
            $q1 = "SELECT * FROM user_base WHERE user_name= '$user_name'";
            $r1 = mysqli_query($conn, $q1);
            $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);            
            if(!empty($res)){
                if(password_verify($password, $res[0]['password'])){
                    // password matched
                    $user_id = $res[0]['user_id'];
                    session_start(); // start the session
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['user_id'] = $user_id;
                    header("Location: ".ROOT_URL."home.php");
                }else{
                    // incorrect password
                    $msg = "password is incorrect";
                    $msgClass = 'alert-danger';
                }
            }else{
                // empty array, user not found
                $msg = "user not found, sign up";
                $msgClass = 'alert-danger';
            }
        }else{
            // failed
            $msg = 'Please fill in all fields';
            $msgClass = 'alert-danger';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">My Website</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label>User Name</label>
                <input type="text" name="user_name" class="form-control" value="<?php echo isset($_POST['user_name']) ? $user_name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo isset($_POST['password']) ? $password : ''; ?>">
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">
            Submit</button>
        </form>
        <br>
        <a href="<?php echo ROOT_URL?>signup.php">Sign Up</a>
    </div>
</body>
</html>