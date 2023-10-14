<?php
  function GetElements ($table,$row = null,$value = null){
    global $con;
    $query = "";
    if($row != null){
      if($value != null){
        $query = "WHERE $row = $value";
      }
    }
    $elementStmt = $con->prepare("SELECT * FROM $table $query");
    $elementStmt -> execute();
    $elements = $elementStmt->fetchAll();
    return $elements;
  }
  function GetElementCount($table,$row = null,$value = null){
    global $con;
    $query = "";
    if($row != null){
      if($value != null){
        $query = "WHERE $row = '$value'";
      }
    }
    $elementStmt = $con->prepare("SELECT * FROM $table $query");
    $elementStmt -> execute();
    $elementsCount = $elementStmt->rowCount();
    return $elementsCount;
    return " ";
  }
  function Redirect($second = 3,$url = null , $title = "Home Page") {
    if($url == null) {
      $url == "index.php";
    } elseif($url == "back") {
      $url = $_SERVER["HTTP_REFERER"];
    }
    echo "<div class='alert alert-info'>You Will Be Redirect To $title After $second Seconds</div>";
    header("refresh:$second;url=$url");
    exit();
  }
?>
