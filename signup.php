<?php

    require('config/config.php');
    require('config/db.php');   
    // msg vars

    $msg = '';
    $msgClass = '';
    // check for submit

    if(filter_has_var(INPUT_POST, 'submit')){
        // echo 'submitted';
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $user_name = htmlspecialchars($_POST['user_name']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $last_name = mysqli_real_escape_string($conn, $last_name);
        $user_name = mysqli_real_escape_string($conn, $user_name);
        $password = mysqli_real_escape_string($conn, $password);
        $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

        //check required fields

        if(!empty($first_name) && !empty($last_name) && !empty($user_name) && !empty($password) && !empty($confirm_password)){
            // passed
            if(strcmp($password, $confirm_password) ==  0){
                $q1 = "SELECT * FROM user_base WHERE user_name= '$user_name'";
                $r1 = mysqli_query($conn, $q1);
                $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);
                if(empty($res)){
                    // empty array, unique user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO user_base(first_name, last_name, user_name, password) 
                                VALUES('$first_name', '$last_name', '$user_name', '$hashed_password')";
                    if(mysqli_query($conn, $query)){
                        header('Location: '.ROOT_URL.'index.php');
                    }else{
                        echo 'ERROR '.mysqli_error($conn);
                    }
                }else{
                    // user already exist
                    $msg = "user '$user_name' already exist, use a different user name";
                    $msgClass = 'alert-danger';
                }
                
            }else{
                // passwords did not match
                $msg = 'passwords do not match';
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
    <title>Sign Up</title>
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
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo isset($_POST['first_name']) ? $first_name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo isset($_POST['last_name']) ? $last_name : ''; ?>">
            </div>
            <div class="form-group">
                <label>User Name</label>
                <input type="text" name="user_name" class="form-control" value="<?php echo isset($_POST['user_name']) ? $user_name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo isset($_POST['password']) ? $password : ''; ?>">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo isset($_POST['password']) ? $confirm_password : ''; ?>">
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">
            Submit</button>
        </form>
    </div>
</body>
</html>