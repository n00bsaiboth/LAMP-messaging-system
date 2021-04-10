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

    // calling the getProfileDetails function from the
    // config file, where lies all the rest of the SQL 

    $row = getProfileDetails($dbh, $id);

    include("__/php/header.php");
?>


    <section class="container" id="profile">
        <h2>Profile</h2>

        <?php 
		    if(isset($row) && !empty($row)) {
                echo "<p>ID: " . $row["id"] . "</p>";
                echo "<p>Username: " . $row["username"] . "</p>";
                echo "<p>Password: " . $row["password"] . "</p>";
            } else {
                $_SESSION["error"] = "Unfortunately, we couldn't find the following profile that matches with the ID-number. Actually we think that there was no ID-number.";

                header("Location: error.php");
            }
        ?>
    </section>

    <hr />

    <section class="container" id="updatepassword">
        <h2>Update password </h2>    

        <form action="<?php echo htmlspecialchars("process_updatepassword.php"); ?>" method="post">
            <!--
            <div class="form-group">
                <label for="currentpassword">Current password: </label>
                <input type="password" class="form-control" name="currentpassword" id="currentpassword">      
            </div>
            -->

            <div class="form-group">
            <label for="newpassword">New password: </label>
                <input type="password" class="form-control" name="newpassword" id="newpassword">   
            </div>

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Update password">
        </form> 
    </section>

    <hr />

    <section class="container" id="removeuser">
        <h2>Remove user </h2>      


        <form action="<?php echo htmlspecialchars("process_removeuser.php"); ?>" method="post">


            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Remove user">
        </form> 
    </section>    

    <hr />

    <section class="container" id="">
    <?php
        echo "<a href=\"" . htmlspecialchars("index.php") . "\">Back to frontpage</a>";
    ?>
    </section>

<?php
    include("__/php/footer.php");
?>