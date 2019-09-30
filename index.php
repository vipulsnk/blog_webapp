<?php

    require('config/config.php');
    require('config/db.php');   
    session_start();
    if(isset($_SESSION['user_id'])){        
        header("Location: ".ROOT_URL."home.php");
    }
    $msg = '';              // msg vars
    $msgClass = '';
    if(filter_has_var(INPUT_POST, 'submit')){      
        $user_name = htmlspecialchars($_POST['user_name']);
        $password = htmlspecialchars($_POST['password']);
        $role = htmlspecialchars($_POST['role']);
        $user_name = mysqli_real_escape_string($conn, $user_name);      // sanitize
        $password = mysqli_real_escape_string($conn, $password);
        if(!empty($user_name) && !empty($password)){                    //check required fields
            $q1 = "SELECT * FROM user_base WHERE user_name= '$user_name' AND role = '$role'";
            $r1 = mysqli_query($conn, $q1);
            if(!$r1){
                $msg = "user not found, sign up";
                $msgClass = 'alert-danger';
            }else{
                $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);            
                if(!empty($res)){
                    if(password_verify($password, $res[0]['password'])){
                        $user_id = $res[0]['user_id'];
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user_name'] = $user_name;
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['role'] = $role;
                        $_SESSION['password'] = $password;
                        mysqli_free_result($r1);
                        mysqli_close($conn);                        
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
            }
            mysqli_free_result($r1);
            mysqli_close($conn);     
        }else{
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
                <a class="navbar-brand" href="index.php">Blog</a>
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
                <input type="text"  name="user_name" class="form-control" value="<?php echo isset($_POST['user_name']) ? $user_name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo isset($_POST['password']) ? $password : ''; ?>">
            </div>
            <label>Role</label>
            <div class="form-group">
                <input  type="radio" name="role" value="c_user"  checked> User<br>
                <input  type="radio" name="role" value="Admin"> Admin<br>
                <input  type="radio" name="role" value="dev"> Dev<br>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <br>
        <a href="<?php echo ROOT_URL?>signup.php">Don't have an account? Sign Up</a>
    </div>
</body>
</html>


