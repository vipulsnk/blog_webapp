<?php
  require('config/config.php');
  require('config/db.php');
  session_start();
  if(isset($_SESSION['user_id'])){
    $role = $_SESSION['role'];
  }else{
    header("Location: ".ROOT_URL."");
    echo "something is wrong";
  }
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="#">Blog</a>
  <button class="btn ml-auto mr-1"><a class="nav-link" href="<?php echo ROOT_URL; ?>logout.php">Log Out</a></button>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>home.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <?php if(strcmp($role, 'dev')==0): ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo ROOT_URL; ?>dev.php">Dev<span class="sr-only">(current)</span></a>
        </li>
        <?php endif; ?>
      <?php if(strcmp($role, 'Admin')==0): ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo ROOT_URL; ?>admin.php">Admin<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo ROOT_URL; ?>createdev.php">Create Developer<span class="sr-only">(current)</span></a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>mypost.php">My Posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>addpost.php">Add Post</a>
      </li>
    </ul>
  </div>
</nav>