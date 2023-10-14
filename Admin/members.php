<?php
  ob_start();
  session_start();
  $pageTitle = "Members";
  if(isset($_SESSION["username"])){
    include "init.php";
    $action = isset($_GET["Action"]) ? $_GET["Action"] : "Manage";
    if($action == "Manage") {  //Start Manage Page
      $query = "";
      if(isset($_GET["Page"]) == "Pending") {
        $query = "AND Approved = 0";
      }
      $stmt = $con->prepare("SELECT * FROM Users WHERE GroupID != 1 $query");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $rowsCount = $stmt->rowCount();
      ?>
      <div class="container">
        <h1 class="text-center label">Manage Page</h1>
        <?php
          if($rowsCount > 0):
        ?>
        <div class="tabel-responsive">
          <table class="main-table">
            <tr>
              <th>#ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Fullname</th>
              <th>Registred Date</th>
              <th>Control</th>
            </tr>
            <?php
            foreach($rows as $row):
              $disable = "";
              if($row["Approved"] == 0)
                $disable = "";
              else
                $disable = "disable";
            ?>
              <tr>
                <td><?php echo $row["User_ID"];?></td>
                <td><?php echo $row["Username"];?></td>
                <td><?php echo $row["Email"];?></td>
                <td><?php echo $row["Fullname"];?></td>
                <td><?php echo $row["Date"]; ?></td>
                <td>
                  <a href="members.php?Action=Edite&UserID=<?php echo $row['User_ID'];?>" class="btn update-btn"><i class="fa fa-edit"></i></a>
                  <a href="members.php?Action=Delete&UserID=<?php echo $row['User_ID'];?>" class="btn delete-btn confirme" onclick="showConfirm()"><i class="fa-solid fa-trash-can"></i></a>
                  <a href="members.php?Action=Activat&UserID=<?php echo $row['User_ID'];?>" class="btn info-btn <?php echo $disable?>"><i class="fa-solid fa-check"></i></a>
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
                Thers No Members Inserted To The Database Yet
              </div>
            <?php
          endif;
        ?>
      </div>
      <a href="members.php?Action=Add" class=" btn add-btn"><i class="fa fa-plus"></i> New Member</a>
      <?php
    } elseif($action == "Add") {  // Start Add Members page
      ?>
      <div class="container">
        <h1 class="text-center label">Add Page</h1>
        <div class="con">
          <div class="images">
            <img src= "<?php echo $img;?>profile.png"class="">
          </div>
          <form action="?Action=Insert" method="POST" class="form-horizontal">
            <div class="form-group">
              <h3 class="">Username:</h3>
              <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Type Your Username">
            </div>
            <div class="form-group password active">
              <h3 class="">Password:</h3>
              <div class="re">
                <input class="form-control password" type="password" name="password" placeholder="password" autocomplete="new-password" />
                <span class = "pass-btn">
                  <i class="fa-solid fa-eye show-pass"></i>
                </span>
              </div>
            </div>
            <div class="form-group">
              <h3 class="">Full Name:</h3>
              <input type="text" name="fullname" class="form-control" autocomplete="off" required="required" placeholder="Type Yore Full Name">
            </div>
            <div class="form-group">
              <h3 class="">Email:</h3>
              <input type="text" name="email" class="form-control" autocomplete="off" required="required"Placeholder="Type Your Email">
            </div>
            <div class="form-group">
              <input type="submit" value="Add Member" name="add-member" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
    } elseif($action == "Edite") {  //Start Edite Members page
      $userid = isset($_GET["UserID"]) && is_numeric($_GET["UserID"]) ? $_GET["UserID"] : 0;
      $stmt = $con->prepare("SELECT * FROM Users WHERE User_ID = ? LIMIT 1 ");
      $stmt->execute(array($userid));
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0):
      ?>
      <div class="container">
        <h1 class="text-center label">Edite Page</h1>
        <div class="con">
          <div class="images">
          <img src= "<?php echo $img;?>profile.png"class="">
          </div>
          <form action="?Action=Update" method="POST" class="form-horizontal">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
            <div class="form-group">
              <h3 class="">Username:</h3>
                <input type="text" name="username" class="form-control"value="<?php echo $row['Username'];?>" autocomplete="off" required="required">
            </div>
            <div class="form-group password">
            <div class="re">
              <input type="hidden" name="old-password" class="form-control" autocomplete="new-password" vlaue="<?php echo $row['Password'];?>">
              <input class="form-control password" type="password" name="new-password" placeholder="Leave Blank To Keep The Old Password" autocomplete="new-password" />
              <span class = "pass-btn">
                <i class="fa-solid fa-eye show-pass"></i>
              </span>
            </div>
            </div>
            <div class="form-group">
              <h3 class="">Full Name:</h3>
                <input type="text" name="fullname" class="form-control" value="<?php echo $row['Fullname'];?>" autocomplete="off" required="required">
            </div>
            <div class="form-group">
              <h3 class="">Email:</h3>
                <input type="text" name="email" class="form-control" value="<?php echo $row['Email'];?>" autocomplete="off" required="required">
            </div>
            <div class="form-group">
              <input type="submit" value="Update" name="update" class="btn login-btn">
            </div>
          </form>
        </div>
      </div>
      <?php
      else :
        echo "There Is No Recorde With This ID";
        Redirect(3,"back","Previous Page");
      endif;
    } elseif($action == "Insert"){  // Start Insert Page
      ?>
      <div class="container">
        <h1 class="text-center label">Insert Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"):
            $pass =       $_POST["password"];
            $username =   $_POST["username"];
            $email =      $_POST["email"];
            $fullname =   $_POST["fullname"];
            $hashpass = sha1($pass);
            $errors = array();
            if(empty($username)) {
              $errors[] = "Username Can`t Be Empty!";
            }
            if(strlen($username) < 4) {
              $errors[] = "The Username Must Be More Than 4 Characters!";
            }
            if(strlen($username) > 20) {
              $errors[] = "The Username Cant Be More Than 20 Characters!";
            }
            if(empty($pass)) {
              $errors[] = "Password Can`t Be Empty!";
            }
            if(empty($email)) {
              $errors[] = "Email Can`t Be Empty!";
            }
            if(empty($fullname)) {
              $errors[] = "The Name Can`t Be Empty!";
            }
            if(empty($errors)) {
              $check = CheckItem("Username","Users",$username);
              if($check > 0){
                echo "<div class='alert alert-danger'> This user Alredy Exist</div>";
                Redirect(5,"members.php?Action=Add","Add Page");
              } else{
                $stmt = $con->prepare(" INSERT INTO Users (Username, Password, Email,Fullname,Approved,Date)
                                        VALUES (:user, :pass, :email, :fullname, 1, now())");
                $stmt->execute(array(
                  "user"        => $username,
                  "pass"        => $hashpass,
                  "email"       => $email,
                  "fullname"    => $fullname
                )); ?>
                <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Account Created";?></div>
                <?php
                Redirect(5,"members.php","Members Page");
              }
            } else {
              foreach($errors as $error) :?>
                <div class="alert alert-danger"><?php echo $error; ?> </div>
            <?php
              endforeach;
              Redirect(5,"members.php?Action=Add","Members Page");
            }
          else:
            echo'<div class="alert alert-danger"><?php echo $error; ?>You Are Not Allowed To Brows This Page Directly </div>';
            Redirect(5,"members.php","Members Page");
          endif;
        ?>
      </div>
      <?php
    } elseif($action == "Update") {  // Start Update Members Page
      ?>
      <div class="container">
        <h1 class="text-center label">Update Page</h1>
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST"):
            $userid =     $_POST["userid"];
            $username =   $_POST["username"];
            $email =      $_POST["email"];
            $fullname =   $_POST["fullname"];
            $pass = isset($_POST["new-password"]) ? sha1($_POST["new-password"]) : $_POST["old-password"];
            $errors = array();
            if(empty($username)) {
              $errors[] = "Username Can`t Be Empty! ";
            }
            if(strlen($username) < 4) {
              $errors[] = "The Username Must Be More Than 4 Characters";
            }
            if(strlen($username) > 20) {
              $errors[] = "The Username Cant Be More Than 20 Characters";
            }
            if(empty($email)) {
              $errors[] = "Email Can`t Be Empty!";
            }
            if(empty($fullname)) {
              $errors[] = "The Name Can`t Be Empty";
            }
            if(empty($errors)) {
              $check = $con->prepare("SELECT COUNT(*) FROM Users Where Username = ? And User_ID != ?");
              $check->execute(array($username,$userid));
              $checkcount = $check->fetchColumn();
              if($checkcount > 0):
                echo "<div class='alert alert-danger'> This user Alredy Exist</div>";
                Redirect(5,"members.php?Action=Add","Add Page");
              else:
                $stmt = $con->prepare("UPDATE Users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE User_ID = ?");
                $stmt->execute(array($username, $email, $fullname, $pass, $userid));
                ?>
                <div class="alert alert-success"> <?php echo $stmt->rowCount() . " Record Updated";?></div>
                <?php
                  Redirect(5,"members.php","Members Page");
                endif;
            } else {
              foreach($errors as $error) :?>
                <div class="alert alert-danger"><?php echo $error; ?> </div>
            <?php
              endforeach;
              Redirect(5,"Edite.php?UserID=$userid","Edite Page");
            }
          else:
            echo "<div class='alert alert-danger'>You Are Not Allowed To Brows This Page Directly</div>";
            Redirect(5,"members.php","Members Page");
          endif;
          ?>
      </div>
      <?php
    } elseif($action == "Delete") {  // Start Delete members Page
      ?>
      <div class="container">
        <h1 class="label text-center">Delete Page</h1>
      <?php
      $userid = isset($_GET["UserID"]) && is_numeric($_GET["UserID"]) ? $_GET["UserID"] : 0;
      $count = CheckItem("User_ID","Users",$userid);
      if($count > 0):
        $stmt = $con->prepare("DELETE FROM Users WHERE User_ID = :user");
        $stmt->bindParam("user",$userid);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
        <?php
          Redirect(5,"members.php","Members Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Recored Deleted"; ?></div>
      <?php
        Redirect(5,"members.php","Members Page");
      endif;
    } elseif( $action == "Activat") {  // Start Activat Members Page
      ?>
      <div class="container">
        <h1 class="label text-center">Activat Page</h1>
      <?php
      $userid = isset($_GET["UserID"]) && is_numeric($_GET["UserID"]) ? $_GET["UserID"] : 0;
      $count = CheckItem("user_ID","Users",$userid);
      if($count > 0):
        $stmt = $con->prepare("UPDATE Users Set Approved = 1 WHERE User_ID = :user");
        $stmt->bindParam("user",$userid);
        $stmt->execute();
      ?>
        <div class="alert alert-success"><?php echo $stmt->rowCount() . " Recored Activated"; ?></div>
        <?php
          Redirect(5,"members.php","Members Page");
        ?>
      </div>
      <?php
      else:?>
      <div class="alert alert-dangor"><?php echo $stmt->rowCount() . " Recored Activated"; ?></div>
      <?php
        Redirect(5,"members.php","Members Page");
      endif;
    }
    include $tpl . "footer.php";
  } else {
    header("Location: index.php");
    exit();
  }
  ob_end_flush();
?>
