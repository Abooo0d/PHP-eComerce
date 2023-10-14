<?php
  function getTitle() {
    global $pageTitle;
    if(isset($pageTitle)){
      echo $pageTitle;
    } else {
      echo "Defulte";
    }
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
  function CheckItem($select,$from,$value) {
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;
  }
  function CheckCount($select, $table) {
    global $con;
    $statment = $con->prepare("SELECT COUNT($select) FROM $table");
    $statment->execute();
    $count = $statment->fetchColumn();
    return $count;
  }
  function GetLastItems($select,$table,$order,$limit){
    global $con;
    $statment = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $statment->execute();
    $result = $statment->fetchAll();
    return $result;
  }
?>
