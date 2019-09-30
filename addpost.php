<?php
    require('config/config.php');
    require('config/db.php');
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: '.ROOT_URL.'');
    }
    if(isset($_POST['submit'])){
        $title = htmlspecialchars($_POST['title']);
        $body = htmlspecialchars($_POST['body']);
        $title = mysqli_real_escape_string($conn, $title);
        $body = mysqli_real_escape_string($conn, $body);
        $author = $_SESSION['user_name'];
        $query = "INSERT INTO posts(title, author, body) VALUES('$title', '$author', '$body')";
        if(mysqli_query($conn, $query)){
            header('Location: '.ROOT_URL.'home.php');
        }else{
            echo 'ERROR '.mysqli_error($conn);
        }
    }
?>
<?php include('inc/header.php'); ?>
<div class="container">
    <h1>Add Post</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea name="body" class="form-control"></textarea>
        </div>
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
    </form>
</div>
<?php include('inc/footer.php'); ?>