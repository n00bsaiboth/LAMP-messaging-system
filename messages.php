<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    include("__/php/header.php");
?>

<section class="container" id="messages">
    <h2>Welcome to messages</h2>
    <?php


      $articles = getNewMessages($dbh, $_SESSION["id"]);

       print_r ($articles["header"]);
    ?>
    <p>No new messages. </p>
</section>

<section class="container" id="sendnewmessage">
  <h2>Send message to</h2>

  <form  action=<?php echo htmlspecialchars("process_sendmessage.php"); ?> method="post">
    <div class="form-group">
      <label for="username">Username: </label>
      <input type="text" class="form-control" name="username" id="username">      
    </div>
    <div class="form-group">
      <label for="header">Header: </label>
      <input type="text" class="form-control" name="header" id="header">      
    </div>
    <div class="form-group">
    <label for="message">Message</label>
    <textarea class="form-control" id="message" name="message" id="message" rows="3"></textarea>  
    </div>
    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Send">
  </form>
</section>

<?php
  include("__/php/footer.php");
?>