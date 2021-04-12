<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    if(isset($_POST["id"]) && !empty($_POST["id"])) {
        $id = validate($_POST["id"]);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $id = (int) $id; 
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like there was no ID-number or the number was incorrect, so we can't remove the message. ";
        
        header("Location: error.php");
    }

    if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
        // echo "<p>You'are about to remove the message, with an ID of " . $id . "</p>";

        removeSingleMessage($dbh, $id);
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like you're not logged in, so you can't remove the message. ";
        
        header("Location: error.php");
    }
   
?>