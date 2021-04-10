<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
        $id = validate($_SESSION["id"]);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $id = (int) $id; 
    }

    // echo "You're about to remove user with the id of " . $id . ".";

    // checkIfUserWithAnIDExists($dbh, $id);

    removeUser($dbh, $id);

?>