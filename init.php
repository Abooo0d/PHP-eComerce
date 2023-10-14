<?php
  include "Admin/connect.php";
  //Routes
  $tpl =     "Includes/Templates/";  // Templates Directory
  $lang =    "Includes/Languages/";  // Languages Directory
  $func =    "Includes/Functions/";  // Functions Directory
  $img =     "Layout/Images/";  // Images Directory
  $css =     "Layout/Css/";  // Css Directory
  $js =      "Layout/Js/";  // Js Directory

  //Include The Important Files
  include $func .   "functions.php";  // The Functions File
  include $lang .   "english.php";  // The Language File
  include $tpl .    "head.php";  // The head File
?>
