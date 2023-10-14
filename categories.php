<?php
  include "init.php"; // Include The Init File
  $cat_ID = $_GET["Cat_ID"];
  $cat_Name =str_replace("-"," ", $_GET["PageName"]);
?>
  <div class="container">
    <h1 class="label text-center">
    <?php  echo $cat_Name;?>
    </h1>
    <div class="container">
      <div class="item-con">
        <?php
          $items = GetElements("Items","cat_ID",$cat_ID);
          foreach($items as $item):
            ?>
            <div class="item">
              <div class="image">
                <img class="cover" src="<?php echo $img;?>items/1.jpg" alt="">
              </div>
              <h3 class ="item-name"><?php echo $item["Name"];?></h3>
              <p class="item-desc"><?php echo $item["Description"]?></p>
              <span class="item-price"><?php echo $item["Price"];?></span>
            </div>
            <?php
          endforeach;
        ?>
      </div>
    </div>
  </div>
<?php
  include $tpl . "footer.php";  // include The Footer File
?>
