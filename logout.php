<?php
    session_start();
    
    $_SESSION['id'] = "";
    $_SESSION["error"] = "";
   
    if(empty($_SESSION['id'])) {
        header("location: index.php");
    }
?>