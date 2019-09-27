<?php

   require('config/config.php');
   require('config/db.php');


      // check for submit

   if(isset($_POST['delete'])){
    // get form data
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        $query = "DELETE FROM posts WHERE blog_id= {$delete_id}";
    // die($query);
        if(mysqli_query($conn, $query)){
            header('Location: '.ROOT_URL.'home.php');
        }else{
            echo 'ERROR '.mysqli_error($conn);
        }
    }
   // get id

   $blog_id = mysqli_real_escape_string($conn, $_GET['blog_id']);
   // create query
   $query = 'SELECT * FROM posts WHERE blog_id='.$blog_id;

   // get result

   $result = mysqli_query($conn, $query);
    // var_dump($result);
   // fetch data

   $post = mysqli_fetch_assoc($result);
//    var_dump($posts);
   // free result

   mysqli_free_result($result);

   // close connection

   mysqli_close($conn);

?>

<?php include('inc/header.php'); ?>
    <div class="container">
        <a href="<?php echo ROOT_URL; ?>home.php" class="btn btn-default">Back</a>
        <h1><?php echo $post['title']; ?></h1>
            <small>Created on <?php echo $post['created_at']; ?> by 
            <?php echo $post['author']; ?></small>
            <p><?php echo $post['body']; ?></p>
            <hr>
            <form class="pull-right" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="delete_id" value="<?php echo $post['blog_id']; ?>">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
            </form>
            <a href="<?php echo ROOT_URL; ?>editpost.php?blog_id=<?php echo $post['blog_id']; ?>" class="btn btn-default">Edit</a>
    </div>
<?php include('inc/footer.php'); ?>
