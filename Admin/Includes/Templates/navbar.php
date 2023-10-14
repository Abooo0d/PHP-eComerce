<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Abood</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="far fa-chart-bar"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="categories.php"><?php echo lang("CATAGORIES");?></a></li>
        <li class="nav-item"><a class="nav-link" href="items.php"><?php echo lang("ITEMS");?></a></li>
        <li class="nav-item"><a class="nav-link" href="members.php"><?php echo lang("MEMBERS");?></a></li>
        <li class="nav-item"><a class="nav-link" href="comments.php"><?php echo lang("COMMENTS");?></a></li>
      </ul>
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="../index.php"target="blank"><?php echo lang("VISITE SHOP");?></a></li>
        <li><a class="dropdown-item" href="members.php?Action=Edite&UserID=<?php echo $_SESSION['UserID'];?>"><?php echo lang("EDITE_PROFILE");?></a></li>
        <li><a class="dropdown-item" href="#"><?php echo lang("SETTINGS");?></a></li>
        <li><a class="dropdown-item" href="logout.php"><?php echo lang("LOGOUT");?></a></li>
      </ul>
    </div>
  </div>
</nav>
