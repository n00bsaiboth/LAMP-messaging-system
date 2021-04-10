<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    include("__/php/header.php");

    if(isset($_POST["username"]) && !empty($_POST["username"])) {
        $username = validate($_POST["username"]);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
    }

    if(isset($_POST["header"]) && !empty($_POST["header"])) {
        $header = validate($_POST["header"]);
        $header = filter_var($header, FILTER_SANITIZE_STRING);
    }

    if(isset($_POST["message"]) && !empty($_POST["message"])) {
        $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

        // $message_in_plain_text = $message;

        $message = openssl_encrypt($message, "AES-128-ECB", $username);
    }

    // checkIfUserExists($dbh, $username);

    $id = getIDnumberOfExistingUser($dbh, $username);

    // getUsernameIfExists($dbh, $username);

    // echo "message in plain text: " . $message . "<br />";

    // echo "encrypted message: " . $encrypted_message . "<br />";

    // echo "You're planning to send this message to user with the ID-number of " . $id . "<br />";

    // echo "from the id-number of " . $_SESSION["id"] . "<br />";

    sendNewMessage($dbh, $id, $_SESSION["id"], $header, $message);
?>