<?php

echo('<script type="text/javascript" src="\public\js\homeView.js"></script>');

if(isset($_SESSION["login"]) && isset($_SESSION["login_time_stamp"]))  
{ 
    if(time()-$_SESSION["login_time_stamp"] > 1800)   
    { 
        session_unset(); 
        session_destroy(); 
        header("Location:/connection/show"); 
    } 
} 
?>
  <div id="subtitle">
  </div>
  <div id="games">
  </div>
  