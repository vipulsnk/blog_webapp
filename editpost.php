<?php
   require('config/config.php');
   require('config/db.php');
   session_start();
    if(!isset($_SESSION['user_id'])){
        // no user should be logged in
        header('Location: '.ROOT_URL.'');
    }
   if(isset($_POST['submit'])){
       $update_id = htmlspecialchars($_POST['update_id']);
       $title = htmlspecialchars($_POST['title']);
       $body = htmlspecialchars($_POST['body']);
       $update_id = mysqli_real_escape_string($conn, $update_id);
       $title = mysqli_real_escape_string($conn, $title);
       $body = mysqli_real_escape_string($conn, $body);
       $query = "UPDATE posts SET 
                    title='$title',
                    body='$body'
                        WHERE blog_id={$update_id}";
        if(mysqli_query($conn, $query)){
            header('Location: '.ROOT_URL.'home.php');
        }else{
            echo 'ERROR '.mysqli_error($conn);
        }
   }
     $blog_id = mysqli_real_escape_string($conn, $_GET['blog_id']);
     $query = 'SELECT * FROM posts WHERE blog_id='.$blog_id;
     $result = mysqli_query($conn, $query);
     $post = mysqli_fetch_assoc($result);
     mysqli_free_result($result);
     mysqli_close($conn);
?>
<?php include('inc/header.php'); ?>
<div class="container">
    <h1>Edit Post</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $post['title']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea name="body" class="form-control"><?php echo $post['body']; ?></textarea>
        </div>
        <input type="hidden" name="update_id" value="<?php echo $post['blog_id']; ?>">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
    </form>
</div>

<?php include('inc/footer.php'); ?>