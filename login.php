<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    include("__/php/header.php");
?>


    <section class="container" id="login">
        <h2>Login</h2>
        <?php
            if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
                echo "<p>You're already logged in. </p>";
                echo "<a href=\"" . htmlspecialchars("index.php") . "\">Back to frontpage</a>";
            } else {
        ?>
        <form action="<?php echo htmlspecialchars("process_login.php"); ?>" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" name="username" id="username">      
            </div>

            <div class="form-group">
            <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" id="password">   
            </div>

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Login">
        </form> 
        <?php
            }
        ?>
    </section>

    <section class="container" id="register">
       <hr>

        <?php 
            if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
                echo "<a href=\"" . htmlspecialchars("logout.php") . "\">Logout</a>";
            } else {
                echo "<a href=\"" . htmlspecialchars("register.php") . "\">Register</a>";

            }
        ?>   
    </section>

<?php
    include("__/php/footer.php");
?>