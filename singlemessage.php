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

    if(isset($_GET["id"]) && !empty($_GET["id"])) {
        $message_id = validate($_GET["id"]);
        $message_id = filter_var($message_id, FILTER_VALIDATE_INT);

        $message_id = (int) $message_id;

        if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
            $get_message = getSingleMessage($dbh, $message_id);

            if($get_message["recipient_id"] == $_SESSION["id"]) {
                $view_message = $get_message;
            }
        }
    }

    

    include("__/php/header.php");
        
?>

    <section class="container" id="message">
        <?php 
		    if(isset($view_message) && !empty($view_message)) {
                echo "<h2>" . $view_message["header"] . "</h2>";
                echo "<p>ID: " . $view_message["id"] . "</p>";
                echo "<p>Encrypted Message: " . $view_message["message"] . "</p>";
                echo "<p>Message in plain text: " . openssl_decrypt($view_message["message"], "AES-128-ECB", $_SESSION["username"]) . "</p>";
            } else {
                $_SESSION["error"] = "Unfortunately, it looks like you have not logged in yet. You need to be logged in to view this message.";

                header("Location: error.php");
            }
        ?>
    </section>

    <section class="container" id="">
        <h2>Reply to this message</h2> 
        <form action=<?php echo htmlspecialchars("process_replymessage.php"); ?> method="post">
            <input type="hidden" id="" name="recipient_id" value="<?php echo $view_message["recipient_id"]; ?>">
            <input type="hidden" id="" name="sender_id" value="<?php echo $view_message["sender_id"]; ?>">
            <input type="hidden" id="" name="header" value="<?php echo $view_message["header"]; ?>">

            <div class="form-group">
                <label for="reply">Reply with following content</label>
                <textarea class="form-control" id="reply" name="reply" id="reply" rows="3"></textarea>  
            </div>

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Reply">
        </form>   
    </section>      

    <section class="container" id="">
        <h2>Remove message</h2>

        <form action=<?php echo htmlspecialchars("process_removemessage.php"); ?> method="post">
            <input type="hidden" id="" name="id" value="<?php echo $view_message["id"]; ?>">

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Remove">
        </form>
    </section>    

    <section class="container" id="">
    <?php
        echo "<a href=\"" . htmlspecialchars("messages.php") . "\">Back to messages</a>";
    ?>
    </section>

<?php

    include("__/php/footer.php");
?>