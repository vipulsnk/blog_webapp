<?php
    require('config/config.php');
    require('config/db.php');   
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: ".ROOT_URL."");
    }
    // msg vars
    $msg = '';
    $msgClass = '';
    if(filter_has_var(INPUT_POST, 'submit')){
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
        if(!empty($first_name) && !empty($last_name) && !empty($user_name) && !empty($password) && !empty($confirm_password)){
            if(strcmp($password, $confirm_password) ==  0){
                $q1 = "SELECT * FROM user_base WHERE user_name= '$user_name'";
                $r1 = mysqli_query($conn, $q1);
                $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);
                if(empty($res)){
                    // empty array, unique user
                    $q1 = "CREATE USER '$user_name'@'localhost' IDENTIFIED WITH mysql_native_password BY '$password';";
                    $q1 .= "GRANT 'dev'@'localhost' TO '$user_name'@'localhost';";
                    $q1 .= "SET DEFAULT ROLE 'dev'@'localhost' TO '$user_name'@'localhost';";
                    if(!mysqli_multi_query($conn_admin, $q1)){
                        echo 'ERROR '.mysqli_error($conn_admin);
                    }
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO user_base(first_name, last_name, user_name, password, role) 
                                VALUES('$first_name', '$last_name', '$user_name', '$hashed_password', 'dev')";
                    if(mysqli_query($conn, $query)){
                        header('Location: '.ROOT_URL.'admin.php');
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
<?php include('inc/header.php'); ?>
    <div class="container">
        <br>
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

    <?php include('inc/footer.php'); ?>