<?php
    require('config/config.php');
    require('config/db.php');
    session_start();
    if(isset($_SESSION['user_id'])){
        if(isset($_POST['delete'])){
            $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
            $query = "DELETE FROM posts WHERE blog_id= {$delete_id}";
            if(mysqli_query($conn, $query)){
                header('Location: '.ROOT_URL.'home.php');
            }else{
                echo 'ERROR '.mysqli_error($conn);
            }
        }
        $q1 = 'SELECT * FROM user_base WHERE user_id ='.$_SESSION['user_id'];
        $r1 = mysqli_query($conn, $q1);
        $user = mysqli_fetch_all($r1, MYSQLI_ASSOC);
        $role = $user[0]['role'];
        $query = 'SELECT * FROM posts ORDER BY created_at DESC';
        $result = mysqli_query($conn, $query);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        mysqli_close($conn);
    }else{
        header("Location: ".ROOT_URL."");
    }
?>
<?php include('inc/header.php'); ?>
<div class="container">
    <br>
    <h1>All Posts</h1>
    <?php foreach($posts as $post): ?>
        <div class="card card-body ">
            <div class="row">
                <div class="col-sm-8">
                    <h3><?php echo $post['title']; ?></h3>
                    <small>Created on <?php echo $post['created_at']; ?> by 
                    <?php echo $post['author']; ?></small>
                    <p><?php echo strlen($post['body']) > 200 ? substr($post['body'], 0, 200)."..." : $post['body']; ?></p>
                </div>
                <div class="col-sm-4">
                    <?php if(strlen($post['body']) > 200): ?>
                        <a style="width: 6rem;" href="post.php?blog_id=<?php echo $post['blog_id']; ?>">Read More</a>
                        <br>
                    <?php endif; ?>
                    <?php if(strcmp($role, 'Admin')==0 || strcmp($role, 'dev')==0): ?>
                        <form class="pull-right" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="delete_id" value="<?php echo $post['blog_id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                        </form>
                    <?php endif; ?>
                </div>
            </div>   
        </div>
    <?php endforeach; ?>
</div>

<?php include('inc/footer.php'); ?>