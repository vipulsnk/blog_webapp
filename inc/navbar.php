<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Blog</a>
  <!-- <span class="ml-auto mr-1"><?php echo $_SESSION['user_name']?></span> -->
  
  <button class="btn ml-auto mr-1"><a class="nav-link" href="<?php echo ROOT_URL; ?>">Log Out</a></button>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>home.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>addpost.php">Add Post</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo ROOT_URL; ?>">Log Out</a>
      </li> -->
    </ul>
  </div>
</nav>