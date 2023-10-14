<?php
  session_start();
  $noNavbar = "";
  $pageTitle = "Login";
  if(isset($_SESSION["username"])){  // Check If The  Session Is Regestred
    header("location: dashboard.php");  // Redirect To Dashboard Page
    exit;
  }
  include "init.php";
  // Check If User Coming From Post HTTP Post Request
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashpass = sha1($password);
    // Check If The User Existe In The Database
    $stmt = $con->prepare(" SELECT
                                User_ID, Username, Password
                            From
                                Users
                            Where
                                Username = ?
                            AND
                                Password = ?
                            And
                                GroupID = 1
                            LIMIT 1");
    $stmt->execute(array($username,$hashpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){  //Check If The Database Contain Recorde About This Username
      $_SESSION["username"] = $username;  //Regestr The Username In The Session
      $_SESSION["UserID"] = $row["UserID"];  // Regestar The ID In The Session
      header("Location: dashboard.php");  // Redirec To Dashboard Page
      exit;
    }
  }
?>
<div class="login-page">
  <div class="login-form">
    <div class="welcome">
      <img src="Layout/Images/welcome.jpg" alt="" class="">
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="login">
      <h3 class="label">Login Form</h3>
      <input class="form-control" type="text" name="username" placeholder="username" autocomplete="off" />
      <div class="re">
        <input class="form-control password" type="password" name="password" placeholder="password" autocomplete="new-password" />
        <span class = "pass-btn">
          <i class="fa-solid fa-eye show-pass"></i>
        </span>
      </div>
      <input class="btn btn-primary btn-block login-btn" type="submit" value="Login" >
    </form>
  </div>
</div>
<?php include $tpl . "footer.php"; ?>
