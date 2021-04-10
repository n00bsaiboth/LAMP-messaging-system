<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    include("__/php/header.php");
?>


    <section class="container" id="register">
        <h2>Register</h2>

        <form action="<?php echo htmlspecialchars("process_registration.php"); ?>" method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" name="username" id="username">      
            </div>

            <div class="form-group">
            <label for="password">Password: </label>
                <input type="password" class="form-control" name="password" id="password">   
            </div>

            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Register">
        </form>

    </section>


<?php
    include("__/php/footer.php");
?>