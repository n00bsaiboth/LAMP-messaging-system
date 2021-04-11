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
    }

    $message = getSingleMessage($dbh, $message_id);

    include("__/php/header.php");
?>


    <section class="container" id="profile">
        <h2>Profile</h2>

        <?php 
		    if(isset($message) && !empty($message)) {
                echo "<p>ID: " . $message["id"] . "</p>";
                echo "<p>Header: " . $message["header"] . "</p>";
                echo "<p>Encrypted Message: " . $message["message"] . "</p>";
                // openssl_decrypt($encrypted_string, "AES-128-ECB", $key)
                echo "<p>Message in plain text: " . openssl_decrypt($message["message"], "AES-128-ECB", $_SESSION["username"]) . "</p>";
            } else {
                $_SESSION["error"] = "Unfortunately, we couldn't find the following profile that matches with the ID-number. Actually we think that there was no ID-number.";

                header("Location: error.php");
            }
        ?>
    </section>

    <section class="container" id="">
    <?php
        echo "<a href=\"" . htmlspecialchars("index.php") . "\">Back to frontpage</a>";
    ?>
    </section>

<?php
    include("__/php/footer.php");
?>