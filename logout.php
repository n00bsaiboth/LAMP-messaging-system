<?php
    session_start();
    
    $_SESSION['id'] = "";
    $_SESSION["error"] = "";
    $_SESSION['username'] = "";
   
    if(empty($_SESSION['id'])) {
        header("location: index.php");
    }
?>