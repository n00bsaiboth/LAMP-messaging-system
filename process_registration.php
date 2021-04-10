<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    if(isset($_POST["username"]) && !empty($_POST["username"])) {
        $username = validate($_POST["username"]);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like you did not fill the username in the form. ";
        
        header("Location: error.php");
    }

    if(isset($_POST["password"]) && !empty($_POST["password"])) {
        $password = validate($_POST["password"]);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        // if you need to view the password in plain text, here is your chance.
        // $password_in_plaintext = $password;
        
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like you did not fill the password in the form. ";
        
        header("Location: error.php");
    }

    // check if the username already exists, if it does, then send an error to the user that
    // the username has already been taken.

    checkIfUserExists($dbh, $username);

    // then run another query, if the username does not exist. 
    // if the statement runs smoothly, the user will be added to the user table, then
    // get redirected to index.php, which is our homepage. 

    addNewUser($dbh, $username, $password);
?>