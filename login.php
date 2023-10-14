<?php
  session_start();
  $pageTitle = "Login";
  $errors = array();
  $approve = array();
  if(isset($_SESSION["Clinte"])){  // Check If The  Session Is Regestred
    header("location: index.php");  // Redirect To Dashboard Page
    exit;
  }
  include "init.php";
  $action = isset($_GET["Action"]) ? $_GET["Action"] : "Login";
?>
<div class="login-page clinte">
  <div class="login-form">
    <div class="welcome">
      <img src="Layout/Images/welcome.jpg" alt="" class="">
    </div>
    <?php
      if($action == "Login"){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          $username = $_POST["username"];
          $password = $_POST["password"];
          $hashpass = sha1($password);
          // Check If The User Existe In The Database
          $stmt = $con->prepare(" SELECT
                                      *
                                  From
                                      Users
                                  Where
                                      Username = ?
                                  AND
                                      Password = ?");
          $stmt->execute(array($username,$hashpass));
          $row = $stmt->fetch();
          $count = $stmt->rowCount();
          if($count > 0){  //Check If The Database Contain Recorde About This Username
            if($row["Approved"] == 1) {  // Check If The Account Is Appproved
              $_SESSION["Clinte"] = $username;  //Regestr The Username In The Session
              header("Location: index.php");  // Redirec To Index Page
              exit;
            } else{
              $errors[] = "This Account Isn`t Approved Yet";
            }
          }else {
            $errors[] = "This Account Don`t Exist In The Database";
          }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>?Action=Login" method="POST" class="login">
          <h3 class="label">Login page</h3>
          <input class="form-control" type="text" name="username" placeholder="username" autocomplete="off" />
          <div class="re">
            <input class="form-control password" type="password" name="password" placeholder="Type Your Password"/>
            <span class = "pass-btn">
              <i class="fa-solid fa-eye show-pass"></i>
            </span>
          </div>
          <input class="btn btn-primary btn-block login-btn" type="submit" value="Login" >
        </form>
        <?php
      } elseif($action == "SignUp"){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          $username = $_POST["username"];
          $password = $_POST["password"];
          $hashpass = sha1($password);
          $fullname = $_POST["fullname"];
          $email = $_POST["email"];
          // Check If The User Existe In The Database
          $check = GetElementCount("Users","Username",$username);
          if($check > 0){
            $errors[] = "This Account Alredy Existe In The Database";
          } else {
            $stmt = $con->prepare(" INSERT INTO Users (Username, Password, Email, Fullname, Date)
            VALUES (:user, :pass, :email, :fullname, now())");
            $stmt->execute(array(
            "user"        => $username,
            "pass"        => $hashpass,
            "email"       => $email,
            "fullname"    => $fullname
            ));
            $approve[] = "Your Account Has Been Created Successfully";
            $approve[] = "You Have To Wait Until Your Account Get Approved By The Admin";
          }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>?Action=SignUp" method="POST" class="login">
          <h3 class="label">Sign Up page</h3>
          <input class="form-control" type="text" name="username" placeholder="Plese Type Your Username"/>
          <div class="re">
            <input class="form-control password" type="password" name="password" placeholder="Type A Scoure Password" autocomplete="new-password" />
            <span class = "pass-btn">
              <i class="fa-solid fa-eye show-pass"></i>
            </span>
          </div>
          <input class="form-control" type="text" name="fullname" placeholder="Plses Type Your Fullname" autocomplete="off" />
          <input class="form-control" type="email" name="email" placeholder="Plese Type Your Email"/>
          <input class="btn btn-primary btn-block sign-btn" type="submit" value="Sign Up" >
        </form>
        <?php
      }
    ?>
  </div>
  <div class="errors">
    <?php
      foreach($approve as $app):?>
        <div class='alert alert-success'> <?php echo $app; ?></div>
        <?php
      endforeach;
      if(!empty($approve)){
        Redirect(5,"login.php","Login Page");
      }
      foreach($errors as $error): ?>
        <div class='alert alert-danger'> <?php echo $error; ?></div>
        <?php
      endforeach;
    ?>
  </div>
</div>
<?php
  include $tpl . "footer.php";
?>
