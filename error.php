<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    if(isset($_SESSION["error"]) && !empty($_SESSION["error"])) {
        $error = validate($_SESSION["error"]);
        $error = filter_var($error, FILTER_SANITIZE_STRING);
    }

    include("__/php/header.php");

?>

    <section class="container" id="error">
        <div class="jumbotron">
        <h1 class="display-4">Oops, something went wrong!</h1>
        <hr class="my-4">
        <p>
        <?php
            if(isset($error) && !empty($error)) {
                echo $error;
            }          
        ?>
        </p>
        <p class="lead"><a href="index.php">Return to frontpage</a></p>
        </div>
    </section>

    <?php
        include("__/php/footer.php");
    ?>