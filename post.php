<?php
    require('config/config.php');
    require('config/db.php');
    session_start();
    if(!isset($_SESSION['user_id'])){
        // no user should be logged in
        header('Location: '.ROOT_URL.'');
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
        <h1><?php echo $post['title']; ?></h1>
            <small>Created on <?php echo $post['created_at']; ?> by 
            <?php echo $post['author']; ?></small>
            <p><?php echo $post['body']; ?></p>
            <hr>
    </div>
<?php include('inc/footer.php'); ?>
