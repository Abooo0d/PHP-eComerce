<?php
  ob_start();
  session_start();
  $page_title = "Comments";
  if(isset($_SESSION["username"])){
    include "init.php";
    $action = isset($_GET["Action"]) ? $_GET["Action"] : "Manage";
    if($action == "Manage") {
      $stmt = $con->prepare("SELECT Comments.*,Users.Username As Username, Items.Name As Item_Name from Comments
                              INNER JOIN Users ON Users.User_ID = Comments.User_ID
                              INNER JOIN Items ON Items.ID = Comments.Item_ID");
      $stmt->execute();
      $comments = $stmt->fetchAll();
      $rowCount = $stmt->rowCount();?>
      <div class="container">
        <h1 class="label text-center">Commetns Page</h1>
        <?php if($rowCount > 0): ?>
        <div class="tabel-responsive">
          <table class="main-table">
            <tr>
              <th>#ID</th>
              <th>Comment</th>
              <th>Username</th>
              <th>Item Name</th>
              <th>Control</th>
            </tr>
            <?php foreach($comments as $comment):
              $disable = "";
              if($comment["Approved"] == 1){
                $disable = "disable";
              }
              ?>
            <tr>
              <td><?php echo $comment["ID"]; ?></td>
              <td><?php echo $comment["Comment"]; ?></td>
              <td><?php echo $comment["Username"]; ?></td>
              <td><?php echo $comment["Item_Name"]; ?></td>
              <td>
              <a href="comments.php?Action=Edite&Com_ID=<?php echo $comment['ID'];?>" class="btn update-btn">
                <i class="fa fa-edit"></i>
              </a>
              <a href="comments.php?Action=Delete&Com_ID=<?php echo $comment['ID'];?>" class="btn delete-btn confirme">
                <i class="fa-solid fa-trash-can"></i>
              </a>
              <a href="comments.php?Action=Approve&Com_ID=<?php echo $comment['ID'];?>" class="btn info-btn <?php echo $disable?>">
                <i class="fa-solid fa-check"></i>
              </a>
              </td>
            </tr>
            <?php endforeach; ?>
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
      <?php
    } elseif($action == "Edite") {
      $com_ID = isset($_GET["Com_ID"]) ? $_GET ["Com_ID"] : 0;
      $stmt = $con->prepare("SELECT * FROM Comments WHERE ID = ? LIMIT 1");
      $stmt->execute(array($com_ID));
      $row = $stmt->fetch();
      $rowCount = $stmt->rowCount();
      if($rowCount > 0):?>
      <div class="container">
        <h1 class="label text-center">Edite Page</h1>
        <div class="con">
          <div class="image">
            <img src="<?php echo $img;?>Comments.png" alt="">
          </div>
          <form action="?Action=Update" method="POST" class="form-horizontal">
            <input type="hidden" name="com_id" value="<?php echo $row["ID"];?>">
            <!-- Start Comment Field -->
            <div class="form-group">
              <h3>Comment:</h3>
              <!-- <input type="text" class="form-control" name="comment" autocomplete="off" required="required" placeholder="The Comment" value="<?php echo $row['Comment'];?>"> -->
              <textarea name="comment" class="comment-field form-control" required="required" placeholder="The Comment">
                <?php echo $row['Comment'];?>
              </textarea>
            </div>
            <div class="form-group">
              <input type="submit" value="Update Comment" name="edite-comment" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
      endif;
    } elseif($action == "Update"){
      ?>
      <div class="container">
        <h1 class="label text-center">Update Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"){
            $com_id = $_POST["com_id"];
            $comment = $_POST["comment"];
            $error = "";
            if(empty($comment)) $error = "The Comment Can`t Be Empty";
            if(empty($error)){
              $stmt = $con->prepare("UPDATE Comments SET Comment = ? WHERE ID = ?");
              $stmt->execute(array($comment,$com_id));?>
              <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Comment Updated";?></div>
            <?php
              Redirect(5,"comments.php","Comments Page");
            } else {
              ?>
              <div class="alert alert-danger"><?php echo $error; ?> </div>
              <?php
            }
          }
        ?>
      </div>
      <?php
    } elseif($action == "Delete"){
      ?>
      <div class="container">
        <h1 class="label text-center">Delete Page</h1>
      <?php
      $com_id = isset($_GET["Com_ID"]) && is_numeric($_GET["Com_ID"]) ? $_GET["Com_ID"] : 0;
      $count = CheckItem("ID","Comments",$com_id);
      if($count > 0):
        $stmt = $con->prepare("DELETE FROM Comments WHERE ID = :com");
        $stmt->bindParam("com",$com_id);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Comment Deleted"; ?></div>
        <?php
          Redirect(5,"comments.php","Comments Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Comment Deleted"; ?></div>
      <?php
        Redirect(5,"comments.php","Comments Page");
      endif;
    } elseif($action == "Approve"){
      ?>
      <div class="container">
        <h1 class="label text-center">Approve Page</h1>
      <?php
      $com_id = isset($_GET["Com_ID"]) && is_numeric($_GET["Com_ID"]) ? $_GET["Com_ID"] : 0;
      $count = CheckItem("ID","Comments",$com_id);
      if($count > 0):
        $stmt = $con->prepare("UPDATE Comments Set Approved = 1 WHERE ID = :com");
        $stmt->bindParam("com",$com_id);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Comment Approved"; ?></div>
        <?php
          Redirect(5,"comments.php","Comments Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Comment Approved"; ?></div>
      <?php
          Redirect(5,"comments.php","Comments Page");
      endif;
    }
    include  $tpl . "footer.php";
  } else {
    header("Location: index.php");
    exit();
  }
  ob_end_flush();
?>


<!-- SELECT Comments.*,Users.Username As Username,Items.Name As Itemname FROM Comments
INNER JOIN users ON users.User_ID = comments.User_ID
INNER JOIN Items ON Items.ID = comments.Item_ID -->
