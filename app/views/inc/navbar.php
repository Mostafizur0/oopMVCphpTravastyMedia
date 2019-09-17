<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-static-top fixed-top">
<div class="container">
  <a class="navbar-brand" href="<?php echo URLROOT; ?>/views/pages/index.php"><?php echo SITENAME; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo URLROOT; ?>/views/pages/index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if(isset($_SESSION['user_id'])) : ?>
      <li class="nav-item ">
        <a class="nav-link" href="#">Welcome <?php echo $_SESSION['user_name']; ?></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout<span class="sr-only">(current)</span></a>
      </li>
      <?php else : ?>
      <li class="nav-item ">
        <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
      <?php endif; ?>
    </ul>
    </div>
  </div>
</nav>