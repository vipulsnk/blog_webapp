<?php
   require('config/config.php');
   require('config/db.php');
    session_start();
    if(isset($_SESSION['user_id'])){
        // user id is set
        $q1 = 'SELECT * FROM user_base WHERE user_id ='.$_SESSION['user_id'];
        $r1 = mysqli_query($conn, $q1);
        $user = mysqli_fetch_all($r1, MYSQLI_ASSOC);
        // var_dump($user);
        // create query
        $query = 'SELECT * FROM posts ORDER BY created_at DESC';
        // get result
        $result = mysqli_query($conn, $query);
        // fetch data
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // free result
        mysqli_free_result($result);
        // close connection
        mysqli_close($conn);
    }else{
        // user id not set
        header("Location: ".ROOT_URL."");
    }
   

?>
<?php include('inc/header.php'); ?>
<div class="container">
    <h1>Posts of <?php echo $user[0]['first_name']; ?></h1>
    <?php foreach($posts as $post): ?>
        <div class="well">
            <h3><?php echo $post['title']; ?></h3>
            <small>Created on <?php echo $post['created_at']; ?> by 
            <?php echo $post['author']; ?></small>
            <p><?php echo $post['body']; ?></p>
            <a class="btn btn-default" href="post.php?blog_id=<?php echo $post['blog_id']; ?>">Read More</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include('inc/footer.php'); ?>