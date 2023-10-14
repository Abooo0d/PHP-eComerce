<?php
  ob_start();
  session_start();
  $pageTitle = "Categories";
  if(isset($_SESSION["username"])){
    include "init.php";
    $action = isset($_GET["Action"]) ? $_GET["Action"] : "Manage";
    if($action == "Manage") { // Start Maneg Categories Page
      $Order = "Asc";
      $order_values = ["Asc","Desc"];
      $Order = isset($_GET["Order"]) && in_array($_GET["Order"],$order_values) ? $_GET["Order"] : "Asc";
      $stmt = $con->prepare("SELECT * FROM Categories ORDER BY Arrange $Order");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $rowsCount = $stmt->rowCount();
      ?>
      <div class="container categories">
        <h1 class="text-center label">Mange Page</h1>
        <?php if($rowsCount > 0): ?>
        <div class="box">
          <div class="panel">
            <div class="panel-heading">
              All Categories
              <div class="ord">
                <span class="order"><i class="fa fa-sort"></i></span>[
                <a class="<?php echo $Order == 'Asc' ? 'active' : ""; ?>" href="?Order=Asc">Asc</a>
                <a class="<?php echo $Order == 'Desc' ? 'active' : ""; ?>" href="?Order=Desc">Desc</a>]
              </div>
            </div>
            <div class="panel-body">
              <ul>
                <?php
                  foreach($result as $row ):
                    ?>
                      <li>
                        <div class="info">
                          <h3> <?php echo $row["Name"];?> </h3>
                          <div class="full-view">
                            <p> <?php echo $row["Description"] == "" || $row["Description"] == null ? "No Description On This Categorie" : $row["Description"]; ?></p>
                            <span class="visibllity"><i class="fa fa-eye"></i> <?php echo $row["Visibllity"] == "1" ? "Visible" : "Hidden" ;?> </span>
                            <span class="comments"> <i class="fa fa-list"></i> <?php echo $row["Allow_Comment"] == "1" ? "Commets Allowed" : "Comments Disabled";?> </span>
                            <span class="ads"> <i class="fa fa-ad"></i>  <?php echo $row["Allow_Ads"] == "1" ? "Ads Allowed" : "Ads Disapled"; ?></span>
                          </div>
                        </div>
                        <div class="controls">
                        <a href="categories.php?Action=Edite&CatID=<?php echo $row['ID'];?>" class="btn update-btn"><i class="fa fa-edit"></i></a>
                        <a href="categories.php?Action=Delete&CatID=<?php echo $row['ID'];?>" class="btn delete-btn confirme"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                      </li>
                    <?php
                  endforeach;
                ?>
              </ul>
            </div>
          </div>
        </div>
        <?php
          else:
            ?>
              <div class="no-elements">
                Thers No Categories Inserted To The Database Yet
              </div>
            <?php
          endif;
        ?>
      </div>
      <a href="categories.php?Action=Add" class=" btn add-btn"><i class="fa fa-plus"></i> New Categorie</a>
      <?php
    } elseif ($action == "Add") {  // Start Add Categories Page
      ?>
      <div class="container">
        <h1 class="text-center label">Add Categories Page</h1>
        <div class="con">
          <div class="images">
            <img src="<?php echo $img;?>categories.jpg" alt="">
          </div>
          <form action="?Action=Insert" method="POST">
            <!-- Name Field -->
            <div class="form-group">
              <h3 >Name:</h3>
              <input type="text" name="name" class="form-control" placeholder="Categorie Name" autocomplete="off" required="required">
            </div>
            <!-- Descreption Field -->
            <div class="form-group">
              <h3 >Description:</h3>
              <input type="text" name="description"class="form-control"  placeholder="Descreption About The Categorie" autocomplete="off">
            </div>
            <!-- Ordering Field -->
            <div class="form-group">
              <h3 >Arrange:</h3>
              <input type="text" name="arrange"class="form-control"  placeholder="The Order Of The Categories" autocomplete="off" required="required">
            </div>
            <!-- Visibllity Field -->
            <div class="form-group">
              <h3 >Visibllity:</h3>
              <div class="main-radio">
                <input type="radio" name="visable" id="vis-yes" value="1" checked>
                <label for="vis-yes">Visible</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="visable" id="vis-no"  value="0">
                <label for="vis-no">Hidden</label>
              </div>
            </div>
            <!-- Comments Field -->
            <div class="form-group">
              <h3 >Comments:</h3>
              <div class="main-radio">
                <input type="radio" name="comment" id="com-yes" value="1" checked>
                <label for="com-yes">Allowe Comments</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="comment" id="com-no" value="0">
                <label for="com-no">Disable Comments</label>
              </div>
            </div>
            <!-- Ads Field -->
            <div class="form-group">
              <h3 >Ads:</h3>
              <div class="main-radio">
                <input type="radio" name="ads" id="ads-yes" value="1" checked>
                <label for="ads-yes">Allowe Ads</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="ads" id="ads-no" value="0">
                <label for="ads-no">Disable Ads</label>
              </div>
            </div>
            <div class="form-group">
              <input type="submit" value="Add Categorie" name="add-cat" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
    } elseif ($action == "Edite") {  // Start Edite Categories Page
      $catid = isset($_GET["CatID"]) && is_numeric($_GET["CatID"]) ? $_GET["CatID"] : 0;
      $stmt = $con->prepare("SELECT * FROM Categories WHERE ID = ? LIMIT 1 ");
      $stmt->execute(array($catid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0):
      ?>
      <div class="container">
        <h1 class="text-center label">Edite Page</h1>
        <div class="con">
          <div class="images">
          <img src= "<?php echo $img;?>categories.jpg"class="">
          </div>
          <form action="?Action=Update" method="POST" class="form-horizontal">
          <input type="hidden" name="catid" value="<?php echo $catid; ?>">
            <!-- Name Field -->
            <div class="form-group">
              <h3 >Name:</h3>
              <input type="text" name="name" class="form-control" placeholder="Categorie Name" value="<?php echo $row["Name"]; ?>" required="required">
            </div>
            <!-- Descreption Field -->
            <div class="form-group">
              <h3 >Description:</h3>
              <input type="text" name="description"class="form-control" placeholder="Description About The Categorie" value="<?php echo $row["Description"]; ?>" autocomplete="off">
            </div>
            <!-- Ordering Field -->
            <div class="form-group">
              <h3 >Arrange:</h3>
              <input type="text" name="arrange"class="form-control"  placeholder="The Order Of The Categories" value="<?php echo $row["Arrange"]; ?>" autocomplete="off" required="required">
            </div>
            <!-- Visibllity Field -->
            <div class="form-group">
              <h3 >Visibllity:</h3>
              <div class="main-radio">
                <input type="radio" name="visable" id="vis-yes" value="1" <?php echo $row["Visibllity"] == 1 ? "Checked" : ""; ?> >
                <label for="vis-yes">Visible</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="visable" id="vis-no"  value="0" <?php echo $row["Visibllity"] == 0 ? "Checked" : ""; ?> >
                <label for="vis-no">Hidden</label>
              </div>
            </div>
            <!-- Comments Field -->
            <div class="form-group">
              <h3 >Comments:</h3>
              <div class="main-radio">
                <input type="radio" name="comment" id="com-yes" value="1" <?php echo $row["Allow_Comment"] == 1 ? "Checked" : ""; ?> >
                <label for="com-yes">Allowe Comments</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="comment" id="com-no" value="0" <?php echo $row["Allow_Comment"] == 0 ? "Checked" : ""; ?> >
                <label for="com-no">Disable Comments</label>
              </div>
            </div>
            <!-- Ads Field -->
            <div class="form-group">
              <h3 >Ads:</h3>
              <div class="main-radio">
                <input type="radio" name="ads" id="ads-yes" value="1" <?php echo $row["Allow_Ads"] == 1 ? "Checked" : ""; ?> >
                <label for="ads-yes">Allowe Ads</label>
              </div>
              <div class="main-radio">
                <input type="radio" name="ads" id="ads-no" value="0" <?php echo $row["Allow_Ads"] == 0 ? "Checked" : ""; ?> >
                <label for="ads-no">Disable Ads</label>
              </div>
            </div>
            <div class="form-group">
              <input type="submit" value="Update" name="add-cat" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
      else :
        echo "There Is No Recorde With This ID";
        Redirect(3,"back","Previous Page");
      endif;
    } elseif($action == "Insert") {  // Start Insert Categories Page
      ?>
      <div class="container">
        <h1 class="text-center label">Insert Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"):
            $name =          $_POST["name"];
            $description =   $_POST["description"];
            $arrange =         $_POST["arrange"];
            $visable =       $_POST["visable"];
            $comment =       $_POST["comment"];
            $ads =           $_POST["ads"];
            if(!empty($name)) {
              $check = CheckItem("Name","Categories",$name);
              if($check > 0){
                echo "<div class='alert alert-danger'> This Categorie Alredy Exist</div>";
                Redirect(5,"categories.php?Action=Add","Add Page");
              } else{
                $stmt = $con->prepare(" INSERT INTO Categories (Name, Description, Arrange, Visibllity, Allow_Comment, Allow_Ads)
                                        VALUES (:name, :description, :arrange, :visibllity, :allow_comments, :allow_ads)");
                $stmt->execute(array(
                  "name"               => $name,
                  "description"        => $description,
                  "arrange"            => $arrange,
                  "visibllity"         => $visable,
                  "allow_comments"     => $comment,
                  "allow_ads"          => $ads
                )); ?>
                <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Categorie Created";?></div>
                <?php
                Redirect(5,"categories.php","Categories Page");
              }
            } else {
              ?>
              <div class="alert alert-danger"><?php echo "Plese Insert A Name For The Categorie Before Adding It"; ?> </div>
              <?php
              Redirect(5,"categories.php?Action=Add","Catagories Page");
            }
          else:
            echo'<div class="alert alert-danger"><?php echo $error; ?>You Are Not Allowed To Brows This Page Directly </div>';
            Redirect(5,"dashboard.php","Dashboard Page");
          endif;
        ?>
      </div>
      <?php
    } elseif ($action == "Update") {  // Start Update Catevgories Page
      ?>
      <div class="container">
        <h1 class="text-center label">Update Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"):
            $catid =            $_POST["catid"];
            $name =             $_POST["name"];
            $description =      $_POST["description"];
            $arrange =          $_POST["arrange"];
            $visable =          $_POST["visable"];
            $comment =          $_POST["comment"];
            $ads =              $_POST["ads"];
            if(!empty($name)) {
              $stmt = $con->prepare(" UPDATE
                                        Categories
                                      SET
                                        Name = ?,
                                        Description = ?,
                                        Arrange = ?,
                                        Visibllity = ?,
                                        Allow_Comment = ?,
                                        Allow_Ads = ?
                                      WHERE
                                        ID = ?");
              $stmt->execute(array($name, $description, $arrange, $visable, $comment, $ads, $catid));
              ?>
              <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Record Updated";?></div>
            <?php
              Redirect(5,"categories.php","Categories Page");
            } else {?>
              <div class="alert alert-danger"><?php echo "Plese Fill The Name Field And Try Again"; ?> </div>
              <?php
              Redirect(5,"Edite.php?UserID=$catid","Edite Page");
            }
          else:
            echo "<div class='alert alert-danger'>You Are Not Allowed To Brows This Page Directly</div>";
            Redirect(5,"categories.php","Categories Page");
          endif;
          ?>
      </div>
      <?php
    } elseif($action == "Delete") {  // Start Delete Categorie Page
      ?>
      <div class="container">
        <h1 class="label text-center">Delete Page</h1>
      <?php
      $catid = isset($_GET["CatID"]) && is_numeric($_GET["CatID"]) ? $_GET["CatID"] : 0;
      $count = CheckItem("ID","Categories",$catid);
      if($count > 0):
        $stmt = $con->prepare("DELETE FROM Categories WHERE ID = :catid");
        $stmt->bindParam("catid",$catid);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
        <?php
          Redirect(5,"categories.php","Categories Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
      <?php
        Redirect(5,"categories.php","Categories Page");
      endif;
    }
    include $tpl . "footer.php";
  } else {
    header("Location: index.php");
  }
  ob_end_flush();
?>
