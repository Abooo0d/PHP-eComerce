<?php
  ob_start();
  session_start();
  $pageTitle = "Dashboard";
  if(isset($_SESSION["username"])){  // Check If The Session Is Regestred
    include "init.php";
    $lastUsers = GetLastItems("*","Users","User_ID","5");
    $lastItems = GetLastItems("*","Items","ID","5");
  ?>
    <!-- Start Dashboard -->
    <div class="container">
      <h1 class="label text-center">Dashboard Page</h1>
      <div class="content">
        <div class="stat total-members">
          <a href="members.php">
            <span>Total Members</span>
            <div class="info">
              <i class="fa-solid fa-users"></i>
              <span><?php echo CheckCount("User_ID", "Users")?></span>
            </div>
          </a>
        </div>
        <div class="stat pending-members">
          <a href="members.php?Action=Manage&Page=Pending">
            <span>Pending Members</span>
            <div class="info">
              <i class="fa-solid fa-user-plus"></i>
              <span><?php echo CheckItem("Approved","Users","0");?></span>
            </div>
          </a>
        </div>
        <div class="stat total-items">
          <a href="items.php">
            <span>Total Items</span>
            <div class="info">
              <i class="fa-solid fa-tags"></i>
              <span><?php echo CheckCount("ID", "Items")?></span>
            </div>
          </a>
        </div>
        <div class="stat total-comments">
          <a href="members.php">
            <span>Total Comments</span>
            <div class="info">
              <i class="fa-solid fa-comment"></i>
              <span><?php echo CheckCount("ID", "Comments")?></span>
            </div>
          </a>
        </div>
      </div>
      <div class="latest">
        <div class="box closed users">
          <div class="panel">
            <div class="panel-heading">
              <div>
                <span>
                  <i class="fa-solid fa-users icon"></i>Latest 5 Users
                </span>
                <span class="arrow">
                  <i class="fa-solid fa-angle-up"></i>
                </span>
              </div>
            </div>
            <div class="panel-body">
              <ul>
                <?php
                  foreach($lastUsers as $last ){
                    ?>
                      <li>
                        <?php echo $last["Username"];?>
                        <a href="members.php?Action=Edite&UserID=<?php echo $last['User_ID'];?>" class="btn update-btn">
                          <i class="fa fa-edit"></i>
                      </a>
                      </li>
                    <?php
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="box items closed">
          <div class="panel">
            <div class="panel-heading">
              <div>
                <span>
                  <i class="fa-solid fa-tags icon"></i>Latest 5 Items
                </span>
                <span class="arrow">
                  <i class="fa-solid fa-angle-up"></i>
                </span>
              </div>
            </div>
            <div class="panel-body">
              <ul>
                <?php
                  foreach($lastItems as $item ){
                    ?>
                      <li>
                        <?php echo $item["Name"];?>
                        <a href="items.php?Action=Edite&Item_ID=<?php echo $item['ID'];?>" class="btn update-btn">
                          <i class="fa fa-edit"></i>
                        </a>
                      </li>
                    <?php
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Dashboard -->
  <?php
    include $tpl . "footer.php";
  } else {
    header("Location: index.php");
    exit;
  }
  ob_end_flush();
?>
