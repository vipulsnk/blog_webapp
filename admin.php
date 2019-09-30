<?php
    require('config/config.php');
    require('config/db.php');
    session_start();
    if(isset($_SESSION['user_id'])){
        if(isset($_POST['delete'])){
            $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
            $q1 = "SELECT * FROM user_base WHERE user_id={$delete_id}";
            $r1 = mysqli_query($conn, $q1);
            $res = mysqli_fetch_all($r1, MYSQLI_ASSOC);
            $user_name = $res[0]['user_name'];
            $q2 = "DROP USER '{$user_name}'@'localhost'";
            if(!mysqli_query($conn_admin, $q2)){
                echo 'ERROR '.mysqli_error($conn_admin);
            }
            $query = "DELETE FROM user_base WHERE user_id= {$delete_id}";
            if(mysqli_query($conn, $query)){
                header('Location: '.ROOT_URL.'admin.php');
            }else{
                echo 'ERROR '.mysqli_error($conn);
            }
            
        }
        $q1 = 'SELECT * FROM user_base WHERE user_id ='.$_SESSION['user_id'];
        $r1 = mysqli_query($conn, $q1);
        $user = mysqli_fetch_all($r1, MYSQLI_ASSOC);
        $role = $user[0]['role'];
        $query1 = "SELECT * FROM user_base WHERE role='c_user' ORDER BY created_on DESC";
        $result1 = mysqli_query($conn, $query1);
        $users = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        $query2 = "SELECT * FROM user_base WHERE role='dev' ORDER BY created_on DESC";
        $result2 = mysqli_query($conn, $query2);
        $devs = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        mysqli_free_result($result1);
        mysqli_free_result($result2);
        mysqli_close($conn);
    }else{
        header("Location: ".ROOT_URL."");
    }
?>
<?php include('inc/header.php'); ?>
<div class="container">
    <h1>Developers</h1>
    <?php foreach($devs as $dev): ?>
        <div class="card card-body">
            <div class="row">
                <div class="col-sm-8">
                    <h3><?php echo $dev['user_name']; ?></h3>
                </div>
                <div class="col-sm-4">
                <form class="pull-right" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="delete_id" value="<?php echo $dev['user_id']; ?>">
                    <input type="submit" name="delete" value="Remove" class="btn btn-danger">
                </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="container">
    <h1>Users</h1>
    <?php foreach($users as $user): ?>
        <div class="card card-body">
        <div class="row">
                <div class="col-sm-8">
                    <h3><?php echo $user['user_name']; ?></h3>
                </div>
                <div class="col-sm-4">
                <form class="pull-right" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="delete_id" value="<?php echo $user['user_id']; ?>">
                    <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include('inc/footer.php'); ?>