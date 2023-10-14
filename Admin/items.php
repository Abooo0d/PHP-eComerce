<?php
  ob_start();
  session_start();
  $page_title = "Items";
  if(isset($_SESSION["username"])) {
    include "init.php";
    $action = isset($_GET["Action"]) ? $_GET["Action"] : "Manage";
    if($action == "Manage") {  // Start Manage Page
      $query = "";
      if(isset($_GET["Page"]) == "Pending") {
        $query = "WHERE Status = 0";
      }
      $stmt = $con->prepare("SELECT items.*,categories.Name As Cat_Name, Users.Username As Member from items
                              INNER JOIN categories On categories.ID = items.Cat_ID
                              INNER JOIN users ON users.User_ID = items.User_ID $query");
      $stmt->execute();
      $items = $stmt->fetchAll();
      $rowCount = $stmt->rowCount();
      ?>
      <div class="container">
        <h1 class="label text-center">Manage Items Page</h1>
        <?php
          if($rowCount > 0):
        ?>
        <div class="tabel-responsive">
          <table class="main-table">
            <tr>
              <th>#ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Date</th>
              <th>Made Conuntry</th>
              <th>Categorie</th>
              <th>Member</th>
              <th>Control</th>
            </tr>
              <?php
                foreach($items as $item):
                  $disable = "";
                  if($item["Approved"] == 1){
                    $disable = "disable";
                  }
              ?>
              <tr>
                <td><?php echo $item["ID"];?></td>
                <td><?php echo $item["Name"];?></td>
                <td><?php echo $item["Description"];?></td>
                <td><?php echo $item["Price"];?></td>
                <td><?php echo $item["Date"];?></td>
                <td><?php echo $item["Made_Country"];?></td>
                <td><?php echo $item["Cat_Name"];?></td>
                <td><?php echo $item["Member"];?></td>
                <td>
                  <a href="items.php?Action=Edite&Item_ID=<?php echo $item['ID'];?>" class="btn update-btn"><i class="fa fa-edit"></i> </a>
                  <a href="items.php?Action=Delete&Item_ID=<?php echo $item['ID'];?>" class="btn delete-btn confirme"><i class="fa-solid fa-trash-can"></i></a>
                  <a href="items.php?Action=Approve&Item_ID=<?php echo $item['ID'];?>" class="btn info-btn <?php echo $disable?>"><i class="fa-solid fa-check"></i></a>
                </td>
              </tr>
              <?php
                endforeach;
              ?>
          </table>
        </div>
        <?php
          else:
            ?>
              <div class="no-elements">
                Thers No Items Inserted To The Database Yet
              </div>
            <?php
          endif;
        ?>
      </div>
      <a href="items.php?Action=Add" class=" btn add-btn"><i class="fa fa-plus"></i> New Item</a>
      <?php
    } elseif($action == "Add") {  // Start Add Page
      ?>
      <div class="container">
        <h1 class="text-center label">Add Page</h1>
        <div class="con">
          <div class="images">
            <img src="<?php echo $img;?>items.png" class="">
          </div>
          <form action="?Action=Insert" method="POST" class="form-horizontal">
            <!-- Start Name Field -->
            <div class="form-group">
              <h3>Item Name:</h3>
              <input type="text" class="form-control" name="name" autocomplete="off" required="required" placeholder="The Item Name Will Show To Customer">
            </div>
            <!-- Start Descreption Field -->
            <div class="form-group">
              <h3>Description:</h3>
              <input type="text" class="form-control" name="description" autocomplete="off" placeholder="The Item Description">
            </div>
            <!-- Start Price Field -->
            <div class="form-group">
              <h3>Price:</h3>
              <input type="text" class="form-control" name="price" autocomplete="off" requierd="required"  placeholder="The Item Price">
            </div>
            <!-- Start Manufacturing Country Field -->
            <div class="form-group">
              <h3>Manufacturing Country:</h3>
              <input type="text" class="form-control" name="made_country" autocomplete="off" requierd="required"  placeholder="The Manufacturing Country Of The Item">
            </div>
            <!-- Start Status Field -->
            <div class="form-group">
              <h3>Item Status:</h3>
              <select name="status" class="form-control">
                <option value="0">...</option>
                <option value="1">New</option>
                <option value="2">Like New</option>
                <option value="3">Used</option>
                <option value="4">Very OLd</option>
              </select>
            </div>
            <!-- Start Memebers Field -->
            <div class="form-group">
              <h3>Member:</h3>
              <select name="member" class="form-control">
                <option value="0">...</option>
                <?php
                  $stmt2 = $con->prepare("SELECT User_ID,Username From Users");
                  $stmt2->execute();
                  $members = $stmt2->fetchAll();
                  foreach($members as $member):
                ?>
                <option value="<?php echo $member['User_ID'];?>"><?php echo $member['Username'];?></option>
                <?php endforeach;?>
              </select>
            </div>
            <!-- start Categories Field -->
            <div class="form-group">
              <h3>Categories: </h3>
              <select name="categorie" class="form-control">
                <option value="0">...</option>
                <?php
                  $stmt3 = $con->prepare("SELECT ID,Name From Categories");
                  $stmt3->execute();
                  $cats = $stmt3->fetchAll();
                  foreach($cats as $cat):
                ?>
                <option value="<?php echo $cat['ID'];?>"><?php echo $cat['Name'];?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <input type="submit" value="Add Item" name="add-item" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
    } elseif($action == "Edite") {
      $item_ID = isset($_GET["Item_ID"]) && is_numeric($_GET["Item_ID"]) ? $_GET["Item_ID"] : 0;
      $stmt = $con->prepare("SELECT * FROM Items WHERE ID = ? LIMIT 1");
      $stmt->execute(array($item_ID));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0):
      ?>
      <div class="container">
        <h1 class="label text-center">Edite Itme Page</h1>
        <div class="con">
          <div class="images">
            <img src="<?php echo $img;?>items.png" class="">
          </div>
          <form action="?Action=Update" method="POST" class="form-horizontal">
            <input type="hidden" name="item_id" value="<?php echo $item_ID; ?>">
            <!-- Start Name Field -->
            <div class="form-group">
              <h3>Item Name:</h3>
              <input type="text" class="form-control" name="name" autocomplete="off" required="required" placeholder="The Item Name Will Show To Customer" value="<?php echo $row['Name'];?>">
            </div>
            <!-- Start Descreption Field -->
            <div class="form-group">
              <h3>Description:</h3>
              <input type="text" class="form-control" name="description" autocomplete="off" placeholder="The Item Description" value="<?php echo $row['Description'];?>">
            </div>
            <!-- Start Price Field -->
            <div class="form-group">
              <h3>Price:</h3>
              <input type="text" class="form-control" name="price" autocomplete="off" requierd="required"  placeholder="The Item Price" value="<?php echo $row['Price'];?>">
            </div>
            <!-- Start Manufacturing Country Field -->
            <div class="form-group">
              <h3>Manufacturing Country:</h3>
              <input type="text" class="form-control" name="made_country" autocomplete="off" requierd="required"  placeholder="The Manufacturing Country Of The Item" value="<?php echo $row['Made_Country'];?>">
            </div>
            <!-- Start Status Field -->
            <div class="form-group">
              <h3>Item Status:</h3>
              <select name="status" class="form-control">
                <option value="0">...</option>
                <option value="1"<?php echo $row["Status"] == 1 ? "selected" : "";?>> New</option>
                <option value="2"<?php echo $row["Status"] == 2 ? "selected" : "";?>>Like New</option>
                <option value="3"<?php echo $row["Status"] == 3 ? "selected" : "";?>>Used</option>
                <option value="4"<?php echo $row["Status"] == 4 ? "selected" : "";?>>Very OLd</option>
              </select>
            </div>
            <!-- Start Memebers Field -->
            <div class="form-group">
              <h3>Member:</h3>
              <select name="member" class="form-control">
                <option value="0">...</option>
                <?php
                  $stmt2 = $con->prepare("SELECT User_ID,Username From Users");
                  $stmt2->execute();
                  $members = $stmt2->fetchAll();
                  foreach($members as $member):
                ?>
                <option value="<?php echo $member['User_ID'];?>" <?php echo $row["User_ID"] == $member['User_ID'] ? "selected" : "";?>><?php echo $member['Username'];?></option>
                <?php endforeach;?>
              </select>
            </div>
            <!-- start Categories Field -->
            <div class="form-group">
              <h3>Categories: </h3>
              <select name="categorie" class="form-control">
                <option value="0">...</option>
                <?php
                  $stmt3 = $con->prepare("SELECT ID,Name From Categories");
                  $stmt3->execute();
                  $cats = $stmt3->fetchAll();
                  foreach($cats as $cat):
                ?>
                <option value="<?php echo $cat['ID'];?>" <?php echo $row["Cat_ID"] == $cat['ID'] ? "selected" : "";?>><?php echo $cat['Name'];?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <input type="submit" value="Update Item" name="add-item" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
      endif;
    } elseif($action == "Insert") { // Start Insert Page
      ?>
      <div class="container">
        <h1 class="text-center label">insert Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name = $_POST["name"];
            $desc = $_POST["description"];
            $price = $_POST["price"];
            $made = $_POST["made_country"];
            $status = $_POST["status"];
            $member = $_POST["member"];
            $cat = $_POST["categorie"];
            $errors = array();
            if(empty($name)) $errors[] = "The Name Can`t Be Empty";
            if(empty($price)) $errors[] = "The Price Can`t Be Empty";
            if(empty($made)) $errors[] = "The Made Counter Can`t Be Empty";
            if(empty($status)) $errors[] = "The Status Can`t Be Empty";
            if(empty($member)) $errors[] = "The Member Can`t Be Empty";
            if(empty($cat)) $errors[] = "The Categorie Can`t Be Empty";
            if(empty($errors)) {
              $stmt = $con->prepare("INSERT INTO Items (Name, Description, Price,Date,	Made_Country, Status, Cat_ID, User_ID)
              VALUES (:name, :description, :price,now(), :made, :status, :cat, :member)");
              $stmt->execute(array(
                "name"          => $name,
                "description"   => $desc,
                "price"         => $price,
                "made"          => $made,
                "status"        => $status,
                "cat"           => $cat,
                "member"        => $member
              )); ?>
              <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Item Add";?></div>
              <?php
              Redirect(5,"items.php","Items Page");
            } else {
              foreach($errors as $error) :?>
                <div class="alert alert-danger"><?php echo $error; ?> </div>
            <?php
              endforeach;
              Redirect(5,"itmes.php?Action=Add","Items Page");
            }
          } else {
            echo'<div class="alert alert-danger"><?php echo $error; ?>You Are Not Allowed To Brows This Page Directly </div>';
            Redirect(5,"members.php","Members Page");
          }
        ?>
      </div>
      <?php
    } elseif($action == "Update") {?>
      <div class="container">
        <h1 class="text-center label">Update Item Page</h1>
      <?php
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $item_id = $_POST["item_id"];
        $name  = $_POST["name"];
        $desc = $_POST["description"];
        $price = $_POST["price"];
        $made = $_POST["made_country"];
        $status = $_POST["status"];
        $member = $_POST["member"];
        $cat = $_POST["categorie"];
        $errors = array();
        if(empty($name)) $errors[] = "The Name Can`t Be Empty";
        if(empty($price)) $errors[] = "The Price Can`t Be Empty";
        if(empty($made)) $errors[] = "The Made Counter Can`t Be Empty";
        if(empty($status)) $errors[] = "The Status Can`t Be Empty";
        if(empty($member)) $errors[] = "The Member Can`t Be Empty";
        if(empty($cat)) $errors[] = "The Categorie Can`t Be Empty";
        if(empty($errors)) {
          $stmt = $con->prepare("UPDATE Items SET Name = ?, Description = ?, Price = ?, 	Made_Country = ?, Status = ?, Cat_ID = ?, User_ID = ?
                                  WHERE ID = ?");
          $stmt->execute(array($name, $desc, $price, $made, $status, $cat, $member, $item_id));?>
          <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Item Add";?></div>
          <?php
          Redirect(5,"items.php","Items Page");
        } else {
          foreach($errors as $error) :?>
            <div class="alert alert-danger"><?php echo $error; ?> </div>
          <?php
          endforeach;
        }
      } else {
        echo'<div class="alert alert-danger"><?php echo $error; ?>You Are Not Allowed To Brows This Page Directly </div>';
        Redirect(5,"items.php","Items Page");
      }
      ?>
      </div>
      <?php
    } elseif($action == "Delete") {
      ?>
      <div class="container">
        <h1 class="label text-center">Delete Item Page</h1>
      <?php
      $item_id = isset($_GET["Item_ID"]) && is_numeric($_GET["Item_ID"]) ? $_GET["Item_ID"] : 0;
      $count = CheckItem("ID","Items",$item_id);
      if($count > 0):
        $stmt = $con->prepare("DELETE FROM Items WHERE ID = :item");
        $stmt->bindParam("item",$item_id);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
        <?php
          Redirect(5,"items.php","Items Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
      <?php
        Redirect(5,"items.php","Items Page");
      endif;
    } elseif($action == "Approve"){
      ?>
      <div class="container">
        <h1 class="label text-center">Approve Item Page</h1>
      <?php
      $item_id = isset($_GET["Item_ID"]) && is_numeric($_GET["Item_ID"]) ? $_GET["Item_ID"] : 0;
      $count = CheckItem("ID","Items",$item_id);
      if($count > 0):
        $stmt = $con->prepare("UPDATE Items Set Approved = 1 WHERE ID = :item");
        $stmt->bindParam("item",$item_id);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Recored Approved"; ?></div>
        <?php
          Redirect(5,"items.php","Items Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Recored Approved"; ?></div>
      <?php
        Redirect(5,"items.php","Items Page");
      endif;
    }
    include $tpl . "footer.php";
  } else {
    header("Location: index.php");
    exit();
  }
  ob_end_Flush();
?>

