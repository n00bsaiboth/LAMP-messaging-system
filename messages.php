<?php
    session_start();

    include("__/php/functions.php");
    include("__/php/config.php");

    include("__/php/header.php");

    if(isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
      $id = validate($_SESSION["id"]);
      $id = filter_var($id, FILTER_VALIDATE_INT);
      
      // this settype seems to mess something up, because
      // the id number is not updating into profile file.
      
      // $id = settype($id, "integer");

      // try another way to do it, see if it works

      $id = (int) $id; 
    }

    if(!isset($_SESSION["id"]) && empty($_SESSION["id"])) {
      $_SESSION["error"] = "Not so fast, it looks like you have not logged in yet. You need to be logged in to send new message. ";

      header("Location: error.php");
    } else {
?>

<section class="container" id="messages">
    <h2>Welcome to messages</h2>
    <?php


      if(isset($id) && !empty($id)) {
        getNewMessages($dbh, $id);
      } else {
        echo "<p>No new messages. </p>";
      }

      

      
    ?>
    
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
  }
  
  include("__/php/footer.php");
?>