<?php
  session_start();  // Start The Session
  session_unset();  // Unset THe Session
  session_destroy();  // Destroy The Session
  header("Location: index.php");  // Redirect To Login Form
  exit();
?>
