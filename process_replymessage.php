<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    if(isset($_POST["recipient_id"]) && !empty($_POST["recipient_id"])) {
        $recipient_id = validate($_POST["recipient_id"]);
        $recipient_id = filter_var($recipient_id, FILTER_VALIDATE_INT);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $recipient_id = (int) $recipient_id; 

        
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like there was some error with the content of the form. ";
        
        header("Location: error.php");
    }

    if(isset($_POST["sender_id"]) && !empty($_POST["sender_id"])) {
        $sender_id = validate($_POST["sender_id"]);
        $sender_id = filter_var($sender_id, FILTER_VALIDATE_INT);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $sender_id = (int) $sender_id; 

        $username = getUsernameByID($dbh, $sender_id);
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like there was some error with the content of the form. ";
        
        header("Location: error.php");
    }


    if(isset($_POST["header"]) && !empty($_POST["header"])) {
        $header = validate($_POST["header"]);
        $header = filter_var($header, FILTER_SANITIZE_STRING);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $header = (string) $header; 
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like there was some error with the content of the form. ";
        
        header("Location: error.php");
    }

    if(isset($_POST["reply"]) && !empty($_POST["reply"])) {
        $reply = validate($_POST["reply"]);
        $reply = filter_var($reply, FILTER_SANITIZE_STRING);
        
        // this settype seems to mess something up, because
        // the id number is not updating into profile file.
        
        // $id = settype($id, "integer");

        // try another way to do it, see if it works

        $reply = (string) $reply; 

        $reply = openssl_encrypt($reply, "AES-128-ECB", $username);
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like there was some error with the content of the form. ";
        
        header("Location: error.php");
    }

    if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
         echo "<p>You'are about to reply to this message, with a sender ID of " . $sender_id . "</p>";
         echo "<p>You'are sending this message to user, with an recipient ID of " . $recipient_id . "</p>";
         echo "<p>The header will be the same, as follows," . $header . "</p>";
         echo "<p>And the message is, " . $reply . "</p>";

         sendNewMessage($dbh, $sender_id, $recipient_id, $header, $reply);

         header("Location: messages.php");
    } else {
        $_SESSION["error"] = "Unfortunately, it looks like you're not logged in, so you can't remove the message. ";
        
        header("Location: error.php");
    }
   
?>