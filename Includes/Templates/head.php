<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-euive="Cashe-control" content="no-cashe"s>
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
  </head>
  <body>
    <div class="upper-nav-bar">
      <div class="container upper ">
        <div class="login-control">
          <?php
            if(!isset($_SESSION["Clinte"])):
          ?>
          <a href="login.php?Action=Login">
            <span class="login control">Login</span>
          </a>
          <a href="login.php?Action=SignUp">
            <span class="sign-up control">Sign Up</span>
          </a>
          <?php else:?>
            <span class="sign-up control">Welcome <?php echo $_SESSION["Clinte"];?></span>
          <?php endif;?>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">HomePage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"><i class="far fa-chart-bar"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 navbar-right">
          <?php
            $cats = GetElements("Categories");
            foreach($cats as $cat):
              ?>
              <li><a href="categories.php?Cat_ID=<?php echo $cat["ID"];?>&PageName= <?php echo str_replace(" ", "-",$cat["Name"]);?>" class="nav-link"><?php echo $cat["Name"];?></a></li>
              <?php
            endforeach;
          ?>
          </ul>
        </div>
      </div>
    </nav>

