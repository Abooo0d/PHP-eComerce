<?php
  function lang($phrase){
    static $lang = array(
      // Navbar Phrases
      "CATAGORIES"       => "Catagories",
      "ITEMS"            => "Items",
      "MEMBERS"          => "Members",
      "COMMENTS"         => "Comments",
      "STATISTICS"       => "Statistics",
      "LOGS"             => "Logs",
      "EDITE_PROFILE"    => "Edite Profile",
      "SETTINGS"         => "Settings",
      "LOGOUT"           => "Logout"
    );
    return $lang[$phrase];
  }
?>
